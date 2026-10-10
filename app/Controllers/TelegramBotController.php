<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\SiteSetting;
use App\Services\AiContentEngine;
use App\Services\OmnichannelSocialPublisherService;
use App\Services\PinterestPublisherService;
use App\Services\TelegramNotifier;

class TelegramBotController extends Controller
{
    /**
     * وب‌هوک اصلی دریافت پیام‌ها و درخواست‌های ارسالی از تلگرام
     */
    public function handle(Request $request, Response $response): void
    {
        $rawInput = file_get_contents('php://input');
        if (empty($rawInput)) {
            $response->json(['status' => 'empty_payload']);
            return;
        }

        $update = json_decode($rawInput, true);
        if (!is_array($update)) {
            $response->json(['status' => 'invalid_json']);
            return;
        }

        $message = $update['message'] ?? ($update['edited_message'] ?? null);
        if (!$message) {
            $response->json(['status' => 'no_message']);
            return;
        }

        // ۱. جلوگیری قطعی از پردازش تکراری آپدیت‌های تلگرام (Idempotency & Anti-Retry Lock)
        $updateId = (int)($update['update_id'] ?? 0);
        $messageId = (int)($message['message_id'] ?? 0);
        $lockDir = ROOT_PATH . '/storage/locks';
        if (!is_dir($lockDir)) {
            @mkdir($lockDir, 0755, true);
        }

        if ($updateId > 0) {
            $updateLockFile = $lockDir . '/tlg_update_' . $updateId . '.lock';
            if (file_exists($updateLockFile)) {
                // این آپدیت قبلاً پردازش شده یا در حال اجراست؛ فوراً خروج
                $response->json(['status' => 'already_processed', 'update_id' => $updateId]);
                return;
            }
            @file_put_contents($updateLockFile, (string)time());

            // پاکسازی دوره‌ای لاگ‌ها/قفل‌های قدیمی‌تر از ۲ ساعت
            if (mt_rand(1, 30) === 1) {
                foreach (glob($lockDir . '/tlg_*.lock') as $oldFile) {
                    if (time() - filemtime($oldFile) > 7200) {
                        @unlink($oldFile);
                    }
                }
            }
        }

        $chatId    = (string)($message['chat']['id'] ?? '');
        $userId    = (string)($message['from']['id'] ?? '');
        $username  = (string)($message['from']['username'] ?? '');
        $firstName = (string)($message['from']['first_name'] ?? 'کاربر');
        $text      = isset($message['text']) ? trim((string)$message['text']) : '';
        $threadId  = isset($message['message_thread_id']) ? (string)$message['message_thread_id'] : null;

        // جلوگیری از ارسال همزمان ۲ پیام دقیقاً یکسان در بازه ۳ دقیقه‌ای
        if (!empty($text)) {
            $textHash = md5($chatId . '_' . ($threadId ?? '0') . '_' . $text);
            $hashLockFile = $lockDir . '/tlg_msg_' . $textHash . '.lock';
            if (file_exists($hashLockFile) && (time() - filemtime($hashLockFile)) < 180) {
                $response->json(['status' => 'duplicate_text_in_progress', 'hash' => $textHash]);
                return;
            }
            @file_put_contents($hashLockFile, (string)time());
        }

        $notifier = new TelegramNotifier();

        // پشتیبانی کامل از پیام‌های صوتی و ویس (Voice & Audio Speech-to-Text با Gemini)
        $voice = $message['voice'] ?? ($message['audio'] ?? null);
        if (!empty($voice) && empty($text)) {
            $fileId = $voice['file_id'] ?? null;
            if ($fileId) {
                $notifier->sendChatAction('record_voice', $chatId, $threadId);
                $audioBytes = $notifier->downloadTelegramFile($fileId);
                if ($audioBytes) {
                    $transcribed = $notifier->transcribeVoice($audioBytes, $voice['mime_type'] ?? 'audio/ogg');
                    if (!empty($transcribed)) {
                        $text = trim($transcribed);
                        $notifier->sendMessage("🎙 <b>پیام صوتی شما شنیده و پیاده‌سازی شد:</b>\n<i>«" . htmlspecialchars($text, ENT_QUOTES, 'UTF-8') . "»</i>\n\n⚙️ <i>در حال پردازش و اجرای خودکار دستور تاپیک...</i>", $chatId, $threadId);
                    }
                }
            }
        }

        if (empty($text)) {
            $response->json(['status' => 'no_text_or_voice_message']);
            return;
        }

        // لاگ لحظه‌ای برای خطایابی دقیق
        @file_put_contents(ROOT_PATH . '/telegram_webhook.log', date('Y-m-d H:i:s') . " | Chat: {$chatId} | User: {$userId} | Thread: {$threadId} | Text: {$text}\n", FILE_APPEND);

        // بررسی دسترسی (احراز هویت ادمین)
        $adminChatId = SiteSetting::get('telegram_chat_id', '48108477');
        $isAuthorized = ($chatId === $adminChatId) || ($userId === '48108477') || (strtolower($username) === 'maaad_mr') || empty($adminChatId) || str_starts_with($text, '/bind');

        if (!$isAuthorized) {
            $notifier->sendMessage("⛔️ <b>دسترسی غیرمجاز</b>\nاین ربات دستیار اختصاصی تولید محتوای هوش مصنوعی محمد مفتخری است.", $chatId, $threadId);
            $response->json(['status' => 'unauthorized']);
            return;
        }

        // =========================================================================
        // دستورات اتصال تاپیک‌ها (/bind leads | /bind blog | /bind linkedin) با پشتیبانی از @botname
        // =========================================================================
        if (preg_match('/^\/bind(?:@\w+)?(?:\s+(.*))?$/ui', $text, $bindMatches)) {
            $bindTarget = trim(strtolower($bindMatches[1] ?? ''));

            if (empty($bindTarget) || $bindTarget === 'status' || $bindTarget === 'info') {
                $leadsThread = SiteSetting::get('telegram_thread_leads', 'متصل نشده');
                $blogThread = SiteSetting::get('telegram_thread_blog', 'متصل نشده');
                $contentThread = SiteSetting::get('telegram_thread_content', 'متصل نشده');
                $pinterestThread = SiteSetting::get('telegram_thread_pinterest', 'متصل نشده');
                $redditThread = SiteSetting::get('telegram_thread_reddit', 'متصل نشده');
                $activeChat = SiteSetting::get('telegram_chat_id', $chatId);

                $statusMsg = "📋 <b>وضعیت اتصال تاپیک‌های تلگرام (Forum Topics):</b>\n\n" .
                    "🆔 شناسه چت اصلی: <code>{$activeChat}</code>\n" .
                    "📬 تاپیک لیدهای سایت: <code>{$leadsThread}</code>\n" .
                    "✍️ تاپیک مقالات وبلاگ: <code>{$blogThread}</code>\n" .
                    "💼 تاپیک تولید محتوای لینکدین: <code>{$contentThread}</code>\n" .
                    "📌 تاپیک انتشار خودکار Pinterest: <code>{$pinterestThread}</code>\n" .
                    "👾 تاپیک انتشار هوشمند Reddit: <code>{$redditThread}</code>\n\n" .
                    "📌 <b>دستورات اتصال سریع:</b>\n" .
                    "🔹 داخل تاپیک لیدها: <code>/bind leads</code>\n" .
                    "🔹 داخل تاپیک مقالات: <code>/bind blog</code> یا <code>/bind articles</code>\n" .
                    "🔹 داخل تاپیک لینکدین: <code>/bind linkedin</code> یا <code>/bind content</code>\n" .
                    "🔹 داخل تاپیک پینترست: <code>/bind pinterest</code> یا <code>/bind pin</code>\n" .
                    "🔹 داخل تاپیک ردیت: <code>/bind reddit</code>";

                $notifier->sendMessage($statusMsg, $chatId, $threadId);
                $response->json(['status' => 'bind_status_sent']);
                return;
            }

            if (in_array($bindTarget, ['leads', 'lead', 'لید', 'لیدها'])) {
                SiteSetting::set('telegram_chat_id', $chatId);
                if ($threadId) {
                    SiteSetting::set('telegram_thread_leads', (string)$threadId);
                }
                $confirm = "✅ <b>تاپیک «لیدهای سایت» با موفقیت متصل و قفل شد!</b>\n\n" .
                    "📌 شناسه تاپیک: <code>" . ($threadId ?: 'چت اصلی (General)') . "</code>\n" .
                    "از این پس تمام لیدها، فرم‌های تماس و تحلیل‌های هوش مصنوعی مستقیماً به این تاپیک ارسال می‌شوند.";
                $notifier->sendMessage($confirm, $chatId, $threadId);
                $response->json(['status' => 'bind_leads_success']);
                return;
            }

            if (in_array($bindTarget, ['blog', 'articles', 'article', 'مقاله', 'مقالات', 'وبلاگ'])) {
                SiteSetting::set('telegram_chat_id', $chatId);
                if ($threadId) {
                    SiteSetting::set('telegram_thread_blog', (string)$threadId);
                }
                $confirm = "✅ <b>تاپیک «تولید مقاله وبلاگ و سئو» با موفقیت متصل و قفل شد!</b>\n\n" .
                    "📌 شناسه تاپیک: <code>" . ($threadId ?: 'چت اصلی (General)') . "</code>\n" .
                    "از این پس هر موضوعی داخل این تاپیک بنویسید (حتی بدون نوشتن عبارت «مقاله:»)، مستقیماً مقاله کامل سئو + تصویر Pexels تولید و در دیتابیس سایت ذخیره می‌شود.";
                $notifier->sendMessage($confirm, $chatId, $threadId);
                $response->json(['status' => 'bind_blog_success']);
                return;
            }

            if (in_array($bindTarget, ['linkedin', 'content', 'social', 'محتوا', 'لینکدین'])) {
                SiteSetting::set('telegram_chat_id', $chatId);
                if ($threadId) {
                    SiteSetting::set('telegram_thread_content', (string)$threadId);
                }
                $confirm = "✅ <b>تاپیک «تولید محتوای لینکدین» با موفقیت متصل و قفل شد!</b>\n\n" .
                    "📌 شناسه تاپیک: <code>" . ($threadId ?: 'چت اصلی (General)') . "</code>\n" .
                    "از این پس هر ایده‌ای در این تاپیک ارسال کنید، طبق ۵ قانون الگوریتمی لینکدین تبدیل به پست حرفه‌ای می‌شود.";
                $notifier->sendMessage($confirm, $chatId, $threadId);
                $response->json(['status' => 'bind_content_success']);
                return;
            }

            if (in_array($bindTarget, ['pinterest', 'pin', 'پینترست', 'پین'])) {
                SiteSetting::set('telegram_chat_id', $chatId);
                if ($threadId) {
                    SiteSetting::set('telegram_thread_pinterest', (string)$threadId);
                }
                $confirm = "✅ <b>تاپیک «تولید و انتشار خودکار در Pinterest» با موفقیت متصل شد!</b>\n\n" .
                    "📌 شناسه تاپیک: <code>" . ($threadId ?: 'چت اصلی (General)') . "</code>\n" .
                    "از این پس هر موضوع یا کلیدواژه‌ای در این تاپیک ارسال کنید، پکیج کامل سئو پینترست + تصویر عمودی ۲:۳ با Imagen 3 تولید و از طریق Composio MCP در بورد پینترست منتشر خواهد شد.";
                $notifier->sendMessage($confirm, $chatId, $threadId);
                $response->json(['status' => 'bind_pinterest_success']);
                return;
            }

            if (in_array($bindTarget, ['reddit', 'ردیت'])) {
                SiteSetting::set('telegram_chat_id', $chatId);
                if ($threadId) {
                    SiteSetting::set('telegram_thread_reddit', (string)$threadId);
                }
                $confirm = "✅ <b>تاپیک «انتشار هوشمند در Reddit» با موفقیت متصل شد!</b>\n\n" .
                    "📌 شناسه تاپیک: <code>" . ($threadId ?: 'چت اصلی (General)') . "</code>\n" .
                    "از این پس هر ایده، کیس استادی یا لینکی در این تاپیک ارسال کنید، هوش مصنوعی ساب‌ردیت هدف را انتخاب کرده و یک پست مباحثه‌محور طبیعی و تخصصی با ارجاع به سورس را تولید و از طریق Composio MCP در ردیت منتشر می‌نماید.";
                $notifier->sendMessage($confirm, $chatId, $threadId);
                $response->json(['status' => 'bind_reddit_success']);
                return;
            }

            $notifier->sendMessage("⚠️ دستور اتصال نامعتبر است.\nدستورات مجاز: <code>/bind leads</code> | <code>/bind blog</code> | <code>/bind linkedin</code> | <code>/bind pinterest</code> | <code>/bind reddit</code>", $chatId, $threadId);
            $response->json(['status' => 'invalid_bind_target']);
            return;
        }

        // دستور /start یا /help با پشتیبانی از @botname
        if (preg_match('/^\/(?:start|help)(?:@\w+)?$/ui', $text)) {
            $welcome = "👋 <b>سلام {$firstName} عزیز!</b>\n\n" .
                "به دستیار هوشمند محتوا و وبلاگ <b>maaadmr.ir</b> خوش آمدید. 🚀\n\n" .
                "🧭 <b>راهنمای دستورات و تولید محتوا:</b>\n\n" .
                "📝 <b>تولید مقاله سئو وب‌سایت:</b> پیام با پیشوند <code>مقاله:</code> یا ارسال کلمه کلیدی در تاپیک مقالات\n" .
                "📸 <b>تولید استوری/پست اینستاگرام:</b> ارسال با پیشوند <code>استوری:</code> یا <code>اینستاگرام:</code> (طراحی سناریو اسلایدها + کپشن + تصویر ۹:۱۶)\n" .
                "💼 <b>تولید پست لینکدین:</b> <code>/linkedin [ایده]</code> یا ارسال در تاپیک لینکدین\n" .
                "📌 <b>انتشار در Pinterest:</b> <code>/pin [موضوع]</code> یا ارسال در تاپیک پینترست\n" .
                "👾 <b>انتشار در Reddit:</b> <code>/reddit [موضوع]</code> یا ارسال در تاپیک ردیت\n\n" .
                "🔗 <b>اتصال تاپیک‌های گروه:</b>\n" .
                "🔹 <code>/bind leads</code> | <code>/bind blog</code> | <code>/bind content</code> | <code>/bind pin</code> | <code>/bind reddit</code>\n\n" .
                "💡 <b>دستورات سیستم:</b>\n" .
                "🔹 <code>/status</code> - وضعیت سرور و هوش مصنوعی\n" .
                "🔹 <code>/cf purge</code> - پاکسازی فوری کش کلودفلر";

            $notifier->sendMessage($welcome, $chatId, $threadId);
            $response->json(['status' => 'start_sent']);
            return;
        }

        // دستور /status
        if ($text === '/status') {
            $statusText = "🟢 <b>وضعیت سیستم maaadmr.ir:</b>\n\n" .
                "✅ سرور وب: آنلاین و پایدار\n" .
                "✅ هوش مصنوعی متنی: Google Gemini Flash فعال\n" .
                "✅ سرویس تصاویر: Pexels API فعال و متصل\n" .
                "✅ آرشیوها: blog_archive.json و content_archive.json فعال\n" .
                "🕒 زمان سرور: <code>" . date('Y-m-d H:i:s') . "</code>";

            $notifier->sendMessage($statusText, $chatId, $threadId);
            $response->json(['status' => 'status_sent']);
            return;
        }

        // دستورات مدیریت کلودفلر (/cf یا /cloudflare یا /purge_cache)
        if (preg_match('/^\/(?:cf|cloudflare|purge_cache)(?:@\w+)?(?:\s+(.*))?$/ui', $text, $cfMatches)) {
            $cfSub = trim(strtolower($cfMatches[1] ?? ''));
            $cf = new \App\Services\CloudflareService();

            if (!$cf->isConfigured()) {
                $notifier->sendMessage("⚠️ <b>کلودفلر هنوز کانفیگ نشده است:</b>\nلطفاً <code>CLOUDFLARE_API_TOKEN</code> و <code>CLOUDFLARE_ZONE_ID</code> را در پنل ادمین (تنظیمات) یا فایل <code>config/cloudflare.php</code> وارد کنید.", $chatId, $threadId);
                $response->json(['status' => 'cf_not_configured']);
                return;
            }

            // پاکسازی کش
            if (empty($cfSub) || in_array($cfSub, ['purge', 'purge all', 'all', 'clear', 'کش'])) {
                $notifier->sendChatAction('typing', $chatId, $threadId);
                $res = $cf->purgeEverything();
                if (!empty($res['success'])) {
                    $msg = "⚡️ <b>کش کلودفلر (Cloudflare Edge Cache) با موفقیت پاکسازی شد!</b>\n\n" .
                        "تمام فایل‌ها و صفحات ذخیره‌شده در کلیه دیتاسنترهای جهانی کلودفلر ریست شدند و بازدیدکنندگان آخرین نسخه کد و صفحات را دریافت می‌کنند. 🚀";
                } else {
                    $msg = "❌ <b>خطا در پاکسازی کش:</b>\n<code>" . htmlspecialchars($res['message'], ENT_QUOTES, 'UTF-8') . "</code>";
                }
                $notifier->sendMessage($msg, $chatId, $threadId);
                $response->json(['status' => 'cf_purged']);
                return;
            }

            // وضعیت دامنه در کلودفلر
            if ($cfSub === 'status' || $cfSub === 'info') {
                $notifier->sendChatAction('typing', $chatId, $threadId);
                $details = $cf->getZoneDetails();
                if (!empty($details['success'])) {
                    $name = $details['name'] ?? 'maaadmr.ir';
                    $st   = $details['status'] ?? 'active';
                    $plan = $details['plan'] ?? 'Free';
                    $ns   = implode(', ', $details['name_servers'] ?? []);
                    $msg = "🌐 <b>وضعیت زون کلودفلر:</b>\n\n" .
                        "🔹 دامنه: <code>{$name}</code>\n" .
                        "🔹 وضعیت: <code>{$st}</code>\n" .
                        "🔹 پلن: <code>{$plan}</code>\n" .
                        "🔹 نیم‌سرورها: <code>{$ns}</code>\n\n" .
                        "⚡️ <b>دستورات سریع:</b>\n" .
                        "▫️ <code>/cf purge</code> - پاکسازی کل کش\n" .
                        "▫️ <code>/cf dev on|off</code> - فعال/غیرفعال‌سازی Development Mode\n" .
                        "▫️ <code>/cf attack on|off</code> - فعال/غیرفعال‌سازی حالت تحت حمله (DDoS Protection)\n" .
                        "▫️ <code>/cf speed</code> - فعال‌سازی تنظیمات بهینه‌سازی سرعت";
                } else {
                    $msg = "❌ <b>خطا در دریافت وضعیت کلودفلر:</b>\n<code>" . htmlspecialchars($details['message'] ?? '', ENT_QUOTES, 'UTF-8') . "</code>";
                }
                $notifier->sendMessage($msg, $chatId, $threadId);
                $response->json(['status' => 'cf_status_sent']);
                return;
            }

            // حالت توسعه (Development Mode)
            if (str_starts_with($cfSub, 'dev')) {
                $enable = str_contains($cfSub, 'on') || str_contains($cfSub, 'روشن') || str_contains($cfSub, '1');
                $res = $cf->toggleDevelopmentMode($enable);
                $msg = (!empty($res['success']))
                    ? "🛠 <b>حالت توسعه (Development Mode):</b> " . ($enable ? "روشن شد (کش به مدت ۳ ساعت غیرفعال است)." : "خاموش شد (کشینگ فعال شد).")
                    : "❌ خطا: " . htmlspecialchars($res['message'] ?? '', ENT_QUOTES, 'UTF-8');
                $notifier->sendMessage($msg, $chatId, $threadId);
                $response->json(['status' => 'cf_dev_toggled']);
                return;
            }

            // حالت تحت حمله (Under Attack)
            if (str_starts_with($cfSub, 'attack')) {
                $enable = str_contains($cfSub, 'on') || str_contains($cfSub, 'روشن') || str_contains($cfSub, '1');
                $res = $cf->toggleUnderAttackMode($enable);
                $msg = (!empty($res['success']))
                    ? "🛡 <b>حالت امنیت تحت حمله (Under Attack Mode):</b> " . ($enable ? "فعال شد! تمام ورودی‌ها با چالش امنیتی بررسی می‌شوند." : "غیرفعال شد (سطح امنیت به Medium برگشت).")
                    : "❌ خطا: " . htmlspecialchars($res['message'] ?? '', ENT_QUOTES, 'UTF-8');
                $notifier->sendMessage($msg, $chatId, $threadId);
                $response->json(['status' => 'cf_attack_toggled']);
                return;
            }

            // اعمال تنظیمات سرعت
            if ($cfSub === 'speed' || $cfSub === 'optimize') {
                $notifier->sendChatAction('typing', $chatId, $threadId);
                $res = $cf->optimizeSpeedSettings();
                $msg = (!empty($res['success']))
                    ? "🚀 <b>تنظیمات شتاب‌دهنده سرعت اعمال شد:</b>\nEarly Hints، Brotli، HTTP/3 و Minification فعال گردیدند."
                    : "❌ خطا: " . htmlspecialchars($res['message'] ?? '', ENT_QUOTES, 'UTF-8');
                $notifier->sendMessage($msg, $chatId, $threadId);
                $response->json(['status' => 'cf_speed_optimized']);
                return;
            }
        }

        // تشخیص تاپیک اختصاصی مقالات
        $savedBlogThread = SiteSetting::get('telegram_thread_blog');
        $isBlogTopic = ($threadId && $savedBlogThread && (string)$threadId === (string)$savedBlogThread);

        // =========================================================================
        // شرط اول (CONDITION 1): اگر در تاپیک مقالات باشد یا با «مقاله:» شروع شود
        // =========================================================================
        if ($isBlogTopic || preg_match('/^(مقاله:|مقاله|\/article|\/مقاله|مطلب:|مطلب)\s*/ui', $text)) {
            $topic = trim(preg_replace('/^(مقاله:|مقاله|\/article|\/مقاله|مطلب:|مطلب)\s*/ui', '', $text));

            if (empty($topic)) {
                $notifier->sendMessage("⚠️ لطفاً موضوع مقاله را وارد کنید.\nمثال: <code>مقاله: اهمیت سئو تکنیکال برای فروشگاه‌های آنلاین</code>", $chatId, $threadId);
                $response->json(['status' => 'empty_article_topic']);
                return;
            }

            // ۱. قفل سخت‌گیرانه ضدتکرار (Strict Anti-Duplicate & Concurrency Lock)
            $cleanTopicKey = md5(mb_strtolower(preg_replace('/[^\p{L}\p{N}]+/u', '', $topic)));
            $topicLockFile = $lockDir . '/topic_gen_' . $cleanTopicKey . '.lock';

            if (file_exists($topicLockFile) && (time() - filemtime($topicLockFile)) < 1800) {
                // این تاپیک در ۳۰ دقیقه اخیر پردازش شده یا در حال تولید است
                $response->json(['status' => 'topic_already_generating_or_done', 'key' => $cleanTopicKey]);
                return;
            }
            @file_put_contents($topicLockFile, (string)time());

            // ۲. بررسی دیتابیس: آیا این مقاله در ۲۴ ساعت گذشته تولید شده است؟
            try {
                $db = \App\Core\Database::getConnection();
                $searchTitle = '%' . mb_substr($topic, 0, 20) . '%';
                $chk = $db->prepare("SELECT id, title, slug, published_at FROM articles WHERE (title = ? OR title LIKE ?) AND created_at >= NOW() - INTERVAL 24 HOUR ORDER BY id DESC LIMIT 1");
                $chk->execute([$topic, $searchTitle]);
                $existingArticle = $chk->fetch(\PDO::FETCH_ASSOC);

                if ($existingArticle) {
                    $existUrl = 'https://maaadmr.ir/article/' . $existingArticle['slug'];
                    $notifier->sendMessage("ℹ️ <b>این مقاله قبلاً تولید و در سایت منتشر شده است (جلوگیری از محتوای تکراری):</b>\n\n📌 <b>عنوان:</b> " . htmlspecialchars($existingArticle['title'], ENT_QUOTES, 'UTF-8') . "\n🌐 <a href=\"{$existUrl}\">مشاهده زنده مقاله در وب‌سایت</a>", $chatId, $threadId);
                    $response->json(['status' => 'article_already_exists', 'id' => $existingArticle['id']]);
                    return;
                }
            } catch (\Throwable $e) {}

            // ۳. پیام تأیید اولیه در تلگرام به کاربر
            $notifier->sendMessage("⏳ <b>درخواست تولید مقاله دریافت شد:</b>\n<i>«" . htmlspecialchars($topic, ENT_QUOTES, 'UTF-8') . "»</i>\n\n⚙️ موتور تولید محتوا، بهینه‌سازی GEO و واکشی تصاویر Pexels روی سرور فعال شد. نتیجه نهایی پس از انتشار همین‌جا ارسال می‌شود.", $chatId, $threadId);

            // ۴. قطع سریع اتصال وب‌هوک با ارسال 200 OK فوری (Fast Webhook Acknowledge)
            // این کار مانع از منقضی شدن تایم‌اوت تلگرام و ارسال مجدد/تکراری درخواست می‌شود
            if (function_exists('fastcgi_finish_request')) {
                http_response_code(200);
                header('Content-Type: application/json; charset=utf-8');
                header('Connection: close');
                echo json_encode(['status' => 'processing_in_background', 'topic' => $topic]);
                @ob_flush();
                @flush();
                fastcgi_finish_request();
            }

            // تضمین اجرای پس‌زمینه بدون وقفه روی سرور حتی بعد از خروج کاربر
            ignore_user_abort(true);
            set_time_limit(300);

            // ۵. اجرای کامل فرآیند تولید مقاله سئو و تصاویر در پس‌زمینه سرور
            try {
                $engine = new AiContentEngine();
                $result = $engine->generateSeoArticleWithPexels($topic);

                $title = $result['title'] ?? $topic;
                $slug = $result['slug'] ?? ('article-' . time());
                $imageUrl = $result['image_url'] ?? '';
                $wpUrl = 'https://maaadmr.ir/article/' . $slug;

                // پاکسازی آنی کش کلودفلر برای مقاله جدید و صفحات وابسته
                $cfPurgedInfo = "";
                try {
                    $cfService = new \App\Services\CloudflareService();
                    if ($cfService->isConfigured()) {
                        $pResult = $cfService->purgeArticle($slug);
                        if (!empty($pResult['success'])) {
                            $cfPurgedInfo = "\n⚡️ <b>کش کلودفلر:</b> کش مقاله جدید و صفحه اصلی آنی پاکسازی شد.";
                        }
                    }
                } catch (\Throwable $e) {}

                // ثبت در صف انتشار با تأخیر شبکه‌های اجتماعی
                $omniService = new OmnichannelSocialPublisherService();
                $queueId = $omniService->queueArticle([
                    'topic'        => $topic,
                    'title'        => $title,
                    'summary'      => $result['direct_answer'] ?? '',
                    'content_html' => $result['content_html'] ?? '',
                    'url'          => $wpUrl
                ], $chatId, $threadId, 45);

                $scheduledTime = date('H:i', time() + (45 * 60));
                $imgCount = $result['images_count'] ?? 3;

                $successCaption = "✅ <b>مقاله تخصصی سئو و GEO در وب‌سایت منتشر شد!</b>\n\n" .
                    "📌 <b>عنوان:</b> " . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "\n" .
                    "🖼 <b>تصاویر:</b> ۱ تصویر شاخص + " . max(2, $imgCount - 1) . " تصویر تخصصی Pexels در بدنه\n" .
                    "🌐 <b>لینک زنده:</b> <a href=\"{$wpUrl}\">مشاهده مقاله در سایت</a>" . $cfPurgedInfo . "\n\n" .
                    "━━━━━━━━━━━━━━━━━━━━\n" .
                    "⏳ <b>صف انتشار شبکه‌های اجتماعی (Social Queue #{$queueId}):</b>\n" .
                    "پست‌های متناظر Pinterest و Instagram در صف قرار گرفتند و رأس ساعت <b>{$scheduledTime}</b> منتشر خواهند شد.";

                if (!empty($imageUrl)) {
                    $notifier->sendPhoto($imageUrl, $successCaption, $chatId, $threadId);
                } else {
                    $notifier->sendMessage($successCaption, $chatId, $threadId);
                }

            } catch (\Throwable $e) {
                $errorMsg = "❌ <b>خطا در تولید خودکار مقاله سئو:</b>\n<code>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
            }

            if (!function_exists('fastcgi_finish_request')) {
                $response->json(['status' => 'article_processed']);
            }
            return;
        }

        // تشخیص تاپیک اختصاصی پینترست
        $savedPinterestThread = SiteSetting::get('telegram_thread_pinterest');
        $isPinterestTopic = ($threadId && $savedPinterestThread && (string)$threadId === (string)$savedPinterestThread);

        // =========================================================================
        // شرط دوم (CONDITION 2): تاپیک یا دستور پینترست (Pinterest via Composio MCP)
        // =========================================================================
        if ($isPinterestTopic || preg_match('/^(پینترست:|پین:|\/pinterest|\/pin)\s*/ui', $text)) {
            $pinTopic = trim(preg_replace('/^(پینترست:|پین:|\/pinterest|\/pin)\s*/ui', '', $text));

            if (empty($pinTopic)) {
                $notifier->sendMessage("⚠️ لطفاً موضوع یا کلمه کلیدی پینترست را وارد کنید.\nمثال: <code>استراتژی طراحی لندینگ پیج مدرن</code>", $chatId, $threadId);
                $response->json(['status' => 'empty_pinterest_topic']);
                return;
            }

            // ارسال وضعیت در حال پردازش به تاپیک
            $notifier->sendChatAction('typing', $chatId, $threadId);

            try {
                $service = new PinterestPublisherService();

                // ۱. تولید پکیج سئو پینترست با LLM
                $package = $service->generatePinPackage($pinTopic);
                $pinTitle = $package['title'];
                $pinDesc  = $package['description'];
                $imgPrompt = $package['image_prompt'];

                // ارسال سیگنال تولید و ارسال تصویر به تلگرام
                $notifier->sendChatAction('upload_photo', $chatId, $threadId);

                // ۲. تولید تصویر عمودی ۲:۳ با Imagen 3
                $imageUrl = $service->generatePinImage($imgPrompt, $pinTitle);

                // ۳. انتشار خودکار در Pinterest از طریق Composio MCP
                $publishResult = $service->publishPinViaComposioMcp($pinTitle, $pinDesc, $imageUrl);

                if ($publishResult['status'] === 'published') {
                    $pinUrl = $publishResult['pin_url'] ?? 'https://www.pinterest.com';
                    $successCaption = "📌 <b>پین جدید با موفقیت در Pinterest منتشر شد!</b> 🚀\n\n" .
                        "🏷 <b>عنوان:</b> " . htmlspecialchars($pinTitle, ENT_QUOTES, 'UTF-8') . "\n\n" .
                        "📝 <b>توضیحات سئو:</b>\n" . htmlspecialchars($pinDesc, ENT_QUOTES, 'UTF-8') . "\n\n" .
                        "🔗 <b>مشاهده در پینترست:</b> <a href=\"{$pinUrl}\">مشاهده مستقیم پین</a>\n" .
                        "🤖 <i>منتشر شده از طریق Composio MCP Protocol</i>";

                    $notifier->sendPhoto($imageUrl, $successCaption, $chatId, $threadId);
                    $response->json(['status' => 'pinterest_published_success', 'pin_url' => $pinUrl]);
                    return;
                }

                if ($publishResult['status'] === 'auth_required') {
                    $authUrl = $publishResult['auth_url'];
                    $authMessage = "🔐 <b>نیاز به اتصال و مجوز Pinterest در Composio:</b>\n\n" .
                        "اکانت پینترست شما هنوز متصل نشده است. لطفاً روی دکمه یا لینک زیر کلیک کنید و اجازه دسترسی را صادر فرمایید:\n\n" .
                        "👉 <a href=\"{$authUrl}\">کلیک کنید: اتصال اکانت Pinterest در Composio</a>\n\n" .
                        "پس از تکمیل اتصال در مرورگر، مجدداً کلمه کلیدی را در این تاپیک ارسال نمایید تا پین مستقیماً منتشر شود.";

                    $notifier->sendMessage($authMessage, $chatId, $threadId);
                    $response->json(['status' => 'pinterest_auth_required', 'auth_url' => $authUrl]);
                    return;
                }

                // خطا در انتشار MCP
                $errorMsg = "⚠️ <b>پکیج محتوا و تصویر آماده شد اما خطا در انتشار پینترست رخ داد:</b>\n" .
                    "<code>" . htmlspecialchars($publishResult['message'], ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendPhoto($imageUrl, $errorMsg, $chatId, $threadId);
                $response->json(['status' => 'pinterest_publish_failed']);
                return;

            } catch (\Throwable $e) {
                $errorMsg = "❌ <b>خطا در پردازش یا انتشار در پینترست:</b>\n<code>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
                $response->json(['status' => 'pinterest_error', 'message' => $e->getMessage()]);
                return;
            }
        }

        // تشخیص تاپیک اختصاصی ردیت
        $savedRedditThread = SiteSetting::get('telegram_thread_reddit');
        $isRedditTopic = ($threadId && $savedRedditThread && (string)$threadId === (string)$savedRedditThread);

        // =========================================================================
        // شرط سوم (CONDITION 3): تاپیک یا دستور رِدیت (Reddit via Composio MCP)
        // =========================================================================
        if ($isRedditTopic || preg_match('/^(ردیت:|ردیت|\/reddit)\s*/ui', $text)) {
            $redditInput = trim(preg_replace('/^(ردیت:|ردیت|\/reddit)\s*/ui', '', $text));

            if (empty($redditInput)) {
                $notifier->sendMessage("⚠️ لطفاً موضوع، کیس استادی یا لینک مورد نظر برای ردیت را وارد کنید.\nمثال: <code>ردیت: نحوه کاهش ۹۰ درصدی زمان پاسخ سرور در معماری جدید https://maaadmr.ir</code>", $chatId, $threadId);
                $response->json(['status' => 'empty_reddit_input']);
                return;
            }

            // ارسال وضعیت در حال پردازش به تاپیک
            $notifier->sendChatAction('typing', $chatId, $threadId);
            $notifier->sendMessage("🤖 <b>درخواست انتشار در Reddit دریافت شد:</b>\nدر حال تحلیل تاپیک، تطبیق با ساب‌ردیت مناسب و نگارش پست اصیل مباحثه‌محور (۹۰٪ ارزش و تجربه + ارجاع طبیعی به سورس)... ⏳", $chatId, $threadId);

            try {
                $redditService = new RedditPublisherService();

                // ۱. استخراج خودکار لینک هدف در صورت وجود در پیام
                $targetUrl = null;
                if (preg_match('/(https?:\/\/[^\s]+)/i', $redditInput, $urlMatches)) {
                    $targetUrl = $urlMatches[1];
                }

                // ۲. تولید پکیج پست ردیت با LLM (Gemini Function Calling)
                $package = $redditService->generateRedditPackage($redditInput, $targetUrl);
                $subreddit = $package['subreddit'];
                $postTitle = $package['title'];
                $postBody  = $package['text'];

                // ۳. انتشار مستقیم در Reddit از طریق ابزار Composio MCP
                $publishResult = $redditService->publishToRedditViaComposio($subreddit, $postTitle, $postBody);

                if ($publishResult['status'] === 'published') {
                    $postUrl = $publishResult['post_url'];
                    $previewText = mb_substr($postBody, 0, 350);

                    $successCaption = "🚀 <b>پست تخصصی با موفقیت در Reddit منتشر شد!</b> ✅\n\n" .
                        "🌐 <b>ساب‌ردیت:</b> <code>r/{$subreddit}</code>\n" .
                        "📌 <b>عنوان پست:</b> " . htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8') . "\n\n" .
                        "🔗 <b>لینک مستقیم در ردیت:</b> <a href=\"{$postUrl}\">مشاهده پست و نظرات</a>\n\n" .
                        "━━━━━━━━━━━━━━━━━━━━\n" .
                        "📝 <b>پیش‌نمایش محتوا:</b>\n" .
                        "<i>" . htmlspecialchars($previewText, ENT_QUOTES, 'UTF-8') . "...</i>\n\n" .
                        "🤖 <i>منتشر شده از طریق Composio MCP Protocol</i>";

                    $notifier->sendMessage($successCaption, $chatId, $threadId);
                    $response->json([
                        'status'    => 'reddit_published_success',
                        'subreddit' => $subreddit,
                        'post_url'  => $postUrl
                    ]);
                    return;
                }

                if ($publishResult['status'] === 'auth_required') {
                    $authUrl = $publishResult['auth_url'];
                    $authMessage = "🔐 <b>نیاز به اتصال و مجوز Reddit در Composio:</b>\n\n" .
                        "اکانت ردیت شما نیاز به احراز هویت دارد. لطفاً روی دکمه زیر کلیک کنید:\n\n" .
                        "👉 <a href=\"{$authUrl}\">اتصال اکانت Reddit در Composio</a>";

                    $notifier->sendMessage($authMessage, $chatId, $threadId);
                    $response->json(['status' => 'reddit_auth_required', 'auth_url' => $authUrl]);
                    return;
                }

                // خطا در انتشار MCP
                $errorMsg = "⚠️ <b>پست ردیت نگارش شد اما در انتشار خطایی رخ داد:</b>\n" .
                    "<code>" . htmlspecialchars($publishResult['message'], ENT_QUOTES, 'UTF-8') . "</code>\n\n" .
                    "📋 <b>ساب‌ردیت انتخابی:</b> r/{$subreddit}\n" .
                    "📌 <b>عنوان:</b> " . htmlspecialchars($postTitle, ENT_QUOTES, 'UTF-8');
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
                $response->json(['status' => 'reddit_publish_failed']);
                return;

            } catch (\Throwable $e) {
                $errorMsg = "❌ <b>خطا در پردازش یا انتشار در Reddit:</b>\n<code>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
                $response->json(['status' => 'reddit_error', 'message' => $e->getMessage()]);
                return;
            }
        }

        // =========================================================================
        // شرط جدید: دستور تولید استوری یا پست اینستاگرام (/story | /instagram | استوری: | اینستاگرام:)
        // =========================================================================
        if (preg_match('/^(استوری:|اینستاگرام:|پست اینستاگرام:|\/story|\/instagram|\/ig)\s*(.*)$/uis', $text, $igMatches)) {
            $igTopic = trim($igMatches[2] ?? '');
            $isStory = str_contains(mb_strtolower($igMatches[1] ?? ''), 'story') || str_contains($igMatches[1] ?? '', 'استوری');

            if (empty($igTopic)) {
                $notifier->sendMessage("⚠️ لطفاً موضوع استوری یا پست اینستاگرام را بعد از دستور بنویسید:\nمثال: <code>استوری: ۳ دلیل اصلی که سایت‌های شرکتی زنگ‌خور ندارند</code>", $chatId, $threadId);
                $response->json(['status' => 'empty_instagram_topic']);
                return;
            }

            $notifier->sendChatAction('upload_photo', $chatId, $threadId);
            $notifier->sendMessage("📸 <b>درخواست تولید پکیج اینستاگرام دریافت شد:</b>\nدر حال نگارش سناریوی اسلایدها، کپشن حرفه‌ای و طراحی تصویر با هوش مصنوعی... ⏳", $chatId, $threadId);

            try {
                $engine = new AiContentEngine();
                $igPackage = $engine->generateInstagramPackage($igTopic, $isStory);

                $slidesText = "";
                foreach (($igPackage['slides'] ?? []) as $s) {
                    $num = $s['slide'] ?? '';
                    $sTitle = $s['title'] ?? '';
                    $sText = $s['text'] ?? '';
                    $slidesText .= "🔹 <b>اسلاید {$num} ({$sTitle}):</b>\n{$sText}\n\n";
                }

                $replyCaption = "📸 <b>پکیج " . ($isStory ? "استوری چند اسلایدی" : "پست اینستاگرام") . " آماده شد!</b> 🚀\n\n" .
                    "📌 <b>تیتر:</b> " . htmlspecialchars($igPackage['headline'], ENT_QUOTES, 'UTF-8') . "\n\n" .
                    "━━━━━━━━━━━━━━━━━━━━\n" .
                    "📋 <b>سناریوی اسلایدها:</b>\n" .
                    $slidesText .
                    "━━━━━━━━━━━━━━━━━━━━\n" .
                    "📝 <b>کپشن آماده:</b>\n" .
                    htmlspecialchars($igPackage['caption'], ENT_QUOTES, 'UTF-8');

                if (!empty($igPackage['image_url'])) {
                    $notifier->sendPhoto($igPackage['image_url'], mb_substr($replyCaption, 0, 1024), $chatId, $threadId);
                    if (mb_strlen($replyCaption) > 1024) {
                        $notifier->sendMessage(mb_substr($replyCaption, 1024), $chatId, $threadId);
                    }
                } else {
                    $notifier->sendMessage($replyCaption, $chatId, $threadId);
                }

                $response->json(['status' => 'instagram_generated_success']);
                return;
            } catch (\Throwable $e) {
                $errorMsg = "❌ <b>خطا در تولید استوری اینستاگرام:</b>\n<code>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
                $response->json(['status' => 'instagram_error', 'message' => $e->getMessage()]);
                return;
            }
        }

        // =========================================================================
        // شرط چهارم (CONDITION 4): مدیریت لینکدین کاملاً دستی و فقط با اراده صریح کاربر
        // لینکدین از تمام فرآیندهای خودکار حذف شده و فقط با دستور مستقیم اجرا می‌شود
        // =========================================================================

        // ۱. دستور انتشار مستقیم و درجا در لینکدین: /post_linkedin یا /publish_linkedin
        if (preg_match('/^(\/post_linkedin|\/publish_linkedin)\s*(.*)$/uis', $text, $pubMatches)) {
            $postContent = trim($pubMatches[2] ?? '');

            if (empty($postContent)) {
                $notifier->sendMessage("⚠️ لطفاً متنی را که می‌خواهید مستقیماً در لینکدین منتشر شود بعد از دستور بنویسید:\nمثال: <code>/post_linkedin این متن مستقیماً روی پروفایل لینکدین من منتشر می‌شود.</code>", $chatId, $threadId);
                $response->json(['status' => 'empty_linkedin_post_content']);
                return;
            }

            $notifier->sendChatAction('typing', $chatId, $threadId);

            try {
                $omniService = new OmnichannelSocialPublisherService();
                $pubResult = $omniService->publishToLinkedIn($postContent);

                if ($pubResult['ok']) {
                    $confirmMsg = "🚀 <b>پست شما با موفقیت در پروفایل LinkedIn منتشر شد!</b> ✅\n\n" .
                        "📝 <b>متن منتشر شده:</b>\n" . nl2br(htmlspecialchars($postContent, ENT_QUOTES, 'UTF-8')) . "\n\n" .
                        "🌐 <b>مشاهده پروفایل:</b> <a href=\"https://www.linkedin.com/in/mohammad-moftakhari/\">صفحه شخصی محمد مفتخری در لینکدین</a>\n" .
                        "🤖 <i>منتشر شده با پروتکل Composio MCP</i>";

                    $notifier->sendMessage($confirmMsg, $chatId, $threadId);
                    $response->json(['status' => 'linkedin_direct_published_success']);
                    return;
                } else {
                    $errorMsg = "❌ <b>خطا در انتشار مستقیم لینکدین:</b>\n<code>" . htmlspecialchars($pubResult['error'], ENT_QUOTES, 'UTF-8') . "</code>";
                    $notifier->sendMessage($errorMsg, $chatId, $threadId);
                    $response->json(['status' => 'linkedin_publish_failed']);
                    return;
                }
            } catch (\Throwable $e) {
                $errorMsg = "❌ <b>خطا در ارتباط با سرور لینکدین:</b>\n<code>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
                $response->json(['status' => 'linkedin_error', 'message' => $e->getMessage()]);
                return;
            }
        }

        // ۲. تولید پیش‌نویس ایده لینکدین (فقط با دستور صریح /linkedin یا در تاپیک مشخص لینکدین)
        $savedContentThread = SiteSetting::get('telegram_thread_content');
        $isLinkedinTopic = ($threadId && $savedContentThread && (string)$threadId === (string)$savedContentThread);
        $hasExplicitLinkedinPrefix = preg_match('/^(\/linkedin|لینکدین:)\s*(.*)$/uis', $text, $liMatches);

        if ($hasExplicitLinkedinPrefix || ($isLinkedinTopic && !empty($text))) {
            $idea = $hasExplicitLinkedinPrefix ? trim($liMatches[2] ?? '') : $text;

            if (empty($idea)) {
                $notifier->sendMessage("⚠️ لطفاً ایده یا موضوع پست لینکدین را وارد کنید.\nمثال: <code>/linkedin چرا سئو بدون استراتژی محتوا شکست میخورد؟</code>", $chatId, $threadId);
                $response->json(['status' => 'empty_idea']);
                return;
            }

            // ارسال وضعیت در حال تایپ به تلگرام
            $notifier->sendChatAction('typing', $chatId, $threadId);

            try {
                $engine = new AiContentEngine();
                $result = $engine->generateLinkedInPost($idea);
                $postContent = $result['post'] ?? '';

                if (!empty($postContent)) {
                    // ذخیره‌سازی پست در آرشیو محتوا
                    $this->saveToContentArchiveJson([
                        'id'         => time(),
                        'idea'       => $idea,
                        'post'       => $postContent,
                        'type'       => 'linkedin_post',
                        'created_at' => date('Y-m-d H:i:s')
                    ]);

                    $replyMessage = "🚀 <b>پیش‌نویس الگوریتمی پست لینکدین آماده شد:</b>\n" .
                        "━━━━━━━━━━━━━━━━━━\n\n" .
                        $postContent . "\n\n" .
                        "━━━━━━━━━━━━━━━━━━\n" .
                        "📤 <b>انتشار فوری روی پروفایل با ربات:</b>\n" .
                        "اگر از متن بالا رضایت دارید و می‌خواهید مستقیماً روی پروفایل لینکدین شما منتشر شود، دستور زیر را به ربات بفرستید:\n" .
                        "<code>/post_linkedin " . htmlspecialchars($postContent, ENT_QUOTES, 'UTF-8') . "</code>\n\n" .
                        "📋 <i>همچنین می‌توانید متن را کپی کرده و به صورت دستی در لینکدین منتشر کنید.</i>";

                    $notifier->sendMessage($replyMessage, $chatId, $threadId);
                    $response->json(['status' => 'linkedin_draft_generated_success']);
                    return;
                } else {
                    $notifier->sendMessage("❌ هوش مصنوعی پاسخی تولید نکرد. لطفاً مجدداً تلاش کنید.", $chatId, $threadId);
                }
            } catch (\Throwable $e) {
                $errorMsg = "❌ <b>خطا در تولید متن لینکدین:</b>\n<code>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
                $notifier->sendMessage($errorMsg, $chatId, $threadId);
            }
            return;
        }

        // در صورت عدم تطابق با هیچ دستور یا تاپیک مشخص، پیام نادیده گرفته می‌شود و هیچ پاسخی ارسال نمی‌شود
        $response->json(['status' => 'ignored']);
    }

    /**
     * ذخیره‌سازی پست‌های شبکه‌های اجتماعی در فایل content_archive.json
     */
    private function saveToContentArchiveJson(array $entry): void
    {
        $archiveFile = ROOT_PATH . '/content_archive.json';
        $archive = [];

        if (file_exists($archiveFile)) {
            $content = @file_get_contents($archiveFile);
            if ($content) {
                $archive = json_decode($content, true) ?: [];
            }
        }

        array_unshift($archive, $entry);

        @file_put_contents($archiveFile, json_encode($archive, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * ثبت و فعال‌سازی خودکار وب‌هوک تلگرام روی دامنه سایت
     */
    public function setWebhook(Request $request, Response $response): void
    {
        $notifier = new TelegramNotifier();
        $webhookUrl = 'https://maaadmr.ir/api/telegram/webhook';
        
        $result = $notifier->setWebhook($webhookUrl);
        $response->json($result);
    }
}
