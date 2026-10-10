<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Env;

/**
 * Enterprise GitHub REST API Sync & Cloud Backup Service
 * 
 * Target Repository: https://github.com/mohammadmoftakhriseo/answerpath-geo
 * GitHub REST API Specs: https://docs.github.com/en/rest/repos/contents#create-or-update-file-contents
 */
class GitHubSyncService
{
    private string $token;
    private string $owner;
    private string $repo;
    private string $branch;
    private bool $enabled;
    private string $apiUrl;
    private string $apiVersion;
    private string $userAgent;
    private int $timeout;

    public function __construct(?array $config = null)
    {
        if ($config === null) {
            $configFile = defined('ROOT_PATH') ? (ROOT_PATH . '/config/github.php') : (dirname(__DIR__, 2) . '/config/github.php');
            if (file_exists($configFile)) {
                $config = require $configFile;
            } else {
                $config = [];
            }
        }

        $this->token       = (string)($config['token'] ?? Env::get('GITHUB_TOKEN', ''));
        $this->owner       = (string)($config['owner'] ?? Env::get('GITHUB_OWNER', 'mohammadmoftakhriseo'));
        $this->repo        = (string)($config['repo'] ?? Env::get('GITHUB_REPO', 'answerpath-geo'));
        $this->branch      = (string)($config['branch'] ?? Env::get('GITHUB_BRANCH', 'main'));
        $this->enabled     = (bool)($config['enabled'] ?? Env::get('GITHUB_ENABLED', true));
        $this->apiUrl      = rtrim((string)($config['api_url'] ?? 'https://api.github.com'), '/');
        $this->apiVersion  = (string)($config['api_version'] ?? '2022-11-28');
        $this->userAgent   = (string)($config['user_agent'] ?? 'MaaadMR-CMS-SyncEngine/1.0');
        $this->timeout     = (int)($config['timeout'] ?? 15);
    }

    /**
     * بررسی فعال بودن و وجود توکن معتبر
     */
    public function isConfigured(): bool
    {
        return $this->enabled && !empty($this->token) && !str_starts_with($this->token, 'your_');
    }

    /**
     * دریافت اطلاعات و محتوای یک فایل از ریپازیتوری
     * 
     * @return array{sha: string, content: string, size: int}|null
     */
    public function getFile(string $filePath, ?string $branch = null): ?array
    {
        if (!$this->isConfigured()) {
            return null;
        }

        $cleanPath = ltrim($filePath, '/');
        $targetBranch = $branch ?: $this->branch;
        $url = "{$this->apiUrl}/repos/{$this->owner}/{$this->repo}/contents/{$cleanPath}?ref=" . urlencode($targetBranch);

        $response = $this->request('GET', $url);
        if ($response['status'] === 200 && is_array($response['body'])) {
            $rawContent = '';
            if (!empty($response['body']['content']) && ($response['body']['encoding'] ?? '') === 'base64') {
                $rawContent = (string)base64_decode(str_replace(["\n", "\r", ' '], '', $response['body']['content']));
            }

            return [
                'sha'     => (string)($response['body']['sha'] ?? ''),
                'content' => $rawContent,
                'size'    => (int)($response['body']['size'] ?? 0),
                'path'    => (string)($response['body']['path'] ?? $cleanPath),
            ];
        }

        return null;
    }

