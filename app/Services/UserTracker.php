<?php
declare(strict_types=1);

namespace App\Services;

/**
 * سرویس فوق‌العاده سبک و پیشرفته ردگیری مسیر کاربر و پارامترهای تبلیغاتی (User Journey & UTM Tracker)
 * بدون وابستگی به گوگل آنالیتیکس ۴ (GA4) و کاملاً محلی بر پایه سشن‌های PHP
 * Mohammad Moftakhari Website (maaadmr.ir)
 */
class UserTracker
{
    private const MAX_JOURNEY_STEPS = 3;

    /**
     * اجرای خودکار ترکینگ در هر درخواست ورودی
     */
    public static function track(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        // ۱. فیلتر کردن درخواست‌های نامرتبط (فایل‌های استاتیک، وب‌هوک‌ها، متدهای غیر GET)
        if ($method !== 'GET' || self::isIgnoredUri($uri)) {
            return;
        }

        // ۲. ضبط و ذخیره پارامترهای UTM و رفرر
        self::captureUtm();

        // ۳. ثبت اولین صفحه فرود (First Touch Landing Page)
        if (empty($_SESSION['tracker_landing_page'])) {
            $_SESSION['tracker_landing_page'] = $uri;
        }

        // ۴. ثبت مسیر پیمایش کاربر (User Journey - ۳ قدم آخر)
        self::appendJourneyStep($uri);
    }

    /**
     * بررسی اینکه آیا آدرس باید از ترکینگ صرف‌نظر شود یا خیر
     */
    private static function isIgnoredUri(string $uri): bool
    {
        $path = parse_url($uri, PHP_URL_PATH) ?? $uri;

        // پسوندهای استاتیک و رسانه‌ای
        $ignoredExtensions = [
            '.css', '.js', '.png', '.jpg', '.jpeg', '.webp', '.svg', '.gif',
            '.ico', '.woff', '.woff2', '.ttf', '.eot', '.xml', '.txt', '.json', '.map'
        ];

        foreach ($ignoredExtensions as $ext) {
            if (str_ends_with(strtolower($path), $ext)) {
                return true;
            }
        }

        // مسیرهای سیستمی، وب‌هوک‌ها، پنل مدیریت و درخواست‌های AJAX
        $ignoredPrefixes = [
            '/api/', '/bot-webhook', '/bale-webhook', '/lead/submit',
            '/admin', '/favicon', '/sitemap', '/robots'
        ];

        foreach ($ignoredPrefixes as $prefix) {
            if (str_starts_with($path, $prefix)) {
                return true;
            }
        }

        return false;
    }

    /**
     * ضبط و پایداری پارامترهای کمپین (UTM Parameters) و Referrer
     */
    private static function captureUtm(): void
    {
        $utmKeys = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'];
        $hasNewUtm = false;
        $currentUtm = $_SESSION['tracker_utm'] ?? [];

        foreach ($utmKeys as $key) {
            if (!empty($_GET[$key])) {
                $currentUtm[$key] = trim(strip_tags((string)$_GET[$key]));
                $hasNewUtm = true;
            }
        }

        // اگر UTM مستقیم وجود نداشت، رفرر اولیه خارجی را بررسی کن
        if (empty($currentUtm['utm_source']) && !empty($_SERVER['HTTP_REFERER'])) {
            $ref = $_SERVER['HTTP_REFERER'];
            $host = parse_url($ref, PHP_URL_HOST) ?? '';
            $myHost = $_SERVER['HTTP_HOST'] ?? 'maaadmr.ir';

            if (!empty($host) && !str_contains($host, $myHost)) {
                $currentUtm['referrer'] = $ref;
                $currentUtm['utm_source'] = self::guessSourceFromReferrer($host);
                $currentUtm['utm_medium'] = 'referral';
            }
        }

        if ($hasNewUtm || !empty($currentUtm)) {
            $_SESSION['tracker_utm'] = $currentUtm;
        }
    }

