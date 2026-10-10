<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise HTTP Request Abstraction with Input Sanitization, IP Resolution & CSRF Validation
 */
class Request
{
    private string $method;
    private string $uri;
    private array $get;
    private array $post;
    private array $files;
    private array $server;
    private array $params = [];

    public function __construct()
    {
        $this->server = $_SERVER;
        $this->method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
        
        $uri = $this->server['REQUEST_URI'] ?? '/';
        $pos = strpos($uri, '?');
        if ($pos !== false) {
            $uri = substr($uri, 0, $pos);
        }
        $this->uri = '/' . trim($uri, '/');
        
        $this->get = is_array($_GET) ? sanitize_input($_GET) : [];
        $this->post = is_array($_POST) ? sanitize_input($_POST) : [];
        $this->files = $_FILES;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function isGet(): bool
    {
        return $this->method === 'GET';
    }

    public function isPost(): bool
    {
        return $this->method === 'POST';
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->post[$key] ?? $this->get[$key] ?? $this->params[$key] ?? $default;
    }

    /**
     * Get sanitized string input (Anti-XSS)
     */
    public function clean(string $key, string $default = ''): string
    {
        $val = $this->input($key, $default);
        if (!is_string($val)) {
            return $default;
        }
        return e(trim($val));
    }

    public function all(): array
    {
        return array_merge($this->get, $this->post, $this->params);
    }

    public function setParams(array $params): void
    {
        $this->params = $params;
    }

    public function param(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    public function file(string $key): ?array
    {
        return $this->files[$key] ?? null;
    }

    public function header(string $name, ?string $default = null): ?string
    {
        $key = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
        return $this->server[$key] ?? $default;
    }

    public function isAjax(): bool
    {
        return strtolower((string)($this->server['HTTP_X_REQUESTED_WITH'] ?? '')) === 'xmlhttprequest'
            || str_contains(strtolower((string)($this->server['HTTP_ACCEPT'] ?? '')), 'application/json');
    }

    /**
     * Validate CSRF token from POST body or X-CSRF-TOKEN header
     */
    public function validateCsrf(): bool
    {
        $token = $this->input('_csrf_token') 
            ?? $this->header('X-CSRF-TOKEN') 
            ?? $this->header('X-XSRF-TOKEN');

        return Session::validateCsrfToken(is_string($token) ? $token : null);
    }

    /**
     * Get clean, trusted client IP address behind Cloudflare / Reverse Proxies
     */
    public function ip(): string
    {
        // 1. Cloudflare Connecting IP (highest trust when behind Cloudflare)
        if (!empty($this->server['HTTP_CF_CONNECTING_IP'])) {
            $cfIp = trim((string)$this->server['HTTP_CF_CONNECTING_IP']);
            if (filter_var($cfIp, FILTER_VALIDATE_IP)) {
                return $cfIp;
            }
        }

        // 2. X-Forwarded-For header (take the first client IP in chain)
        if (!empty($this->server['HTTP_X_FORWARDED_FOR'])) {
            $ips = explode(',', (string)$this->server['HTTP_X_FORWARDED_FOR']);
            $clientIp = trim($ips[0]);
            if (filter_var($clientIp, FILTER_VALIDATE_IP)) {
                return $clientIp;
            }
        }

        // 3. X-Real-IP
        if (!empty($this->server['HTTP_X_REAL_IP'])) {
            $realIp = trim((string)$this->server['HTTP_X_REAL_IP']);
            if (filter_var($realIp, FILTER_VALIDATE_IP)) {
                return $realIp;
            }
        }

        // 4. Fallback to REMOTE_ADDR
        $remoteAddr = trim((string)($this->server['REMOTE_ADDR'] ?? '127.0.0.1'));
        return filter_var($remoteAddr, FILTER_VALIDATE_IP) ? $remoteAddr : '127.0.0.1';
    }
}
