<?php
declare(strict_types=1);

namespace App\Core;

/**
 * ==============================================================================
 * Antigravity Hybrid Rendering Engine (SSR / ISR / SSG) for PHP
 * ==============================================================================
 * 
 * High-performance, zero-dependency caching and HTML optimization engine designed
 * to drop Time-To-First-Byte (TTFB) below 50-100ms and maximize Crawl Budget
 * efficiency for Googlebot, PerplexityBot, GPTBot, and ClaudeBot (GEO / AEO).
 * 
 * Key Architecture Highlights:
 *  - ISR (Incremental Static Regeneration): Automatic background/on-demand stale check.
 *  - SSG (Static Site Generation): Pre-renders pages directly to .html snapshots.
 *  - Smart HTML Minifier: Strips whitespace and comments while strictly protecting
 *    JSON-LD (<script type="application/ld+json">), <pre>, <code>, and <textarea>.
 *  - Intelligent Invalidation: Surgical purge per URL or bulk purge.
 *  - HTTP 304 Not Modified & ETag support to slash bandwidth & server load.
 * 
 * @author Mohammad Moftakhari (Mohammad MR)
 * @license MIT
 */
class CacheManager
{
    /** @var self|null Singleton instance */
    private static ?self $instance = null;

    /** @var array<string, mixed> Configuration options */
    private array $config = [
        'cache_dir'        => '',                   // Absolute directory path for HTML files
        'default_ttl'      => 86400,                // 24 hours in seconds (ISR interval)
        'enable_minify'    => true,                 // Minify HTML output before saving
        'enable_304'       => true,                 // Support If-Modified-Since HTTP 304
        'bypass_cookies'   => ['admin_logged_in', 'admin_id', 'logged_in', 'PHPSESSID_ADMIN'],
        'bypass_uris'      => ['/admin', '/login', '/api', '/webhook', '/bale-webhook', '/bot-webhook'],
        'bypass_query_params' => ['search', 'q', 'nocache', 'preview', 'filter', 's'],
        'strip_tracking_params' => true,            // Ignore utm_*, fbclid, gclid when building cache key
    ];

    /** @var string|null Active cache file path for current request */
    private ?string $currentCacheFile = null;

    /** @var bool Flag if current request is being cached */
    private bool $isCaching = false;

    /** @var string Active normalized URI */
    private string $normalizedUri = '';

    /**
     * Private constructor for singleton / factory.
     */
    public function __construct(array $customConfig = [])
    {
        // Detect default cache path if not provided
        $defaultDir = defined('ROOT_PATH')
            ? ROOT_PATH . '/storage/cache/pages'
            : dirname(__DIR__, 2) . '/cache/pages';

        $this->config['cache_dir'] = $defaultDir;
        $this->config = array_merge($this->config, $customConfig);

        $this->ensureDirectoryExists($this->config['cache_dir']);
    }

    /**
     * Singleton instance getter.
     */
    public static function getInstance(array $customConfig = []): self
    {
        if (self::$instance === null) {
            self::$instance = new self($customConfig);
        }
        return self::$instance;
    }

    /**
     * Static quick-start entry point for single-line bootstrap in index.php
     * 
     * Usage in index.php:
     *   require_once __DIR__ . '/app/Core/CacheManager.php';
     *   \App\Core\CacheManager::start(['default_ttl' => 86400]);
     */
    public static function start(array $customConfig = []): void
    {
        $manager = self::getInstance($customConfig);
        $manager->handle();
    }

    /**
     * Core handler: checks cache, serves static HTML if valid, or registers buffer for ISR.
     */
    public function handle(): void
    {
        // 1. Check if request must bypass cache entirely
        if ($this->shouldBypass()) {
            $this->sendHeader('X-Render-Engine', 'SSR-BYPASS');
            return;
        }

        // 2. Generate deterministic cache key & file path
        $this->normalizedUri = $this->getNormalizedUri();
        $cacheKey = md5($this->normalizedUri);
        $this->currentCacheFile = rtrim($this->config['cache_dir'], '/\\') . DIRECTORY_SEPARATOR . $cacheKey . '.html';

        // 3. ISR Check: Does valid static cache exist?
        if (is_file($this->currentCacheFile)) {
            $fileTime = filemtime($this->currentCacheFile) ?: 0;
            $age = time() - $fileTime;
            $ttl = (int)$this->config['default_ttl'];

            if ($age < $ttl) {
                // ============================================================
                // CACHE HIT (Pure SSG / ISR Static Delivery) -> TTFB < 20ms
                // ============================================================
                $this->serveCachedFile($this->currentCacheFile, $fileTime, $age);
                exit; // Terminate PHP lifecycle immediately for maximum performance
            }
            // Age > TTL -> ISR Revalidation triggered (falls through to SSR & overwrite)
        }

        // 4. CACHE MISS / STALE -> Start Output Buffering to capture SSR render
        $this->isCaching = true;
        ob_start([$this, 'captureAndSave']);
    }