    /**
     * تشخیص هوشمند منبع ورودی از روی دامنه رفرر
     */
    private static function guessSourceFromReferrer(string $host): string
    {
        $host = strtolower($host);
        if (str_contains($host, 'google.')) return 'Google Search (Organic)';
        if (str_contains($host, 'instagram.')) return 'Instagram';
        if (str_contains($host, 'telegram.') || str_contains($host, 't.me')) return 'Telegram';
        if (str_contains($host, 'linkedin.')) return 'LinkedIn';
        if (str_contains($host, 'ble.ir') || str_contains($host, 'bale.')) return 'Bale Messenger';
        if (str_contains($host, 'eitaa.')) return 'Eitaa';
        if (str_contains($host, 'torob.')) return 'Torob';
        if (str_contains($host, 'emalls.')) return 'Emalls';
        if (str_contains($host, 'aparat.')) return 'Aparat';
        if (str_contains($host, 'bing.')) return 'Bing Search';
        if (str_contains($host, 'yandex.')) return 'Yandex';
        return $host;
    }

    /**
     * افزودن صفحه به لیست ۳ قدم آخر مسیر کاربر (User Journey)
     */
    private static function appendJourneyStep(string $uri): void
    {
        $cleanPath = parse_url($uri, PHP_URL_PATH) ?: '/';
        $journey = $_SESSION['tracker_journey'] ?? [];

        // اگر کاربر صفحه را رفرش کرد، دوباره به صورت تکراری اضافه نکن
        $lastStep = end($journey);
        if ($lastStep === $cleanPath) {
            return;
        }

        $journey[] = $cleanPath;

        // نگه داشتن تنها ۳ قدم آخر برای بهینه‌سازی حافظه سشن
        if (count($journey) > self::MAX_JOURNEY_STEPS) {
            $journey = array_slice($journey, -self::MAX_JOURNEY_STEPS);
        }

        $_SESSION['tracker_journey'] = $journey;
        $_SESSION['tracker_current_page'] = $cleanPath;
    }

    /**
     * دریافت کلیه اطلاعات ردیابی برای الصاق به فرم و نوتیفیکیشن‌ها
     */
    public static function getTrackingData(): array
    {
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }

        $journey = $_SESSION['tracker_journey'] ?? [];
        $utm = $_SESSION['tracker_utm'] ?? [];
        $landingPage = $_SESSION['tracker_landing_page'] ?? '/';
        $currentPage = $_SESSION['tracker_current_page'] ?? ($_SERVER['HTTP_REFERER'] ? parse_url($_SERVER['HTTP_REFERER'], PHP_URL_PATH) : '/');

        // فرمت مسیر کاربر
        $journeyFormatted = !empty($journey) ? implode(' ➔ ', $journey) : $currentPage;

        // فرمت منبع UTM
        $utmParts = [];
        if (!empty($utm['utm_source'])) $utmParts[] = "Source: " . $utm['utm_source'];
        if (!empty($utm['utm_medium'])) $utmParts[] = "Medium: " . $utm['utm_medium'];
        if (!empty($utm['utm_campaign'])) $utmParts[] = "Campaign: " . $utm['utm_campaign'];
        if (!empty($utm['utm_term'])) $utmParts[] = "Term: " . $utm['utm_term'];
        if (!empty($utm['utm_content'])) $utmParts[] = "Content: " . $utm['utm_content'];
        if (empty($utmParts) && !empty($utm['referrer'])) $utmParts[] = "Referrer: " . $utm['referrer'];

        $utmFormatted = !empty($utmParts) ? implode(' | ', $utmParts) : 'Direct / Organic (مستقیم / ارگانیک)';

        return [
            'journey'           => $journey,
            'journey_formatted' => $journeyFormatted,
            'utm'               => $utm,
            'utm_formatted'     => $utmFormatted,
            'landing_page'      => $landingPage,
            'current_page'      => $currentPage ?: '/',
        ];
    }
}
