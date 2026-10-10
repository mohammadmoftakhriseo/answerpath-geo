<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;

/**
 * Cloudflare Service
 * Mohammad Moftakhari Website (maaadmr.ir)
 *
 * Handles Cloudflare API v4 interactions:
 * - Instant Selective Edge Cache Purging (Homepage, Articles, Sitemap)
 * - Complete Zone Cache Purging
 * - Core Web Vitals & Speed Settings Optimization (Early Hints, Brotli, HTTP/3, Minify)
 * - Development Mode Toggle (3-hour cache bypass for live testing)
 * - Security Level & Under Attack Mode Activation (DDoS/Spam protection)
 * - Zone Status & Health Verification
 */
class CloudflareService
{
    private string $apiToken;
    private string $authEmail;
    private string $zoneId;
    private string $domain;
    private string $baseUrl;
    private bool $enabled;
    private int $timeout;
    private int $connectTimeout;

    public function __construct(?string $apiToken = null, ?string $zoneId = null, ?string $authEmail = null)
    {
        $config = [];
        $configFile = dirname(__DIR__, 2) . '/config/cloudflare.php';
        if (file_exists($configFile)) {
            $config = require $configFile;
        }

        $this->apiToken  = $apiToken  ?: ($config['api_token'] ?? SiteSetting::get('cloudflare_api_token', ''));
        $this->authEmail = $authEmail ?: ($config['auth_email'] ?? SiteSetting::get('cloudflare_email', ''));
        $this->zoneId    = $zoneId    ?: ($config['zone_id'] ?? SiteSetting::get('cloudflare_zone_id', ''));
        $this->domain    = rtrim($config['domain'] ?? SiteSetting::get('site_url', 'https://maaadmr.ir'), '/');
        $this->baseUrl   = rtrim($config['base_url'] ?? 'https://api.cloudflare.com/client/v4', '/');
        $this->enabled   = (bool)($config['enabled'] ?? (SiteSetting::get('cloudflare_enabled', '1') !== '0'));
        $this->timeout   = (int)($config['timeout'] ?? 8);
        $this->connectTimeout = (int)($config['connect_timeout'] ?? 4);
    }

    /**
     * بررسی تنظیم بودن توکن و شناسه زون کلودفلر
     */
    public function isConfigured(): bool
    {
        return !empty($this->apiToken) && !empty($this->zoneId) && $this->enabled;
    }

    /**
     * پاکسازی انتخابی کش برای لیستی از URLها (Selective Cache Purge)
     * این متد بسیار سریع است و فقط صفحات تغییریافته را بدون افت سرعت سایر صفحات پاک می‌کند.
     *
     * @param array<string> $urls
     * @return array{success: bool, purged_count: int, message: string, raw?: array}
     */
    public function purgeUrls(array $urls): array
    {
        if (!$this->isConfigured()) {
            return [
                'success'      => false,
                'purged_count' => 0,
                'message'      => 'کلودفلر تنظیم یا فعال نشده است (API Token یا Zone ID مفقود است).'
            ];
        }

        $cleanUrls = [];
        foreach ($urls as $url) {
            $u = trim((string)$url);
            if (empty($u)) {
                continue;
            }

            // نرمال‌سازی URLها: در صورتی که مسیر نسبی مثل /articles باشد، به دامنه کامل تبدیل شود
            if (str_starts_with($u, '/')) {
                $cleanUrls[] = $this->domain . $u;
            } elseif (!str_starts_with($u, 'http://') && !str_starts_with($u, 'https://')) {
                $cleanUrls[] = $this->domain . '/' . ltrim($u, '/');
            } else {
                $cleanUrls[] = $u;
            }
        }

        $cleanUrls = array_values(array_unique($cleanUrls));

        if (empty($cleanUrls)) {
            return [
                'success'      => true,
                'purged_count' => 0,
                'message'      => 'آدرسی برای پاکسازی ارسال نشده است.'
            ];
        }

        $endpoint = "/zones/{$this->zoneId}/purge_cache";
        $payload = [
            'files' => $cleanUrls
        ];

        $response = $this->sendRequest('POST', $endpoint, $payload);

        if (!empty($response['success'])) {
            $this->log("Selective purge succeeded for " . count($cleanUrls) . " URLs: " . implode(', ', $cleanUrls));
            return [
                'success'      => true,
                'purged_count' => count($cleanUrls),
                'message'      => "کش کلودفلر برای " . count($cleanUrls) . " آدرس با موفقیت پاکسازی شد.",
                'raw'          => $response
            ];
        }

        $errorMsg = $this->extractErrorMessage($response);
        $this->log("Selective purge failed: {$errorMsg}", 'ERROR');

        return [
            'success'      => false,
            'purged_count' => 0,
            'message'      => "خطا در پاکسازی کش کلودفلر: {$errorMsg}",
            'raw'          => $response
        ];
    }

