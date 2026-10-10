<?php
declare(strict_types=1);

/**
 * Omnichannel Delayed Social Worker (Cron Job Script)
 * Executes pending social posts (Pinterest & Instagram) after the scheduled delay
 * Run via Crontab every 5 minutes:
 * * /5 * * * * php /home/youruser/public_html/bin/social_queue_worker.php >> /home/youruser/logs/social_cron.log 2>&1
 *
 * Mohammad Moftakhari CMS (maaadmr.ir)
 */

// تنظیم مسیر ریشه پروژه
define('ROOT_PATH', dirname(__DIR__));

// ثبت خودکار کلاس‌ها (Autoloader)
spl_autoload_register(function (string $class) {
    $prefix = 'App\\';
    $baseDir = ROOT_PATH . '/app/';

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

use App\Core\Database;
use App\Services\OmnichannelSocialPublisherService;
use App\Services\TelegramNotifier;

echo "[" . date('Y-m-d H:i:s') . "] Starting Social Queue Worker...\n";

try {
    $service = new OmnichannelSocialPublisherService();
    $service->ensureTableExists();

    $pdo = Database::getConnection();

    // استخراج تسک‌های سررسید شده که هنوز در صف هستند
    $stmt = $pdo->prepare("SELECT * FROM `social_queue` 
        WHERE `status` = 'pending' AND `publish_at` <= NOW() 
        ORDER BY `id` ASC LIMIT 5");
    $stmt->execute();
    $jobs = $stmt->fetchAll();

    if (empty($jobs)) {
        echo "[" . date('Y-m-d H:i:s') . "] No pending jobs due for publishing.\n";
        exit(0);
    }

    echo "[" . date('Y-m-d H:i:s') . "] Found " . count($jobs) . " job(s) ready to publish.\n";

    $notifier = new TelegramNotifier();

    foreach ($jobs as $job) {
        $jobId = (int)$job['id'];
        $chatId = (string)$job['chat_id'];
        $threadId = !empty($job['message_thread_id']) ? (string)$job['message_thread_id'] : null;
        $title = (string)$job['article_title'];
        $wpUrl = (string)$job['wp_url'];

        echo " -> Processing Job #{$jobId} (Title: {$title})...\n";

        // قفل کردن رکورد جهت جلوگیری از اجرای موازی
        $lockStmt = $pdo->prepare("UPDATE `social_queue` SET `status` = 'processing' WHERE `id` = :id AND `status` = 'pending'");
        $lockStmt->execute([':id' => $jobId]);
        if ($lockStmt->rowCount() === 0) {
            echo "    Job #{$jobId} already taken by another process.\n";
            continue;
        }

        try {
            // ۱. تولید متون مشتق‌شده برای Pinterest و Instagram از بدنه مقاله وبلاگ (بدون لینکدین)
            echo "    Generating spin-off copy with LLM (Pinterest & Instagram only)...\n";
            $spinOffs = $service->generateSpinOffs($title, (string)($job['article_content'] ?: $job['article_summary']));

            $pinData = $spinOffs['pinterest'];
            $igData  = $spinOffs['instagram'];

            // ۲. تولید رسانه‌های تصویری مجزا برای هر پلتفرم
            echo "    Generating vertical 2:3 asset for Pinterest...\n";
            $pinImage = $service->generatePlatformAsset($pinData['image_prompt'], '3:4', 'pin');

            echo "    Generating square 1:1 asset for Instagram...\n";
            $igImage  = $service->generatePlatformAsset($igData['image_prompt'], '1:1', 'ig');

            // ۳. انتشار در Pinterest از طریق Composio MCP
            echo "    Publishing Pin via Composio MCP...\n";
            $pinResult = $service->publishToPinterest($pinData['title'], $pinData['description'], $pinImage, $wpUrl);
            $pinUrl = $pinResult['ok'] ? ($pinResult['pin_url'] ?? 'https://www.pinterest.com') : null;

            // ۴. انتشار در Instagram از طریق Composio MCP
            echo "    Publishing Instagram Post via Composio MCP...\n";
            $igResult = $service->publishToInstagram($igData['caption'], $igImage);
            $igUrl = $igResult['ok'] ? ($igResult['post_url'] ?? 'https://www.instagram.com/maaad_mr/') : null;

            // ۵. به‌روزرسانی وضعیت در دیتابیس
            $updateStmt = $pdo->prepare("UPDATE `social_queue` SET 
                `status` = 'completed',
                `pinterest_status` = :pin_status,
                `pinterest_pin_url` = :pin_url,
                `instagram_status` = :ig_status,
                `instagram_post_url` = :ig_url,
                `processed_at` = NOW()
                WHERE `id` = :id");

            $updateStmt->execute([
                ':pin_status' => $pinResult['ok'] ? 'published' : 'failed',
                ':pin_url'    => $pinUrl,
                ':ig_status'  => $igResult['ok'] ? 'published' : 'failed',
                ':ig_url'     => $igUrl,
                ':id'         => $jobId
            ]);

            // ۶. ارسال گزارش نهایی انتشار (Fulfillment Report) به همان تاپیک تلگرام
            $fulfillmentMsg = "🚀 <b>گزارش انتشار خودکار چندکاناله (Omnichannel Fulfillment):</b>\n\n" .
                "📌 <b>موضوع اصلی:</b> <code>" . htmlspecialchars((string)$job['topic'], ENT_QUOTES, 'UTF-8') . "</code>\n" .
                "🌐 <b>مقاله وب‌سایت:</b> <a href=\"{$wpUrl}\">" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "</a>\n\n" .
                "━━━━━━━━━━━━━━━━━━━━\n" .
                "📌 <b>پینترست (Pinterest):</b> " . ($pinResult['ok'] ? "<a href=\"{$pinUrl}\">مشاهده Pin منتشر شده</a> ✅" : "⚠️ خطا در انتشار") . "\n" .
                "📸 <b>اینستاگرام (Instagram):</b> " . ($igResult['ok'] ? "<a href=\"{$igUrl}\">مشاهده Post اینستاگرام</a> ✅" : "⚠️ خطا در انتشار") . "\n" .
                "━━━━━━━━━━━━━━━━━━━━\n" .
                "⏱ <i>تأخیر برنامه‌ریزی‌شده (۴۵ دقیقه پس از انتشار وب‌سایت) با موفقیت اجرا شد. لینکدین طبق درخواست حذف گردید.</i>";

            $notifier->sendMessage($fulfillmentMsg, $chatId, $threadId);

            echo "    Job #{$jobId} completed successfully!\n";

        } catch (\Throwable $jobError) {
            echo "    Job #{$jobId} failed: " . $jobError->getMessage() . "\n";

            $failStmt = $pdo->prepare("UPDATE `social_queue` SET `status` = 'failed', `error_message` = :err WHERE `id` = :id");
            $failStmt->execute([
                ':err' => $jobError->getMessage(),
                ':id'  => $jobId
            ]);

            $errorMsg = "❌ <b>خطا در اجرای صف انتشار خودکار پینترست و اینستاگرام (Job #{$jobId}):</b>\n<code>" . htmlspecialchars($jobError->getMessage(), ENT_QUOTES, 'UTF-8') . "</code>";
            $notifier->sendMessage($errorMsg, $chatId, $threadId);
        }
    }

} catch (\Throwable $globalError) {
    echo "[" . date('Y-m-d H:i:s') . "] Fatal Worker Error: " . $globalError->getMessage() . "\n";
    exit(1);
}

echo "[" . date('Y-m-d H:i:s') . "] Social Queue Worker finished.\n";
