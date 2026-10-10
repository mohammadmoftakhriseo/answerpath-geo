<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\SiteSetting;

class SettingController extends Controller
{
    /**
     * صفحه تنظیمات عمومی سئو و سایت
     */
    public function index(Request $request, Response $response): void
    {
        $settings = SiteSetting::all();

        $this->render('admin/settings/index', [
            'title'    => 'تنظیمات عمومی سئو و سایت',
            'settings' => $settings,
            'success'  => $_SESSION['flash_success'] ?? null,
            'error'    => $_SESSION['flash_error'] ?? null,
        ], 'admin/layouts/admin');

        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    /**
     * ذخیره تنظیمات
     */
    public function update(Request $request, Response $response): void
    {
        $post = $request->post();

        $allowedKeys = [
            'site_name', 'site_title', 'site_description', 'site_keywords',
            'admin_phone', 'admin_email', 'admin_telegram', 'admin_bale', 'admin_whatsapp',
            'admin_instagram', 'admin_linkedin', 'admin_experience_years',
            'hero_title', 'hero_subtitle', 'hero_pitch',
            'telegram_bot_token', 'telegram_chat_id', 'telegram_enabled',
            'telegram_thread_leads', 'telegram_thread_blog', 'telegram_thread_content',
            'telegram_thread_pinterest', 'telegram_thread_reddit',
            'bale_bot_token', 'bale_chat_id', 'bale_enabled',
            'cloudflare_api_token', 'cloudflare_zone_id', 'cloudflare_account_id', 'cloudflare_enabled'
        ];

        // هندل کردن چک‌باکس‌های فعال بودن
        SiteSetting::set('telegram_enabled', isset($post['telegram_enabled']) ? '1' : '0');
        SiteSetting::set('bale_enabled', isset($post['bale_enabled']) ? '1' : '0');
        SiteSetting::set('cloudflare_enabled', isset($post['cloudflare_enabled']) ? '1' : '0');

        foreach ($allowedKeys as $key) {
            if ($key !== 'telegram_enabled' && $key !== 'bale_enabled' && $key !== 'cloudflare_enabled' && isset($post[$key])) {
                SiteSetting::set($key, trim((string)$post[$key]));
            }
        }

        $_SESSION['flash_success'] = 'تنظیمات با موفقیت ذخیره شدند.';
        $response->redirect('/admin/settings');
    }

    /**
     * تست ارسال پیام به تلگرام مدیر
     */
    public function testTelegram(Request $request, Response $response): void
    {
        $botToken = trim((string)$request->input('telegram_bot_token', ''));
        $chatId   = trim((string)$request->input('telegram_chat_id', ''));

        if (!empty($botToken)) {
            SiteSetting::set('telegram_bot_token', $botToken);
        }
        if (!empty($chatId)) {
            SiteSetting::set('telegram_chat_id', $chatId);
        }

        $notifier = new \App\Services\TelegramNotifier($botToken ?: null, $chatId ?: null);
        
        $testMessage = "🔔 <b>تست سیستم مانیتورینگ لیدهای سایت</b>\n\n" .
            "✅ اتصال ربات تلگرام به وب‌سایت <code>https://maaadmr.ir</code> با موفقیت برقرار شد!\n" .
            "از این پس هر لید جدید، درخواست مشاوره یا فرم نقشه راه ثبت شود، فوراً در همین چت به اطلاع شما خواهد رسید.\n\n" .
            "🕒 زمان تست: " . date('Y-m-d H:i:s');

        $result = $notifier->sendMessage($testMessage);

        if ($result['ok'] ?? false) {
            $_SESSION['flash_success'] = 'پیام تستی با موفقیت به تلگرام شما ارسال شد! ✅';
        } else {
            $desc = $result['description'] ?? 'خطای ناشناخته در ارتباط با تلگرام';
            $_SESSION['flash_error'] = "خطا در ارسال پیام تستی: {$desc} (لطفاً مطمئن شوید یک‌بار در ربات دکمه Start را زده‌اید یا Chat ID صحیح است)";
        }

        $response->redirect('/admin/settings#telegram-section');
    }

    /**
     * ثبت و فعال‌سازی خودکار وب‌هوک ربات تلگرام
     */
    public function setTelegramWebhook(Request $request, Response $response): void
    {
        $botToken = trim((string)$request->input('telegram_bot_token', ''));
        if (!empty($botToken)) {
            SiteSetting::set('telegram_bot_token', $botToken);
        }

        $notifier = new \App\Services\TelegramNotifier($botToken ?: null);
        $webhookUrl = 'https://maaadmr.ir/api/telegram/webhook';
        
        $result = $notifier->setWebhook($webhookUrl);

        if ($result['ok'] ?? false) {
            $_SESSION['flash_success'] = 'وب‌هوک ربات تلگرام با موفقیت فعال شد! اکنون ربات آماده دریافت پیام و تولید پست لینکدین است. 🚀';
        } else {
            $desc = $result['description'] ?? 'خطا در ثبت وب‌هوک تلگرام';
            $_SESSION['flash_error'] = "خطا در تنظیم وب‌هوک: {$desc}";
        }

        $response->redirect('/admin/settings#telegram-section');
    }

    /**
     * تست ارسال پیام به پیام‌رسان بله
     */
    public function testBale(Request $request, Response $response): void
    {
        $botToken = trim((string)$request->input('bale_bot_token', ''));
        $chatId   = trim((string)$request->input('bale_chat_id', ''));

        if (!empty($botToken)) {
            SiteSetting::set('bale_bot_token', $botToken);
        }
        if (!empty($chatId)) {
            SiteSetting::set('bale_chat_id', $chatId);
        }

        $bale = new \App\Services\BaleNotifier($botToken ?: null, $chatId ?: null);

        $testMessage = "🔔 <b>تست سیستم مانیتورینگ لیدها (پیام‌رسان بله)</b>\n\n" .
            "✅ اتصال بازوی بله به وب‌سایت <code>https://maaadmr.ir</code> با موفقیت برقرار شد!\n" .
            "از این پس کلیه لیدها، فرم‌های مشاوره و درخواست‌های سایت بدون نیاز به فیلترشکن مستقیماً به بله شما ارسال خواهند شد.\n\n" .
            "🕒 زمان تست: " . date('Y-m-d H:i:s');

        $result = $bale->sendMessage($testMessage);

        if ($result['ok'] ?? false) {
            $_SESSION['flash_success'] = 'پیام تستی با موفقیت به پیام‌رسان بله شما ارسال شد! 🎉';
        } else {
            $desc = $result['description'] ?? 'خطا در ارتباط با سرورهای بله';
            $_SESSION['flash_error'] = "خطا در ارسال پیام به بله: {$desc} (لطفاً ابتدا در بله وارد بازوی @maaad_mrbot شده و دکمه «شروع» یا Start را بزنید)";
        }

        $response->redirect('/admin/settings#bale-section');
    }

    /**
     * ثبت و فعال‌سازی وب‌هوک پیام‌رسان بله
     */
    public function setBaleWebhook(Request $request, Response $response): void
    {
        $botToken = trim((string)$request->input('bale_bot_token', ''));
        if (!empty($botToken)) {
            SiteSetting::set('bale_bot_token', $botToken);
        }

        $bale = new \App\Services\BaleNotifier($botToken ?: null);
        $webhookUrl = 'https://maaadmr.ir/api/bale/webhook';

        $result = $bale->setWebhook($webhookUrl);

        if ($result['ok'] ?? false) {
            $_SESSION['flash_success'] = 'وب‌هوک بازوی بله با موفقیت در سرورهای بله ثبت شد! اکنون کافیست یک پیام به بازو بفرستید تا چت‌آیدی شما خودکار ثبت شود. 🚀';
        } else {
            $desc = $result['description'] ?? 'خطا در ثبت وب‌هوک بله';
            $_SESSION['flash_error'] = "خطا در ثبت وب‌هوک بله: {$desc}";
        }

        $response->redirect('/admin/settings#bale-section');
    }

    /**
     * تست اتصال و دریافت وضعیت دامنه از Cloudflare
     */
    public function testCloudflare(Request $request, Response $response): void
    {
        $token  = trim((string)$request->input('cloudflare_api_token', ''));
        $zoneId = trim((string)$request->input('cloudflare_zone_id', ''));

        if (!empty($token)) {
            SiteSetting::set('cloudflare_api_token', $token);
        }
        if (!empty($zoneId)) {
            SiteSetting::set('cloudflare_zone_id', $zoneId);
        }

        $cf = new \App\Services\CloudflareService($token ?: null, $zoneId ?: null);
        $details = $cf->getZoneDetails();

        if (!empty($details['success'])) {
            $name = $details['name'] ?? '';
            $status = $details['status'] ?? '';
            $plan = $details['plan'] ?? '';
            $_SESSION['flash_success'] = "اتصال به Cloudflare موفقیت‌آمیز بود! ✅ دامنه: {$name} | وضعیت: {$status} | پلن: {$plan}";
        } else {
            $msg = $details['message'] ?? 'خطا در احراز هویت توکن یا Zone ID کلودفلر.';
            $_SESSION['flash_error'] = "خطا در اتصال به Cloudflare: {$msg}";
        }

        $response->redirect('/admin/settings#cloudflare-section');
    }

    /**
     * پاکسازی دستی کش کلودفلر (انتخابی یا کامل)
     */
    public function purgeCloudflare(Request $request, Response $response): void
    {
        $type = $request->input('purge_type', 'all');
        $cf = new \App\Services\CloudflareService();

        if ($type === 'articles') {
            $result = $cf->purgeUrls(['/', '/articles', '/sitemap.xml']);
        } else {
            $result = $cf->purgeEverything();
        }

        if (!empty($result['success'])) {
            $_SESSION['flash_success'] = $result['message'];
        } else {
            $_SESSION['flash_error'] = $result['message'] ?? 'خطا در پاکسازی کش کلودفلر.';
        }

        $response->redirect('/admin/settings#cloudflare-section');
    }

    /**
     * اعمال خودکار تنظیمات سرعت و Core Web Vitals در کلودفلر
     */
    public function optimizeCloudflare(Request $request, Response $response): void
    {
        $cf = new \App\Services\CloudflareService();
        $result = $cf->optimizeSpeedSettings();

        if (!empty($result['success'])) {
            $_SESSION['flash_success'] = 'تنظیمات پرفورمنس کلودفلر (Early Hints، Brotli، HTTP/3 و Minification) با موفقیت فعال شدند! 🚀';
        } else {
            $_SESSION['flash_error'] = $result['message'] ?? 'خطا در اعمال تنظیمات پرفورمنس.';
        }

        $response->redirect('/admin/settings#cloudflare-section');
    }

    /**
     * تست اتصال و همگام‌سازی فایل آزمایشی با گیت‌هاب (GitHub Cloud Sync Test)
     */
    public function testGitHub(Request $request, Response $response): void
    {
        $gitService = new \App\Services\GitHubSyncService();
        if (!$gitService->isConfigured()) {
            $_SESSION['flash_error'] = 'خطا: توکن GitHub (GITHUB_TOKEN) در فایل .env تنظیم نشده است یا اتصال غیرفعال است.';
            $response->redirect('/admin/settings#github-section');
            return;
        }

        $testContent = json_encode([
            'status'     => 'connected',
            'test_time'  => date('Y-m-d H:i:s'),
            'repository' => 'https://github.com/mohammadmoftakhriseo/answerpath-geo',
            'cms'        => 'Mohammad Moftakhari CMS v2.0'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        $result = $gitService->pushFile('data/connection_test.json', $testContent, "Test: Verify GitHub REST API connection at " . date('Y-m-d H:i:s'));

        if (!empty($result['success'])) {
            $commitSha = substr($result['commit_sha'] ?? '', 0, 7);
            $_SESSION['flash_success'] = "اتصال به GitHub با موفقیت برقرار شد! ✅ کامیت تستی با شناسه [{$commitSha}] در ریپازیتوری ثبت گردید.";
        } else {
            $_SESSION['flash_error'] = "خطا در اتصال به GitHub: " . ($result['message'] ?? 'خطای نامشخص');
        }

        $response->redirect('/admin/settings#github-section');
    }
}

