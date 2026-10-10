<?php
declare(strict_types=1);

/**
 * Bale Bot Webhook Handler (Fail-safe Domestic Lead & Assistant Webhook)
 * نقطه اتصال هوشمند بازوی پیام‌رسان بله (maaadmr.ir)
 */

if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
}
if (!defined('APP_PATH')) {
    define('APP_PATH', ROOT_PATH . '/app');
}

// Autoloader
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = APP_PATH . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;
    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
    if (file_exists($file)) require_once $file;
});

use App\Models\SiteSetting;
use App\Services\BaleNotifier;

header('Content-Type: application/json; charset=utf-8');

$rawInput = file_get_contents('php://input');
if (empty($rawInput)) {
    echo json_encode(['ok' => true, 'message' => 'Bale Webhook is alive and listening.']);
    exit;
}

$update = json_decode($rawInput, true);
if (!is_array($update)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid JSON payload']);
    exit;
}

// لاگ درخواست ورودی برای اشکال‌زدایی
error_log('[BaleWebhook] Received: ' . $rawInput);

$message = $update['message'] ?? $update['callback_query']['message'] ?? null;
if (!$message) {
    echo json_encode(['ok' => true, 'message' => 'No message payload to handle.']);
    exit;
}

$chatId   = (string)($message['chat']['id'] ?? '');
$fromId   = (string)($message['from']['id'] ?? $chatId);
$senderName = trim(($message['from']['first_name'] ?? '') . ' ' . ($message['from']['last_name'] ?? ''));
$text     = trim((string)($message['text'] ?? ''));

if (empty($chatId)) {
    echo json_encode(['ok' => false, 'error' => 'Missing chat_id']);
    exit;
}

// در صورت ارسال پیام یا دستور /start توسط مدیر، چت‌آیدی را در دیتابیس ثبت کن
$savedChatId = SiteSetting::get('bale_chat_id');
if (empty($savedChatId) || $text === '/start' || $text === 'شروع' || $text === '/connect') {
    SiteSetting::set('bale_chat_id', $chatId);
    
    $replyText = "🎉 <b>درود " . htmlspecialchars($senderName ?: 'محمد عزیز', ENT_QUOTES, 'UTF-8') . "!</b>\n\n" .
        "✅ <b>بازوی پیام‌رسان بله وب‌سایت شما با موفقیت متصل شد.</b>\n" .
        "📌 <b>شناسه چت ذخیره‌شده:</b> <code>{$chatId}</code>\n\n" .
        "🚀 <b>امکانات فعال‌شده:</b>\n" .
        "• دریافت لحظه‌ای تمامی لیدها، فرم‌های مشاوره و درخواست‌های سایت\n" .
        "• کارکرد دائمی و بدون نیاز به فیلترشکن با سرعت بالای شبکه ملی\n" .
        "• گزارش هم‌زمان همراه با پیام‌رسان تلگرام\n\n" .
        "🌐 <a href=\"https://maaadmr.ir\">مشاهده وب‌سایت maaadmr.ir</a>";

    $bale = new BaleNotifier();
    $bale->sendMessage($replyText, $chatId, 'HTML');

    echo json_encode(['ok' => true, 'registered_chat_id' => $chatId]);
    exit;
}

// دستور /status یا وضعیت
if ($text === '/status' || $text === 'وضعیت') {
    $telegramStatus = SiteSetting::get('telegram_enabled', '1') === '1' ? 'فعال 🟢' : 'غیرفعال 🔴';
    $baleStatus = SiteSetting::get('bale_enabled', '1') === '1' ? 'فعال 🟢' : 'غیرفعال 🔴';
    
    $statusMsg = "📊 <b>وضعیت سیستم مانیتورینگ سایت:</b>\n\n" .
        "• بازوی بله: {$baleStatus}\n" .
        "• ربات تلگرام: {$telegramStatus}\n" .
        "• شناسه چت بله شما: <code>{$chatId}</code>\n" .
        "• دامنه: <code>maaadmr.ir</code>\n" .
        "🕒 ساعت سرور: " . date('Y-m-d H:i:s');

    $bale = new BaleNotifier();
    $bale->sendMessage($statusMsg, $chatId, 'HTML');

    echo json_encode(['ok' => true]);
    exit;
}

// پاسخ پیش‌فرض
$bale = new BaleNotifier();
$bale->sendMessage("✅ پیام شما دریافت شد. سیستم مانیتورینگ لیدهای وب‌سایت maaadmr.ir فعال است.", $chatId, 'HTML');

echo json_encode(['ok' => true]);
