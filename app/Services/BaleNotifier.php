<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\SiteSetting;

/**
 * سرویس جامع و فوق‌العاده پایدار ارسال اعلان‌های لحظه‌ای لید و فرم‌ها به پیام‌رسان بله (Bale)
 * Fail-safe Domestic Notification Channel (مستقل از اینترنت بین‌الملل و فیلترشکن)
 */
class BaleNotifier
{
    private string $botToken;
    private string $chatId;
    private bool $enabled;
    private string $apiBase;
    private int $timeout;
    private int $connectTimeout;

    public function __construct(?string $botToken = null, ?string $chatId = null)
    {
        $config = file_exists(ROOT_PATH . '/config/bale.php') 
            ? (require ROOT_PATH . '/config/bale.php') 
            : [];

        $dbToken = trim((string)SiteSetting::get('bale_bot_token', ''));
        $this->botToken = !empty($botToken) 
            ? $botToken 
            : (!empty($config['bot_token']) ? $config['bot_token'] : (!empty($dbToken) ? $dbToken : '575625957:UC1J1ErjQCdclDALGapkRPTlzMi6lHc8L0Q'));

        $dbChatId = trim((string)SiteSetting::get('bale_chat_id', ''));
        $this->chatId = !empty($chatId) 
            ? $chatId 
            : (!empty($config['chat_id']) ? $config['chat_id'] : (!empty($dbChatId) ? $dbChatId : '1407876421'));

        $this->enabled = isset($config['enabled']) 
            ? (bool)$config['enabled'] 
            : (SiteSetting::get('bale_enabled', '1') !== '0');

        $this->apiBase = $config['api_base'] ?? 'https://tapi.bale.ai/bot';
        $this->timeout = (int)($config['timeout'] ?? 5);
        $this->connectTimeout = (int)($config['connect_timeout'] ?? 3);
    }

    /**
     * متد ایستا برای ارسال سریع لید به بله
     */
    public static function sendLead(string $actionTitle, array $customerData, ?string $aiReport = null, ?string $customChatId = null): bool
    {
        $notifier = new self(null, $customChatId);
        return $notifier->dispatchLeadNotification($actionTitle, $customerData, $aiReport);
    }

    /**
     * فرمت‌بندی و دیسپچ اعلان دریافت لید به بله
     */
    public function dispatchLeadNotification(string $actionTitle, array $customerData, ?string $aiReport = null): bool
    {
        if (!$this->enabled || empty($this->botToken) || empty($this->chatId)) {
            error_log('[BaleNotifier] Skipped: Bot token or chat ID is not configured.');
            return false;
        }

        $htmlMessage = $this->buildLeadMessageHtml($actionTitle, $customerData, $aiReport);
        $result = $this->sendMessage($htmlMessage);
        
        return $result['ok'] ?? false;
    }