    /**
     * ایجاد یا بروزرسانی مستقیم یک فایل در گیت‌هاب (Create or Update File Contents)
     * 
     * @param string $filePath مسیر فایل در ریپازیتوری (مثلا data/leads.json)
     * @param string $content محتوای خام فایل
     * @param string $commitMessage پیام کامیت
     * @param string|null $branch نام برنچ (پیش‌فرض: main)
     * @return array{success: bool, status: int, message: string, sha?: string, commit_sha?: string}
     */
    public function pushFile(string $filePath, string $content, string $commitMessage, ?string $branch = null): array
    {
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'status'  => 0,
                'message' => 'GitHub integration is disabled or GITHUB_TOKEN is not configured in .env'
            ];
        }

        $cleanPath = ltrim($filePath, '/');
        $targetBranch = $branch ?: $this->branch;
        $url = "{$this->apiUrl}/repos/{$this->owner}/{$this->repo}/contents/{$cleanPath}";

        // مکانیزم Retry تا ۳ مرتبه در صورت بروز خطای 409 Conflict (تغییر همزمان فایل در برنچ)
        $maxRetries = 3;
        $attempt = 0;

        while ($attempt < $maxRetries) {
            $attempt++;

            // ۱. بررسی فایل موجود برای استخراج SHA
            $existing = $this->getFile($cleanPath, $targetBranch);
            $sha = $existing['sha'] ?? null;

            // ۲. ساخت پی‌لود درخواست PUT بر اساس استاندارد رسمی GitHub REST API
            $payload = [
                'message' => $commitMessage,
                'content' => base64_encode($content),
                'branch'  => $targetBranch
            ];

            if (!empty($sha)) {
                $payload['sha'] = $sha;
            }

            $response = $this->request('PUT', $url, $payload);
            $statusCode = $response['status'];

            // موفقیت (200 OK برای آپدیت یا 201 Created برای ساخت فایل جدید)
            if ($statusCode === 200 || $statusCode === 201) {
                $commitSha = $response['body']['commit']['sha'] ?? '';
                $contentSha = $response['body']['content']['sha'] ?? '';

                $this->logInfo("Successfully synced {$cleanPath} to GitHub [Commit: {$commitSha}]");

                return [
                    'success'    => true,
                    'status'     => $statusCode,
                    'message'    => "File {$cleanPath} synced successfully.",
                    'sha'        => $contentSha,
                    'commit_sha' => $commitSha
                ];
            }

            // در صورت 409 Conflict، پس از اندکی تاخیر مجددا SHA تازه را دریافت می‌کنیم
            if ($statusCode === 409 && $attempt < $maxRetries) {
                usleep(500000); // 500ms delay
                continue;
            }

            $errMsg = $response['body']['message'] ?? "HTTP error {$statusCode}";
            $this->logError("GitHub push failed for {$cleanPath} (Status {$statusCode}): {$errMsg}");

            return [
                'success' => false,
                'status'  => $statusCode,
                'message' => "GitHub API Error ({$statusCode}): {$errMsg}"
            ];
        }

        return [
            'success' => false,
            'status'  => 409,
            'message' => "Push failed after {$maxRetries} attempts due to SHA concurrency conflict."
        ];
    }

    /**
     * افزودن یک آیتم جدید به فایل آرایه JSON در گیت‌هاب (Append to JSON array)
     * در صورت عدم وجود فایل، فایل جدید با آرایه حاوی آیتم ساخته می‌شود.
     */
    public function appendJsonArray(string $filePath, array $newRecord, string $commitMessage, ?string $branch = null): array
    {
        $existing = $this->getFile($filePath, $branch);
        $records = [];

        if ($existing && !empty($existing['content'])) {
            $decoded = json_decode($existing['content'], true);
            if (is_array($decoded)) {
                $records = $decoded;
            }
        }

        // افزودن متاداده‌های رهگیری زمانی
        if (!isset($newRecord['logged_at'])) {
            $newRecord['logged_at'] = date('Y-m-d H:i:s');
        }

        $records[] = $newRecord;

        $newJsonContent = json_encode($records, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $this->pushFile($filePath, (string)$newJsonContent, $commitMessage, $branch);
    }

    /**
     * ثبت لید جدید در ریپازیتوری (data/leads.json)
     */
    public function logLead(array $leadData, string $source = 'website'): array
    {
        $payload = array_merge([
            'id'         => uniqid('lead_', true),
            'source'     => $source,
            'ip'         => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'created_at' => date('Y-m-d H:i:s'),
        ], $leadData);

        $name = $leadData['name'] ?? ($leadData['full_name'] ?? 'New Lead');
        $commitMsg = "Lead: {$name} [{$source}] via automated webhook";

        return $this->appendJsonArray('data/leads.json', $payload, $commitMsg);
    }

    /**
     * ثبت درخواست نقشه راه و بریف هوش مصنوعی در ریپازیتوری (data/roadmaps.json)
     */
    public function logRoadmap(array $roadmapData): array
    {
        $website = $roadmapData['website_url'] ?? ($roadmapData['domain'] ?? 'New Roadmap');
        $commitMsg = "Roadmap: {$website} generated via AI Brief Engine";

        $payload = array_merge([
            'id'         => uniqid('map_', true),
            'created_at' => date('Y-m-d H:i:s'),
        ], $roadmapData);

        return $this->appendJsonArray('data/roadmaps.json', $payload, $commitMsg);
    }

    /**
     * ثبت لاگ سیستم یا اعلان‌های پیام‌رسان‌ها در ریپازیتوری (data/system_logs.json)
     */
    public function logEvent(string $eventType, array $eventData, ?string $customMessage = null): array
    {
        $commitMsg = $customMessage ?: "Log: {$eventType} at " . date('Y-m-d H:i:s');

        $payload = [
            'event'     => $eventType,
            'timestamp' => date('Y-m-d H:i:s'),
            'data'      => $eventData
        ];

        return $this->appendJsonArray('data/system_logs.json', $payload, $commitMsg);
    }

    /**
     * ارسال امن درخواست cURL به GitHub REST API
     */
    private function request(string $method, string $url, ?array $payload = null): array
    {
        $ch = curl_init($url);

        $headers = [
            'Accept: application/vnd.github+json',
            'Authorization: Bearer ' . $this->token,
            'X-GitHub-Api-Version: ' . $this->apiVersion,
            'User-Agent: ' . $this->userAgent,
        ];

        $opts = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
        ];

        if ($payload !== null) {
            $opts[CURLOPT_POSTFIELDS] = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            $headers[] = 'Content-Type: application/json; charset=utf-8';
            $opts[CURLOPT_HTTPHEADER] = $headers;
        }

        curl_setopt_array($ch, $opts);

        $responseBody = curl_exec($ch);
        $statusCode   = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError    = curl_error($ch);
        curl_close($ch);

        if ($curlError !== '') {
            $this->logError("cURL Error on {$method} {$url}: {$curlError}");
            return [
                'status' => 0,
                'body'   => ['message' => "cURL network error: {$curlError}"]
            ];
        }

        $decodedBody = json_decode((string)$responseBody, true);
        if (!is_array($decodedBody)) {
            $decodedBody = ['raw' => (string)$responseBody];
        }

        return [
            'status' => $statusCode,
            'body'   => $decodedBody
        ];
    }

    private function logInfo(string $message): void
    {
        error_log("[GitHubSyncService] " . $message);
    }

    private function logError(string $message): void
    {
        error_log("[GitHubSyncService ERROR] " . $message);
    }

    /**
     * متد استاتیک سریع جهت پوش دادن یک فایل با یک خط کد
     */
    public static function push(string $filePath, string $content, string $commitMessage, ?string $branch = null): array
    {
        $service = new self();
        return $service->pushFile($filePath, $content, $commitMessage, $branch);
    }
}
