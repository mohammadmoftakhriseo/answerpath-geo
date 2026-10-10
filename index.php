<?php
declare(strict_types=1);

/**
 * Mohammad Moftakhari - Personal Branding CMS
 * Front Controller & Application Bootstrapper
 * PHP 8.2+
 */

define('ROOT_PATH', __DIR__);
define('APP_PATH', ROOT_PATH . '/app');
define('VIEWS_PATH', ROOT_PATH . '/views');

// PSR-4 Autoloader
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = APP_PATH . '/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

// Load Helpers
if (file_exists(APP_PATH . '/Core/helpers.php')) {
    require_once APP_PATH . '/Core/helpers.php';
}

use App\Core\Env;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Core\Session;

// Load Environment Configuration (.env)
Env::load();

// Configure Environment Debugging
$isDebug = (bool)env('APP_DEBUG', false);
if ($isDebug) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    ini_set('display_errors', '0');
}
ini_set('log_errors', '1');

try {
    Session::start();

    // اجرای رهگیری مسیر کاربر و پارامترهای تبلیغاتی (User Journey & UTM Tracker)
    if (file_exists(ROOT_PATH . '/tracker.php')) {
        require_once ROOT_PATH . '/tracker.php';
    }

    $request = new Request();
    $response = new Response();
    $router = new Router();

    // Load Routes
    if (file_exists(ROOT_PATH . '/routes/web.php')) {
        require_once ROOT_PATH . '/routes/web.php';
    } else {
        throw new \RuntimeException("Routes file not found at: " . ROOT_PATH . '/routes/web.php');
    }

    // Dispatch Request
    $router->dispatch($request, $response);
} catch (\Throwable $e) {
    error_log('[Application Error] ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());

    if ($isDebug) {
        echo '<div style="font-family:sans-serif; direction:ltr; text-align:left; background:#fff1f2; border:2px solid #e11d48; padding:25px; margin:20px; border-radius:12px; color:#881337;">';
        echo '<h2 style="margin-top:0; color:#e11d48;">Application Error Details (Debug Mode)</h2>';
        echo '<p><strong>Message:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
        echo '<p><strong>File:</strong> ' . htmlspecialchars($e->getFile()) . ' (Line: ' . $e->getLine() . ')</p>';
        echo '<pre style="background:#ffe4e6; padding:15px; border-radius:8px; overflow-x:auto; font-size:12px;">' . htmlspecialchars($e->getTraceAsString()) . '</pre>';
        echo '</div>';
    } else {
        http_response_code(500);
        echo '<div style="font-family:system-ui,sans-serif; direction:rtl; text-align:center; padding:60px 20px; max-width:550px; margin:50px auto; background:#fff; border-radius:16px; border:1px solid #e2e8f0; box-shadow:0 10px 25px rgba(0,0,0,0.05);">';
        echo '<h2 style="color:#0f172a; margin-bottom:12px; font-weight:800;">سامانه موقتاً با اختلال مواجه شد</h2>';
        echo '<p style="color:#64748b; font-size:14px; line-height:1.7;">خطایی رخ داده است. گزارش خطا برای تیم فنی ثبت گردید. لطفاً لحظاتی دیگر تلاش فرمایید.</p>';
        echo '<a href="/" style="display:inline-block; margin-top:16px; padding:10px 24px; background:#2563eb; color:#fff; border-radius:10px; text-decoration:none; font-size:13px; font-weight:700;">بازگشت به صفحه اصلی</a>';
        echo '</div>';
    }
    exit;
}