    /**
     * Output buffer callback: intercepts rendered HTML, minifies, writes to cache and returns.
     */
    public function captureAndSave(string $buffer): string
    {
        if (!$this->isCaching || empty($this->currentCacheFile)) {
            return $buffer;
        }

        // Only cache successful 200 OK responses
        $httpCode = http_response_code();
        if ($httpCode !== 200) {
            $this->sendHeader('X-Render-Engine', 'SSR-NON-200 (' . $httpCode . ')');
            return $buffer;
        }

        // Skip caching if output is empty or clearly not HTML
        if (trim($buffer) === '' || stripos($buffer, '<html') === false) {
            $this->sendHeader('X-Render-Engine', 'SSR-NON-HTML');
            return $buffer;
        }

        // Apply HTML Minification if enabled (GEO / Crawl Budget optimization)
        $processedHtml = $this->config['enable_minify']
            ? $this->minifyHtml($buffer)
            : $buffer;

        // Atomic file write to avoid race conditions under high concurrent traffic
        $tempFile = $this->currentCacheFile . '.' . uniqid('tmp_', true);
        if (@file_put_contents($tempFile, $processedHtml, LOCK_EX) !== false) {
            @rename($tempFile, $this->currentCacheFile);
            @chmod($this->currentCacheFile, 0664);
        } else {
            @unlink($tempFile);
        }

        // Inject diagnostic response headers
        $this->sendHeader('X-Render-Engine', 'ISR-REGENERATED');
        $this->sendHeader('X-Cache-Status', 'MISS-SAVED');
        $this->sendHeader('X-Cache-File', basename($this->currentCacheFile));

        return $processedHtml;
    }

    /**
     * Determines whether the current request must bypass the caching layer.
     */
    public function shouldBypass(): bool
    {
        // A) Only GET and HEAD requests can be cached
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        if (!in_array($method, ['GET', 'HEAD'], true)) {
            return true;
        }

        // B) CLI or cron script requests bypass
        if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
            return true;
        }

        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // C) Bypass admin and sensitive URL prefixes
        foreach ($this->config['bypass_uris'] as $bypassUri) {
            if (str_starts_with($uri, $bypassUri)) {
                return true;
            }
        }

        // D) Bypass if authenticated session or admin cookie is present
        if (!empty($_COOKIE)) {
            foreach ($this->config['bypass_cookies'] as $cookieName) {
                if (isset($_COOKIE[$cookieName]) && !empty($_COOKIE[$cookieName])) {
                    return true;
                }
            }
        }

        // Check active PHP session if already started
        if (session_status() === PHP_SESSION_ACTIVE) {
            if (!empty($_SESSION['admin_id']) || !empty($_SESSION['user_id']) || !empty($_SESSION['auth'])) {
                return true;
            }
        }