    /**
     * ساخت متن پیام ساختاریافته و زیبا با تگ‌های HTML سازگار با بله
     */
    public function buildLeadMessageHtml(string $actionTitle, array $customerData, ?string $aiReport = null): string
    {
        $name        = $this->cleanHtml($customerData['name'] ?? $customerData['full_name'] ?? 'ثبت نشده');
        $phone       = $this->cleanHtml($customerData['phone'] ?? $customerData['raw_phone'] ?? 'ثبت نشده');
        $website     = $this->cleanHtml($customerData['website_url'] ?? $customerData['website'] ?? 'ندارد / ثبت نشده');
        $challenge   = $this->cleanHtml($customerData['challenge'] ?? $customerData['message'] ?? $customerData['service_requested'] ?? '');
        $serviceType = $this->cleanHtml($customerData['service_type'] ?? '');
        $sourceCta   = $this->cleanHtml($customerData['source_cta'] ?? $customerData['source'] ?? 'سایت اصلی');
        $siteBaseUrl = 'https://maaadmr.ir';
        
        $currentPage = $customerData['current_page'] ?? '/';
        $fullCurrentPageUrl = str_starts_with($currentPage, 'http') ? $currentPage : $siteBaseUrl . (str_starts_with($currentPage, '/') ? $currentPage : '/' . $currentPage);

        // ساخت لینک‌های کلیک‌خور برای مسیر ۳ قدم آخر
        $journeyRaw = $customerData['user_journey_raw'] ?? [];
        if (empty($journeyRaw) && !empty($customerData['user_journey'])) {
            $journeyRaw = array_map('trim', explode('➔', (string)$customerData['user_journey']));
        }
        if (empty($journeyRaw)) {
            $journeyRaw = [$currentPage];
        }

        $journeyLinks = [];
        foreach ($journeyRaw as $step) {
            $cleanStep = trim($step);
            if (empty($cleanStep)) continue;
            $stepUrl = str_starts_with($cleanStep, 'http') ? $cleanStep : $siteBaseUrl . (str_starts_with($cleanStep, '/') ? $cleanStep : '/' . $cleanStep);
            $journeyLinks[] = "<a href=\"{$stepUrl}\">" . $this->cleanHtml($cleanStep) . "</a>";
        }
        $journeyFormatted = implode(' ➔ ', $journeyLinks);

        // فرمت‌بندی پارامترهای UTM و رفرر
        $utm = $customerData['utm_data'] ?? [];
        $utmSource   = $this->cleanHtml($utm['utm_source'] ?? ($customerData['utm_source'] ?? ''));
        $utmMedium   = $this->cleanHtml($utm['utm_medium'] ?? ($customerData['utm_medium'] ?? ''));
        $utmCampaign = $this->cleanHtml($utm['utm_campaign'] ?? ($customerData['utm_campaign'] ?? ''));
        $referrer    = $utm['referrer'] ?? ($customerData['referrer'] ?? '');

        $utmDisplay = [];
        if (!empty($utmSource))   $utmDisplay[] = "Source: <code>{$utmSource}</code>";
        if (!empty($utmMedium))   $utmDisplay[] = "Medium: <code>{$utmMedium}</code>";
        if (!empty($utmCampaign)) $utmDisplay[] = "Campaign: <code>{$utmCampaign}</code>";

        $utmText = !empty($utmDisplay) ? implode(' | ', $utmDisplay) : '<code>Direct / Organic (مستقیم)</code>';

        $ip       = $this->cleanHtml($customerData['ip'] ?? $customerData['ip_address'] ?? 'نامشخص');
        $dateTime = date('Y-m-d H:i:s');

        $lines = [];
        $lines[] = "🚨 <b>لید جدید در وب‌سایت دریافت شد! (اعلان بله)</b>";
        $lines[] = "━━━━━━━━━━━━━━━━━━";
        $lines[] = "📌 <b>نوع درخواست:</b> " . $this->cleanHtml($actionTitle);
        $lines[] = "📝 <b>اطلاعات کاربر:</b> <code>{$name}</code> | <a href=\"tel:{$phone}\">{$phone}</a>";
        
        if (!empty($serviceType)) {
            $lines[] = "🎯 <b>حوزه انتخابی:</b> <code>{$serviceType}</code>";
        }

        if ($website !== 'ندارد / ثبت نشده' && !empty($website)) {
            $webLink = str_starts_with($website, 'http') ? $website : "https://{$website}";
            $lines[] = "🌐 <b>آدرس وب‌سایت:</b> <a href=\"{$webLink}\">{$website}</a>";
        } else {
            $lines[] = "🌐 <b>آدرس وب‌سایت:</b> <i>ندارد / ثبت نشده</i>";
        }

        if (!empty($challenge)) {
            $lines[] = "💬 <b>توضیحات و چالش:</b>\n<i>{$challenge}</i>";
        }

        $lines[] = "━━━━━━━━━━━━━━━━━━";
        $lines[] = "📍 <b>ثبت شده در صفحه:</b> <a href=\"{$fullCurrentPageUrl}\">" . $this->cleanHtml($currentPage) . "</a>";
        $lines[] = "👣 <b>مسیر کاربر (۳ قدم آخر):</b>\n{$journeyFormatted}";
        $lines[] = "🎯 <b>منبع ورود (UTM):</b> {$utmText}";

        if (!empty($referrer)) {
            $cleanRef = $this->cleanHtml($referrer);
            $lines[] = "🔗 <b>مرجع ارجاع (Referrer):</b> <a href=\"{$cleanRef}\">{$cleanRef}</a>";
        }

        $lines[] = "🕒 <b>زمان ثبت:</b> <code>{$dateTime}</code>";
        $lines[] = "🌐 <b>آی‌پی کاربر:</b> <code>{$ip}</code>";

        // ضمیمه گزارش هوش مصنوعی در صورت وجود
        if (!empty($aiReport)) {
            $lines[] = "\n━━━━━━━━━━━━━━━━━━";
            $lines[] = "🤖 <b>تحلیل سریع هوش مصنوعی (Google Gemini):</b>";
            $cleanAiReport = strip_tags($aiReport);
            if (mb_strlen($cleanAiReport) > 1200) {
                $cleanAiReport = mb_substr($cleanAiReport, 0, 1200) . '... (ادامه در پنل)';
            }
            $lines[] = "<i>" . htmlspecialchars($cleanAiReport, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . "</i>";
        }

        $lines[] = "━━━━━━━━━━━━━━━━━━";
        $lines[] = "🔗 <a href=\"https://maaadmr.ir/admin/leads\">مشاهده در پنل مدیریت وب‌سایت</a>";

        return implode("\n", $lines);
    }

    /**
     * ارسال پیام به API بله
     */
    public function sendMessage(string $text, ?string $chatId = null, string $parseMode = 'HTML'): array
    {
        $targetChatId = $chatId ?: $this->chatId;
        if (empty($this->botToken) || empty($targetChatId)) {
            return [
                'ok' => false,
                'description' => 'Bot token or Chat ID is empty'
            ];
        }

        $params = [
            'chat_id'    => $targetChatId,
            'text'       => $text,
            'parse_mode' => $parseMode,
        ];

        return $this->sendRequest('sendMessage', $params);
    }

    /**
     * ثبت آدرس وب‌هوک برای بازوی بله
     */
    public function setWebhook(string $webhookUrl): array
    {
        if (empty($this->botToken)) {
            return ['ok' => false, 'description' => 'Bot token is empty'];
        }

        return $this->sendRequest('setWebhook', ['url' => $webhookUrl]);
    }

    /**
     * بررسی وضعیت وب‌هوک بله
     */
    public function getWebhookInfo(): array
    {
        return $this->sendRequest('getWebhookInfo');
    }

    /**
     * دریافت آخرین پیام‌ها (Long Polling)
     */
    public function getUpdates(): array
    {
        return $this->sendRequest('getUpdates');
    }

    /**
     * متد مرکزی ارسال درخواست cURL به سرورهای بله
     */
    private function sendRequest(string $method, array $params = []): array
    {
        $base = rtrim($this->apiBase, '/');
        if (!str_ends_with($base, 'bot')) {
            $base .= '/bot';
        }
        $url = $base . $this->botToken . '/' . $method;

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $url,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($params, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT        => max($this->timeout, 8),
            CURLOPT_CONNECTTIMEOUT => max($this->connectTimeout, 4),
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        $curlErrno = curl_errno($ch);
        curl_close($ch);

        if ($curlErrno !== 0 || $response === false) {
            error_log("[BaleNotifier] cURL Error ({$curlErrno}): {$curlError} | Method: {$method}");
            return [
                'ok' => false,
                'error_code' => $curlErrno,
                'description' => "cURL error: {$curlError}"
            ];
        }

        $decoded = json_decode((string)$response, true);
        if (!is_array($decoded)) {
            error_log("[BaleNotifier] Invalid JSON Response: {$response} | HTTP Code: {$httpCode}");
            return [
                'ok' => false,
                'error_code' => $httpCode,
                'description' => 'Invalid JSON from Bale API',
                'raw_response' => $response
            ];
        }

        return $decoded;
    }

    /**
     * ایمن‌سازی کاراکترهای خاص برای قالب‌بندی HTML
     */
    private function cleanHtml(?string $text): string
    {
        if ($text === null) {
            return '';
        }
        return htmlspecialchars(trim($text), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
