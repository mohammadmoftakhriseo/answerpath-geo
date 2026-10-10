<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\SiteSetting;
use App\Services\BaleNotifier;

class BaleBotController extends Controller
{
    public function handle(Request $request, Response $response): void
    {
        $rawInput = file_get_contents('php://input');
        if (empty($rawInput)) {
            $response->json(['ok' => true, 'message' => 'Bale Webhook is alive and listening.']);
            return;
        }

        $update = json_decode($rawInput, true);
        if (!is_array($update)) {
            $response->json(['ok' => false, 'error' => 'Invalid JSON']);
            return;
        }

        $message = $update['message'] ?? $update['callback_query']['message'] ?? null;
        if (!$message) {
            $response->json(['ok' => true, 'message' => 'No message payload.']);
            return;
        }

        $chatId = (string)($message['chat']['id'] ?? '');
        $senderName = trim(($message['from']['first_name'] ?? '') . ' ' . ($message['from']['last_name'] ?? ''));
        $text = trim((string)($message['text'] ?? ''));

        if (empty($chatId)) {
            $response->json(['ok' => false, 'error' => 'Missing chat_id']);
            return;
        }

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

            $response->json(['ok' => true, 'registered_chat_id' => $chatId]);
            return;
        }

        $bale = new BaleNotifier();
        $bale->sendMessage("✅ پیام شما دریافت شد. سیستم مانیتورینگ لیدهای وب‌سایت maaadmr.ir فعال است.", $chatId, 'HTML');

        $response->json(['ok' => true]);
    }
}