        // E) Bypass dynamic query parameters (e.g. ?search=, ?nocache=1, ?filter=)
        if (!empty($_GET)) {
            foreach ($this->config['bypass_query_params'] as $param) {
                if (isset($_GET[$param])) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Serves static HTML directly with HTTP 304 validation and caching headers.
     */
    private function serveCachedFile(string $filePath, int $fileTime, int $age): void
    {
        $eTag = '"' . md5((string)$fileTime . filesize($filePath)) . '"';
        $gmtMtime = gmdate('D, d M Y H:i:s', $fileTime) . ' GMT';

        // HTTP 304 Not Modified validation for zero-bandwidth requests
        if ($this->config['enable_304']) {
            $ifNoneMatch = $_SERVER['HTTP_IF_NONE_MATCH'] ?? '';
            $ifModifiedSince = $_SERVER['HTTP_IF_MODIFIED_SINCE'] ?? '';

            if (($ifNoneMatch && trim($ifNoneMatch) === $eTag) ||
                ($ifModifiedSince && strtotime($ifModifiedSince) === $fileTime)) {
                header('HTTP/1.1 304 Not Modified', true, 304);
                header('X-Render-Engine: ISR-HIT-304');
                exit;
            }
        }

        // High-Speed HTTP Response Headers
        header('Content-Type: text/html; charset=UTF-8');
        header('Cache-Control: public, max-age=300, s-maxage=' . $this->config['default_ttl'] . ', stale-while-revalidate=86400');
        header('ETag: ' . $eTag);
        header('Last-Modified: ' . $gmtMtime);
        header('Age: ' . $age);
        header('X-Render-Engine: ISR-HIT');
        header('X-Cache-Status: HIT');
        header('X-Cache-Age: ' . $age . 's');
        header('X-Cache-File: ' . basename($filePath));

        readfile($filePath);
    }

    /**
     * Smart HTML Minifier (GEO & SEO Optimized)
     * Strips unnecessary whitespace, newlines, and comments while safely preserving
     * sensitive blocks: <pre>, <code>, <textarea>, <script>, and JSON-LD structured schemas.
     */
    public function minifyHtml(string $html): string
    {
        // 1. Temporarily extract and safeguard sensitive tags (scripts, styles, pre, code, textarea)
        $placeholders = [];
        $patterns = [
            '#<script[^>]*>(.*?)</script>#is',
            '#<style[^>]*>(.*?)</style>#is',
            '#<pre[^>]*>(.*?)</pre>#is',
            '#<code[^>]*>(.*?)</code>#is',
            '#<textarea[^>]*>(.*?)</textarea>#is',
        ];

        foreach ($patterns as $pattern) {
            $html = preg_replace_callback($pattern, function ($matches) use (&$placeholders) {
                $key = '___PROTECTED_BLOCK_' . count($placeholders) . '___';
                $placeholders[$key] = $matches[0];
                return $key;
            }, $html);
        }

        // 2. Remove standard HTML comments (preserving conditional comments if any)
        $html = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $html);

        // 3. Compress multiple whitespaces, tabs, and line breaks
        $search = [
            '/\r+/',                          // Convert carriage returns
            '/\t+/',                          // Convert tabs to space
            '/\s{2,}/',                       // Multiple spaces into one
            '/\n\s+/',                        // Leading space after newline
            '/\s+\n/',                        // Trailing space before newline
            '/>\s+</',                        // Space between tags
        ];
        $replace = [
            '',
            ' ',
            ' ',
            "\n",
            "\n",
            '><',
        ];
        $html = preg_replace($search, $replace, $html);

        // 4. Restore safeguarded tags in their exact pristine formatting
        if (!empty($placeholders)) {
            $html = str_replace(array_keys($placeholders), array_values($placeholders), $html);
        }

        return trim($html);
    }

    /**
     * Purges cached pages (Cache Invalidation).
     * 
     * @param string|null $url Single URL to invalidate, or null to purge everything.
     * @return int Number of deleted cache files.
     */
    public function clearCache(?string $url = null): int
    {
        $cacheDir = rtrim($this->config['cache_dir'], '/\\');
        if (!is_dir($cacheDir)) {
            return 0;
        }

        // Case 1: Invalidate a specific URL
        if ($url !== null && $url !== '' && $url !== '*') {
            $normalized = $this->normalizeCustomUrl($url);
            $cacheKey = md5($normalized);
            $filePath = $cacheDir . DIRECTORY_SEPARATOR . $cacheKey . '.html';

            if (is_file($filePath)) {
                return @unlink($filePath) ? 1 : 0;
            }
            return 0;
        }

        // Case 2: Flush all cached HTML pages
        $deletedCount = 0;
        $files = glob($cacheDir . DIRECTORY_SEPARATOR . '*.html');
        if (is_array($files)) {
            foreach ($files as $file) {
                if (is_file($file) && @unlink($file)) {
                    $deletedCount++;
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Helper to set custom response headers if headers haven't been sent.
     */
    private function sendHeader(string $name, string $value): void
    {
        if (!headers_sent()) {
            header($name . ': ' . $value);
        }
    }

    /**
     * Normalizes current request URI for deterministic hashing.
     */
    private function getNormalizedUri(): string
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        return $this->normalizeCustomUrl($uri);
    }

    /**
     * Cleans tracking query parameters (utm_*, gclid, fbclid) to prevent cache fragmentation.
     */
    private function normalizeCustomUrl(string $url): string
    {
        $parts = parse_url($url);
        $path = $parts['path'] ?? '/';

        // Normalize trailing slash (keep root as '/')
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        $query = '';
        if ($this->config['strip_tracking_params'] && !empty($parts['query'])) {
            parse_str($parts['query'], $queryParams);
            $ignored = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'fbclid', 'gclid', 'yclid', '_ga'];
            foreach ($ignored as $key) {
                unset($queryParams[$key]);
            }
            if (!empty($queryParams)) {
                ksort($queryParams);
                $query = '?' . http_build_query($queryParams);
            }
        } elseif (!empty($parts['query'])) {
            $query = '?' . $parts['query'];
        }

        return $path . $query;
    }

    /**
     * Ensures target cache directory exists with strict permissions & .htaccess security.
     */
    private function ensureDirectoryExists(string $dir): void
    {
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }

        // Security: Prevent direct web execution/browsing inside storage directory
        $htaccessFile = rtrim($dir, '/\\') . DIRECTORY_SEPARATOR . '.htaccess';
        if (!is_file($htaccessFile)) {
            @file_put_contents(
                $htaccessFile,
                "# Deny direct web browsing of static HTML cache files\n<IfModule mod_authz_core.c>\n    Require all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\n    Order deny,allow\n    Deny from all\n</IfModule>\n"
            );
        }
    }
}
