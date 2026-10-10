<?php
declare(strict_types=1);

use App\Core\Env;
use App\Core\Session;

/**
 * Access environment variables safely
 */
function env(string $key, mixed $default = null): mixed
{
    return Env::get($key, $default);
}

/**
 * HTML Escaping for safe output rendering (Anti-XSS)
 */
function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * Clean & Sanitize Rich HTML (Strip dangerous scripts, iframes, and event handlers)
 */
function clean_xss(?string $dirtyHtml): string
{
    if (empty($dirtyHtml)) {
        return '';
    }

    $clean = (string)$dirtyHtml;

    // Remove <script> tags and contents
    $clean = preg_replace('/<script\b[^>]*>([\s\S]*?)<\/script>/i', '', $clean);

    // Remove <iframe>, <object>, <embed>, <applet> tags
    $clean = preg_replace('/<(iframe|object|embed|applet)\b[^>]*>([\s\S]*?)<\/\1>/i', '', $clean);
    $clean = preg_replace('/<(iframe|object|embed|applet)\b[^>]*\/?>/i', '', $clean);

    // Remove event handlers (onload, onerror, onclick, etc.)
    $clean = preg_replace('/\bon[a-zA-Z]+\s*=\s*(["\'])(.*?)\1/i', '', $clean);
    $clean = preg_replace('/\bon[a-zA-Z]+\s*=\s*[^ >]+/i', '', $clean);

    // Remove javascript: and data: pseudoprotocols from href and src (except safe base64 images)
    $clean = preg_replace('/\b(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*\2/i', '$1="#"', $clean);
    $clean = preg_replace('/\b(href)\s*=\s*(["\'])\s*data:[^"\']*\2/i', '$1="#"', $clean);

    return $clean;
}

/**
 * Recursive Input Sanitizer (strips null bytes, normalizes whitespace)
 */
function sanitize_input(mixed $data): mixed
{
    if (is_array($data)) {
        $result = [];
        foreach ($data as $k => $v) {
            $cleanKey = is_string($k) ? str_replace("\0", '', trim($k)) : $k;
            $result[$cleanKey] = sanitize_input($v);
        }
        return $result;
    }

    if (is_string($data)) {
        // Strip null bytes and control chars (except normal newlines and tabs)
        $clean = str_replace(["\0", "\x0B"], '', $data);
        return trim($clean);
    }

    return $data;
}

/**
 * Generate full URL
 */
function url(string $path = ''): string
{
    $protocol = (
        (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ||
        (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') ||
        (!empty($_SERVER['HTTP_CF_VISITOR']) && str_contains($_SERVER['HTTP_CF_VISITOR'], 'https')) ||
        (!empty($_SERVER['SERVER_PORT']) && (int)$_SERVER['SERVER_PORT'] === 443)
    ) ? 'https' : 'http';

    $host = $_SERVER['HTTP_HOST'] ?? 'maaadmr.ir';
    return rtrim("{$protocol}://{$host}/" . ltrim($path, '/'), '/');
}

/**
 * Retrieve CSRF token
 */
function csrf_token(): string
{
    return Session::csrfToken();
}

/**
 * Generate CSRF hidden input field
 */
function csrf_field(): string
{
    return '<input type="hidden" name="_csrf_token" value="' . e(csrf_token()) . '">';
}

/**
 * Get flashed old input value
 */
function old(string $key, mixed $default = ''): mixed
{
    return Session::flash("old_{$key}") ?? $default;
}

/**
 * Flash message helper
 */
function flash(string $key, mixed $value = null): mixed
{
    return Session::flash($key, $value);
}

/**
 * ارسال اعلان لید و تحلیل هوش مصنوعی به پیام‌رسان‌های تلگرام و بله (Fail-safe Multi-Channel Dispatcher)
 */
function sendLeadToTelegram(string $actionTitle, array $customerData, ?string $aiReport = null): bool
{
    return sendLeadNotification($actionTitle, $customerData, $aiReport);
}

function sendLeadNotification(string $actionTitle, array $customerData, ?string $aiReport = null): bool
{
    $tgSuccess = false;
    $baleSuccess = false;

    // ۱. ارسال به تلگرام
    try {
        $tgSuccess = \App\Services\TelegramNotifier::sendLead($actionTitle, $customerData, $aiReport);
    } catch (\Throwable $e) {
        error_log('[Notification] Telegram dispatch error: ' . $e->getMessage());
    }

    // ۲. ارسال هم‌زمان به پیام‌رسان بله (پایدار، ملی و بدون نیاز به فیلترشکن)
    try {
        $baleSuccess = \App\Services\BaleNotifier::sendLead($actionTitle, $customerData, $aiReport);
    } catch (\Throwable $e) {
        error_log('[Notification] Bale dispatch error: ' . $e->getMessage());
    }

    // ۳. بک‌آپ ابری خودکار در گیت‌هاب (GitHub Realtime Auto-Sync)
    try {
        $gitService = new \App\Services\GitHubSyncService();
        if ($gitService->isConfigured()) {
            $gitPayload = array_merge($customerData, [
                'action_title' => $actionTitle,
                'has_ai_report' => !empty($aiReport),
            ]);
            $gitService->logLead($gitPayload, 'notification_dispatcher');
        }
    } catch (\Throwable $e) {
        error_log('[Notification] GitHub dispatch error: ' . $e->getMessage());
    }

    return $tgSuccess || $baleSuccess;
}

/**
 * تابع گلوبال همگام‌سازی زنده فایل‌ها در گیت‌هاب (GitHub REST API Push)
 *
 * @param string $commit_message پیام کامیت
 * @param string $file_path مسیر فایل در ریپازیتوری
 * @param string $content محتوای خام فایل
 * @return array
 */
function pushToGitHub(string $commit_message, string $file_path, string $content, ?string $branch = null): array
{
    $gitService = new \App\Services\GitHubSyncService();
    return $gitService->pushFile($file_path, $content, $commit_message, $branch);
}

