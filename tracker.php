<?php
declare(strict_types=1);

/**
 * Lightweight User Journey & UTM Tracker
 * فایل رهگیری مسیر کاربر و پارامترهای تبلیغاتی (UTM)
 * قرارگیری در بالای صفحات وب‌سایت (Top of Page Include)
 */

if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// اگر کلاس UserTracker در دسترس بود، از متد بهینه‌شده آن استفاده کن
if (class_exists(\App\Services\UserTracker::class)) {
    \App\Services\UserTracker::track();
} else {
    // منطق مستقل در صورت اینکلود شدن جداگانه
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    if ($method === 'GET') {
        $path = parse_url($uri, PHP_URL_PATH) ?? $uri;
        
        // فیلتر کردن فایل‌های استاتیک
        $isStatic = false;
        foreach (['.css', '.js', '.png', '.jpg', '.webp', '.svg', '.ico', '.xml', '.txt'] as $ext) {
            if (str_ends_with(strtolower($path), $ext)) {
                $isStatic = true;
                break;
            }
        }

        if (!$isStatic && !str_starts_with($path, '/api/')) {
            // ۱. ثبت UTM
            $utm = $_SESSION['tracker_utm'] ?? [];
            foreach (['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content'] as $key) {
                if (!empty($_GET[$key])) {
                    $utm[$key] = trim(strip_tags((string)$_GET[$key]));
                }
            }
            if (!empty($utm)) {
                $_SESSION['tracker_utm'] = $utm;
            }

            // ۲. ثبت مسیر ۳ قدم آخر (User Journey)
            $journey = $_SESSION['tracker_journey'] ?? [];
            if (empty($journey) || end($journey) !== $path) {
                $journey[] = $path;
                if (count($journey) > 3) {
                    $journey = array_slice($journey, -3);
                }
                $_SESSION['tracker_journey'] = $journey;
            }
            $_SESSION['tracker_current_page'] = $path;
        }
    }
}