    /**
     * پاکسازی اختصاصی کش مربوط به یک مقاله پس از ایجاد یا ویرایش
     * (شامل صفحه خود مقاله، آرشیو مقالات، صفحه اصلی و سایت‌مپ)
     */
    public function purgeArticle(string $slug): array
    {
        $urlsToPurge = [
            $this->domain . '/',
            $this->domain . '/articles',
            $this->domain . '/articles/' . urlencode($slug),
            $this->domain . '/sitemap.xml',
        ];

        return $this->purgeUrls($urlsToPurge);
    }

    /**
     * پاکسازی کامل تمام فایل‌ها و صفحات کش شده در کلودفلر (Purge Everything)
     * توجه: توصیه می‌شود فقط هنگام تغییر قالب یا آپدیت کلی استفاده شود تا اثر کش از بین نرود.
     */
    public function purgeEverything(): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'کلودفلر تنظیم یا فعال نشده است.'
            ];
        }

        $endpoint = "/zones/{$this->zoneId}/purge_cache";
        $payload = ['purge_everything' => true];

        $response = $this->sendRequest('POST', $endpoint, $payload);

        if (!empty($response['success'])) {
            $this->log("Purge Everything succeeded.");
            return [
                'success' => true,
                'message' => 'تمام حافظه موقت (Cache) کلودفلر برای کل وب‌سایت با موفقیت پاکسازی شد.',
                'raw'     => $response
            ];
        }

        $errorMsg = $this->extractErrorMessage($response);
        $this->log("Purge Everything failed: {$errorMsg}", 'ERROR');

        return [
            'success' => false,
            'message' => "خطا در پاکسازی کامل کش کلودفلر: {$errorMsg}",
            'raw'     => $response
        ];
    }

    /**
     * دریافت اطلاعات وضعیت دامنه در کلودفلر (Zone Details & Status)
     */
    public function getZoneDetails(): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'message' => 'کلودفلر کانفیگ نشده است.'];
        }

        $endpoint = "/zones/{$this->zoneId}";
        $response = $this->sendRequest('GET', $endpoint);

        if (!empty($response['success']) && isset($response['result'])) {
            $res = $response['result'];
            return [
                'success'      => true,
                'name'         => $res['name'] ?? '',
                'status'       => $res['status'] ?? 'unknown',
                'plan'         => $res['plan']['name'] ?? 'Free',
                'name_servers' => $res['name_servers'] ?? [],
                'raw'          => $res
            ];
        }

        return [
            'success' => false,
            'message' => $this->extractErrorMessage($response),
            'raw'     => $response
        ];
    }

    /**
     * فعال‌سازی یا غیرفعال‌سازی حالت توسعه (Development Mode)
     * حالت توسعه به مدت ۳ ساعت کشینگ کلودفلر را متوقف می‌کند تا تغییرات فایل‌ها مستقیماً از مبدا لود شوند.
     */
    public function toggleDevelopmentMode(bool $enable): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'message' => 'کلودفلر کانفیگ نشده است.'];
        }

        $endpoint = "/zones/{$this->zoneId}/settings/development_mode";
        $payload = ['value' => $enable ? 'on' : 'off'];

        $response = $this->sendRequest('PATCH', $endpoint, $payload);

        if (!empty($response['success'])) {
            $stateStr = $enable ? 'روشن (فعال)' : 'خاموش (غیرفعال)';
            return [
                'success' => true,
                'mode'    => $enable ? 'on' : 'off',
                'message' => "حالت توسعه (Development Mode) با موفقیت {$stateStr} شد."
            ];
        }

        return [
            'success' => false,
            'message' => $this->extractErrorMessage($response)
        ];
    }

    /**
     * تنظیم سطح امنیت دامنه یا فعال‌سازی حالت تحت حمله (Under Attack Mode)
     *
     * @param string $level 'essentially_off' | 'low' | 'medium' | 'high' | 'under_attack'
     */
    public function setSecurityLevel(string $level): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'message' => 'کلودفلر کانفیگ نشده است.'];
        }

        $validLevels = ['essentially_off', 'low', 'medium', 'high', 'under_attack'];
        if (!in_array($level, $validLevels, true)) {
            return ['success' => false, 'message' => 'سطح امنیت نامعتبر است. سطوح مجاز: ' . implode(', ', $validLevels)];
        }

        $endpoint = "/zones/{$this->zoneId}/settings/security_level";
        $payload = ['value' => $level];

        $response = $this->sendRequest('PATCH', $endpoint, $payload);

        if (!empty($response['success'])) {
            return [
                'success' => true,
                'level'   => $level,
                'message' => "سطح امنیت کلودفلر به حالت {$level} تغییر یافت."
            ];
        }

        return [
            'success' => false,
            'message' => $this->extractErrorMessage($response)
        ];
    }

    /**
     * فعال یا غیرفعال‌سازی سریع حالت تحت حمله (Under Attack Mode)
     */
    public function toggleUnderAttackMode(bool $enable): array
    {
        return $this->setSecurityLevel($enable ? 'under_attack' : 'medium');
    }

    /**
     * بهینه‌سازی خودکار تنظیمات سرعت و Core Web Vitals دامنه
     * فعال‌سازی Early Hints، فشرده‌سازی Brotli، پروتکل HTTP/3، 0-RTT و Minification
     */
    public function optimizeSpeedSettings(): array
    {
        if (!$this->isConfigured()) {
            return ['success' => false, 'message' => 'کلودفلر کانفیگ نشده است.'];
        }

        $results = [];

        $settings = [
            'early_hints'     => ['value' => 'on'],
            'brotli'          => ['value' => 'on'],
            'http3'           => ['value' => 'on'],
            '0rtt'            => ['value' => 'on'],
            'minify'          => ['value' => ['css' => 'on', 'html' => 'on', 'js' => 'on']],
            'always_use_https'=> ['value' => 'on'],
        ];

        foreach ($settings as $settingKey => $payload) {
            $endpoint = "/zones/{$this->zoneId}/settings/{$settingKey}";
            $res = $this->sendRequest('PATCH', $endpoint, $payload);
            $results[$settingKey] = !empty($res['success']);
        }

        return [
            'success' => true,
            'applied' => $results,
            'message' => 'تنظیمات شتاب‌دهنده سرعت و پرفورمنس کلودفلر اعمال گردید.'
        ];
    }

    /**
     * ارسال امن درخواست cURL به Cloudflare API v4
     */
    private function sendRequest(string $method, string $endpoint, ?array $payload = null): array
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'Content-Type: application/json',
            'Accept: application/json',
        ];

        if (!empty($this->authEmail)) {
            $headers[] = 'X-Auth-Email: ' . $this->authEmail;
            $headers[] = 'X-Auth-Key: ' . $this->apiToken;
        } else {
            $headers[] = 'Authorization: Bearer ' . $this->apiToken;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($payload !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
            }
        } elseif ($method === 'PATCH') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            if ($payload !== null) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_SLASHES));
            }
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $rawResponse = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            $this->log("cURL Error ({$url}): {$curlError}", 'ERROR');
            return [
                'success' => false,
                'errors'  => [['message' => "Connection Error: {$curlError}"]]
            ];
        }

        $decoded = json_decode((string)$rawResponse, true);
        if (!is_array($decoded)) {
            $this->log("Invalid JSON response from Cloudflare: " . substr((string)$rawResponse, 0, 200), 'ERROR');
            return [
                'success'   => false,
                'http_code' => $httpCode,
                'errors'    => [['message' => "HTTP {$httpCode}: پاسخ نامعتبر از سرور کلودفلر"]]
            ];
        }

        return $decoded;
    }

    /**
     * استخراج متن خطا از ساختار استاندارد پاسخ Cloudflare
     */
    private function extractErrorMessage(array $response): string
    {
        if (!empty($response['errors']) && is_array($response['errors'])) {
            $msgs = [];
            foreach ($response['errors'] as $err) {
                $code = $err['code'] ?? '';
                $msg = $err['message'] ?? 'خطای نامشخص';
                $msgs[] = $code ? "[{$code}] {$msg}" : $msg;
            }
            return implode(' | ', $msgs);
        }

        return $response['message'] ?? 'پاسخ ناموفق از سرور کلودفلر بدون جزئیات خطا.';
    }

    /**
     * ثبت لاگ در فایل اختصاصی cloudflare.log
     */
    private function log(string $message, string $level = 'INFO'): void
    {
        $baseDir = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        $logFile = $baseDir . '/cloudflare.log';
        $logLine = date('Y-m-d H:i:s') . " [{$level}] {$message}\n";
        @file_put_contents($logFile, $logLine, FILE_APPEND);
    }
}
