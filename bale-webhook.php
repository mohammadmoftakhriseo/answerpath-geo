<?php
declare(strict_types=1);

/**
 * Bale Bot Interactive Webhook & Lead Dispatcher (@maaad_mrbot)
 * بازوی هوشمند تعاملی و پرزنت محمد مفتخری + دریافت لحظه‌ای لیدهای وب‌سایت
 * https://maaadmr.ir
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
use App\Models\Article;
use App\Services\BaleNotifier;

header('Content-Type: application/json; charset=utf-8');

$rawInput = file_get_contents('php://input');
if (empty($rawInput)) {
    echo json_encode(['ok' => true, 'message' => 'Bale Webhook is alive and listening for @maaad_mrbot.']);
    exit;
}

$update = json_decode($rawInput, true);
if (!is_array($update)) {
    echo json_encode(['ok' => false, 'error' => 'Invalid JSON payload']);
    exit;
}

error_log('[BaleWebhook] Received: ' . $rawInput);

$message = $update['message'] ?? $update['callback_query']['message'] ?? null;
if (!$message) {
    echo json_encode(['ok' => true, 'message' => 'No message payload.']);
    exit;
}

$chatId     = (string)($message['chat']['id'] ?? '');
$fromId     = (string)($message['from']['id'] ?? $chatId);
$senderName = trim(($message['from']['first_name'] ?? '') . ' ' . ($message['from']['last_name'] ?? ''));
$username   = trim((string)($message['from']['username'] ?? ''));
$rawText    = trim((string)($message['text'] ?? ''));

if (empty($chatId)) {
    echo json_encode(['ok' => false, 'error' => 'Missing chat_id']);
    exit;
}

// ==============================================================
// مشخصات ثابت مدیر و اطلاعات پایه
// ==============================================================
$ADMIN_CHAT_ID   = '1407876421'; // محمد مفتخری - قفل‌شده و تغییرناپذیر
$OWNER_NAME      = 'محمد مفتخری';
$OWNER_TITLE     = 'استراتژیست ارشد سئو، هوش مصنوعی و اتوماسیون وب';
$WEBSITE_URL     = 'https://maaadmr.ir';
$ARTICLES_URL    = 'https://maaadmr.ir/articles';
$CHANNEL_ID      = '@persiansej';
$CHANNEL_URL     = 'https://ble.ir/persiansej';
$CHANNEL_TG_URL  = 'https://t.me/PersianSEJ';
$ABOUT_URL       = 'https://maaadmr.ir/about';
$CONTACT_PHONE   = '09302928001';
$SUPPORT_BALE_ID = '@maaad_mr';

$isAdmin = ($chatId === $ADMIN_CHAT_ID);

// قفل کردن شناسه دریافت لیدها به مدیر
SiteSetting::set('bale_chat_id', $ADMIN_CHAT_ID);

// نرمال‌سازی متن ورودی جهت تطبیق هوشمند دکمه‌ها
function normalizeText(string $text): string {
    $text = str_replace(["\u{200c}", "\u{200d}", "\u{200b}", "\u{200e}", "\u{200f}", "\xc2\xa0"], " ", $text);
    $text = str_replace(["ي", "ك"], ["ی", "ک"], $text);
    $text = str_replace(["\r", "\n"], " ", $text);
    $text = preg_replace('/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F1E0}-\x{1F1FF}\x{2702}-\x{27B0}\x{24C2}-\x{1F251}\x{1F900}-\x{1F9FF}\x{1FA70}-\x{1FAFF}]/u', ' ', $text);
    return trim((string)preg_replace('/\s+/u', ' ', $text));
}

$norm = normalizeText($rawText);

// منوی شناور ثابت پایین صفحه (Persistent 2x3 Keyboard)
$mainKeyboard = [
    'keyboard' => [
        [['text' => '📰 مقالات و تحلیل‌های سئو'], ['text' => '👨‍💻 درباره محمد مفتخری']],
        [['text' => '💼 تخصص‌ها و خدمات'], ['text' => '🌐 ورود به وب‌سایت شخصی']],
        [['text' => '📞 مشاوره و ارتباط مستقیم'], ['text' => '📢 کانال سئو @persiansej']],
    ],
    'resize_keyboard' => true,
];

$bale = new BaleNotifier();

// ==============================================================
// سناریوی ۱: دستور /start
// ==============================================================
if ($rawText === '/start' || $norm === 'شروع' || $norm === 'start') {
    if ($isAdmin) {
        $text = "🎉 *سلام مهندس محمد مفتخری عزیز!*\n\n" .
            "✅ *بازوی هوشمند وب‌سایت شما (maaadmr.ir) متصل و کاملاً فعال است.*\n\n" .
            "📌 *وضعیت دریافت لیدها:* شناسه چت شما ({$ADMIN_CHAT_ID}) به صورت دائمی به عنوان مقصد دریافت فرم‌های مشاوره، تماس‌ها و لیدهای سایت ثبت شده است.\n\n" .
            "🚀 سایر کاربران هنگام تعامل با بازو، پورتفولیو، خدمات و مقالات شما را مشاهده کرده و می‌توانند درخواست مشاوره ثبت کنند.";

        $glass = [
            'inline_keyboard' => [
                [
                    ['text' => '🌐 ورود به پنل مدیریت سایت', 'url' => "{$WEBSITE_URL}/admin"],
                    ['text' => '🌐 مشاهده سایت شخصی', 'url' => $WEBSITE_URL],
                ],
                [
                    ['text' => '📢 کانال بله SEJ', 'url' => $CHANNEL_URL],
                    ['text' => '📢 کانال تلگرام SEJ', 'url' => $CHANNEL_TG_URL],
                ]
            ]
        ];
        $bale->sendMessage($text, $chatId, 'Markdown', $mainKeyboard);
        $bale->sendMessage("👇 *دسترسی سریع به سامانه‌ها:*", $chatId, 'Markdown', $glass);
    } else {
        $displayName = $senderName ?: 'کاربر گرامی';
        $text = "سلام *{$displayName}* عزیز! بسیار خوش آمدید. 🌟\n\n" .
            "من بازوی رسمی و تعاملی *{$OWNER_NAME}* هستم.\n" .
            "_{$OWNER_TITLE}_\n\n" .
            "از طریق این بازو می‌توانید به جدیدترین مقالات تخصصی سئو و هوش مصنوعی، شرح خدمات، " .
            "پورتفولیو و راه‌های ارتباط مستقیم با من دسترسی داشته باشید.\n\n" .
            "👇 لطفاً یکی از گزینه‌های منوی زیر را انتخاب نمایید:";

        $glass = [
            'inline_keyboard' => [
                [
                    ['text' => '🌐 ورود به وب‌سایت رسمی (maaadmr.ir)', 'url' => $WEBSITE_URL],
                ],
                [
                    ['text' => '📢 کانال بله SEJ', 'url' => $CHANNEL_URL],
                    ['text' => '📢 کانال تلگرام SEJ', 'url' => $CHANNEL_TG_URL],
                ],
            ]
        ];
        $bale->sendMessage($text, $chatId, 'Markdown', $mainKeyboard);
        $bale->sendMessage("🔗 *لینک‌های مستقیم:*", $chatId, 'Markdown', $glass);
    }

    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۲: 📰 مقالات و تحلیل‌های سئو
// ==============================================================
if (str_contains($norm, 'مقالات') || str_contains($norm, 'وبلاگ') || in_array($norm, ['articles', 'blog'])) {
    $articles = [];
    try {
        if (class_exists('App\Models\Article')) {
            $allPub = Article::published();
            $articles = array_slice($allPub, 0, 3);
        }
    } catch (\Throwable $e) {
        error_log('[BaleWebhook] Article query error: ' . $e->getMessage());
    }

    if (empty($articles)) {
        $articles = [
            [
                'title' => 'پروتکل MCP چیست؟ راهنمای جامع اتصال مدل‌های هوش مصنوعی به سیستم‌های سازمانی',
                'slug'  => 'automation-1790627813',
                'summary' => 'بررسی فنی و عملیاتی پروتکل MCP، مقایسه معماری کلاینت-سرور با REST API و نحوه پیاده‌سازی اتوماسیون سازمانی.',
            ],
            [
                'title' => 'تکنیک‌های پیشرفته سئو محلی (Local SEO) و تسخیر رتبه‌های برتر گوگل مپ',
                'slug'  => 'advanced-local-seo-and-google-maps',
                'summary' => 'راهکارهای عملیاتی برای صدرنشینی در جستجوهای منطقه‌ای، ساخت سیگنال‌های محلی و همگام‌سازی NAP.',
            ],
            [
                'title' => 'راهنمای جامع بهینه‌سازی Core Web Vitals و پرفورمنس سایت با کدهای اختصاصی',
                'slug'  => 'core-web-vitals-speed-optimization',
                'summary' => 'بررسی تخصصی معیارهای سه‌گانه سرعت گوگل (LCP, INP, CLS) و متدولوژی اختصاصی در بهبود سرعت لود صفحات.',
            ],
        ];
    }

    $msg = "📚 *جدیدترین مقالات و تحلیل‌های تخصصی وب‌سایت:*\n\n";
    $inlineRows = [];

    foreach ($articles as $i => $art) {
        $num = $i + 1;
        $title = strip_tags((string)($art['title'] ?? ''));
        $slug = (string)($art['slug'] ?? '');
        $url = "{$WEBSITE_URL}/article/{$slug}";
        $summary = strip_tags((string)($art['summary'] ?? ($art['direct_answer'] ?? '')));
        if (mb_strlen($summary) > 150) {
            $summary = mb_substr($summary, 0, 150) . '...';
        }

        $msg .= "*{$num}. {$title}*\n";
        if (!empty($summary)) {
            $msg .= "_{$summary}_\n";
        }
        $msg .= "🔗 {$url}\n\n";

        $btnTitle = mb_strlen($art['title']) > 32 ? mb_substr($art['title'], 0, 32) . '...' : $art['title'];
        $inlineRows[] = [
            ['text' => "📖 {$btnTitle}", 'url' => $url]
        ];
    }

    $inlineRows[] = [
        ['text' => '📚 آرشیو تمام مقالات در وب‌سایت', 'url' => $ARTICLES_URL]
    ];

    $bale->sendMessage($msg, $chatId, 'Markdown', ['inline_keyboard' => $inlineRows]);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۳: 👨‍💻 درباره محمد مفتخری
// ==============================================================
if (str_contains($norm, 'درباره') || str_contains($norm, 'محمد مفتخری') || str_contains($norm, 'بیوگرافی') || in_array($norm, ['about', 'bio'])) {
    $text = "👨‍💻 *درباره {$OWNER_NAME}*\n" .
        "_{$OWNER_TITLE}_\n\n" .
        "من محمد مفتخری هستم؛ بیش از ۷ سال است که در حوزه سئو تکنیکال، معماری ساختار وب " .
        "و رشد ارگانیک کسب‌وکارهای آنلاین فعالیت می‌کنم.\n\n" .
        "🎯 *رویکرد و فلسفه کاری:*\n" .
        "تمرکز من بر سئو داده‌محور (Data-Driven SEO)، ارتقای شاخص‌های سرعت و تجربه کاربری (Core Web Vitals) " .
        "و پیاده‌سازی ابزارهای اتوماسیون سازمانی مبتنی بر هوش مصنوعی (مانند MCP Protocol و پایتون) است.\n\n" .
        "📊 *برخی دستاوردها:*\n" .
        "• مدیریت و هدایت استراتژی سئو در پروژه‌های پررقابت و پرترافیک\n" .
        "• بهبود رتبه‌بندی کلمات کلیدی کلیدی و بهینه‌سازی بودجه خزش (Crawl Budget)\n" .
        "• طراحی سیستم‌های خودکار پایش الگوریتم‌ها و انتشار محتوا\n\n" .
        "🔗 *لینک صفحه درباره من در وب‌سایت:*\n" .
        "{$ABOUT_URL}\n\n" .
        "جهت مشاهده رزومه، جزئیات بیشتر و پروژه‌ها، به لینک زیر سر بزنید یا از دکمه‌های زیر استفاده فرمایید:";

    $glass = [
        'inline_keyboard' => [
            [
                ['text' => '🌐 مشاهده صفحه درباره من در سایت', 'url' => $ABOUT_URL],
            ],
            [
                ['text' => '💼 مشاهده خدمات و تخصص‌ها', 'url' => "{$WEBSITE_URL}/services"],
                ['text' => '📞 گفتگوی مستقیم در بله', 'url' => "https://ble.ir/" . ltrim($SUPPORT_BALE_ID, '@')],
            ]
        ]
    ];
    $bale->sendMessage($text, $chatId, 'Markdown', $glass);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۴: 💼 تخصص‌ها و خدمات
// ==============================================================
if (str_contains($norm, 'خدمات') || str_contains($norm, 'تخصص') || in_array($norm, ['services', 'service'])) {
    $text = "💼 *تخصص‌ها و خدمات قابل ارائه*\n\n" .
        "🔹 *۱. سئو تکنیکال و معماری سایت (Technical SEO)*\n" .
        "بررسی جامع خطاهای ایندکس، ساختار URL، بهینه‌سازی بودجه خزش و استقرار اسکیماهای پیشرفته.\n\n" .
        "🔹 *۲. بهینه‌سازی سرعت و Core Web Vitals*\n" .
        "ارتقای استانداردهای سه‌گانه سرعت گوگل (LCP, INP, CLS) و بهینه‌سازی تخصصی منابع و بارگذاری.\n\n" .
        "🔹 *۳. استراتژی محتوا و بازاریابی داده‌محور*\n" .
        "کی‌ورد ریسرچ پیشرفته، خوشه‌بندی کلمات (Topic Clustering) و تدوین تقویم محتوایی منطبق بر الگوریتم‌های گوگل.\n\n" .
        "🔹 *۴. اتوماسیون مارکتینگ و ادغام با هوش مصنوعی*\n" .
        "پیاده‌سازی ربات‌های اتوماسیون، اتصال سیستم‌ها به مدل‌های هوش مصنوعی از طریق پروتکل MCP و اسکرپینگ داده‌ها.\n\n" .
        "🔹 *۵. سئو محلی و بین‌المللی (Local & Global SEO)*\n" .
        "تسخیر نتایج Google Maps، مدیریت سیگنال‌های محلی و استراتژی سئوی چندزبانه.";

    $glass = [
        'inline_keyboard' => [
            [
                ['text' => '🌐 مشاهده خدمات و راهکارها در سایت', 'url' => "{$WEBSITE_URL}/services"],
            ],
            [
                ['text' => '🤝 درخواست جلسه مشاوره سئو', 'url' => "https://ble.ir/" . ltrim($SUPPORT_BALE_ID, '@')],
            ]
        ]
    ];
    $bale->sendMessage($text, $chatId, 'Markdown', $glass);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۵: 🌐 ورود به وب‌سایت شخصی
// ==============================================================
if (str_contains($norm, 'وبسایت') || str_contains($norm, 'سایت') || in_array($norm, ['website', 'site'])) {
    $text = "🌐 *وب‌سایت شخصی محمد مفتخری (maaadmr.ir)*\n\n" .
        "وب‌سایت شخصی من پایگاهی برای انتشار مقالات عمیق، تحلیل‌های فنی الگوریتم‌های گوگل، " .
        "بررسی پروژه‌های اتوماسیون و ارائه خدمات سئو به کسب‌وکارهاست.\n\n" .
        "✨ *بخش‌های مهم وب‌سایت:*\n" .
        "• مقالات و آموزش‌های تخصصی سئو تکنیکال\n" .
        "• راهنماهای اتوماسیون و ادغام هوش مصنوعی\n" .
        "• بررسی کیس‌استادی‌های واقعی\n" .
        "• فرم مستقیم ثبت درخواست مشاوره\n\n" .
        "👇 جهت ورود مستقیم روی دکمه شیشه‌ای زیر کلیک نمایید:";

    $glass = [
        'inline_keyboard' => [
            [
                ['text' => '🚀 ورود به وب‌سایت maaadmr.ir', 'url' => $WEBSITE_URL],
            ]
        ]
    ];
    $bale->sendMessage($text, $chatId, 'Markdown', $glass);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۶: 📞 مشاوره و ارتباط مستقیم
// ==============================================================
if (str_contains($norm, 'مشاوره') || str_contains($norm, 'تماس') || str_contains($norm, 'ارتباط') || in_array($norm, ['contact', 'call'])) {
    $supportClean = ltrim($SUPPORT_BALE_ID, '@');
    $text = "📞 *مشاوره و راه‌های ارتباط مستقیم با {$OWNER_NAME}*\n\n" .
        "اگر برای وب‌سایت، استارتاپ یا سازمان خود نیازمند بهبود رتبه سئو، بهینه‌سازی فنی یا اتوماسیون هوش مصنوعی هستید، " .
        "خوشحال می‌شوم با من در ارتباط باشید:\n\n" .
        "📱 *شماره تماس مستقیم:* {$CONTACT_PHONE}\n" .
        "💬 *پیام در پیام‌رسان بله:* {$SUPPORT_BALE_ID}\n" .
        "🌐 *وب‌سایت شخصی:* {$WEBSITE_URL}\n" .
        "📢 *کانال تخصصی سئو:* {$CHANNEL_ID}\n\n" .
        "👇 برای ارتباط سریع، از دکمه‌های زیر استفاده فرمایید:";

    $glass = [
        'inline_keyboard' => [
            [
                ['text' => '💬 ارسال پیام مستقیم در بله', 'url' => "https://ble.ir/{$supportClean}"],
                ['text' => "📞 تماس تلفنی ({$CONTACT_PHONE})", 'url' => "tel:{$CONTACT_PHONE}"],
            ],
            [
                ['text' => '🌐 ارسال پیام از طریق سایت', 'url' => "{$WEBSITE_URL}/contact"],
            ]
        ]
    ];
    $bale->sendMessage($text, $chatId, 'Markdown', $glass);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۷: 📢 کانال سئو @persiansej
// ==============================================================
if (str_contains($norm, 'کانال') || str_contains($norm, 'عضویت') || str_contains(strtolower($norm), '@persiansej') || str_contains($norm, 'sej')) {
    $cleanChannel = ltrim($CHANNEL_ID, '@');
    $text = "📢 *کانال تخصصی سرچ انجین ژورنال فارسی (Persian SEJ)*\n\n" .
        "در این کانال، تازه‌ترین اخبار الگوریتم‌های گوگل، تحلیل‌های عمیق سئو بین‌الملل، " .
        "تکنیک‌های بهینه‌سازی فنی و ابزارهای نوین هوش مصنوعی منتشر می‌شود.\n\n" .
        "📌 *راه‌های دسترسی و عضویت در کانال:*\n" .
        "• *کانال در بله:* {$CHANNEL_ID}\n" .
        "• *کانال در تلگرام:* https://t.me/PersianSEJ\n\n" .
        "👇 لطفاً برای عضویت روی پیام‌رسان مد نظر خود کلیک فرمایید:";

    $glass = [
        'inline_keyboard' => [
            [
                ['text' => '📢 عضویت در کانال تلگرام (t.me/PersianSEJ)', 'url' => $CHANNEL_TG_URL],
            ],
            [
                ['text' => '📢 عضویت در کانال بله (@persiansej)', 'url' => $CHANNEL_URL],
            ]
        ]
    ];
    $bale->sendMessage($text, $chatId, 'Markdown', $glass);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۸: /status یا وضعیت
// ==============================================================
if ($rawText === '/status' || $norm === 'وضعیت' || $norm === 'status') {
    $text = "📊 *وضعیت سیستم اتوماسیون و بازوی بله:*\n\n" .
        "• بازوی شخصی: @maaad_mrbot 🟢\n" .
        "• مقصد اعلان لیدها: {$ADMIN_CHAT_ID} (محمد مفتخری)\n" .
        "• دامنه فعال: maaadmr.ir\n" .
        "• وب‌هوک بله: متصل و آنلاین 🟢\n" .
        "🕒 ساعت سرور: " . date('Y-m-d H:i:s');

    $bale->sendMessage($text, $chatId, 'Markdown', $mainKeyboard);
    echo json_encode(['ok' => true]);
    exit;
}

// ==============================================================
// سناریوی ۹: پیام متنی آزاد کاربر (هدایت + فوروارد به مدیر)
// ==============================================================
if (!$isAdmin) {
    // ارسال هشدار به مدیر در بله
    $adminAlert = "🔔 *پیام جدید دریافتی از کاربر در بازوی بله:*\n\n" .
        "👤 *نام فرستنده:* " . ($senderName ?: 'بدون نام') . "\n" .
        (!empty($username) ? "🆔 *نام کاربری:* @{$username}\n" : "") .
        "📌 *شناسه چت:* {$chatId}\n\n" .
        "💬 *متن پیام:*\n" . strip_tags($rawText) . "\n\n" .
        "🕒 زمان دریافت: " . date('Y-m-d H:i:s');

    $bale->sendMessage($adminAlert, $ADMIN_CHAT_ID, 'Markdown');

    // پاسخ به کاربر
    $userReply = "پیام شما با موفقیت دریافت و برای *{$OWNER_NAME}* ارسال شد. 🙏\n" .
        "در اسرع وقت با شما ارتباط برقرار خواهیم کرد.\n\n" .
        "همچنین می‌توانید از منوی زیر برای دسترسی به بخش‌های مختلف استفاده نمایید:";

    $bale->sendMessage($userReply, $chatId, 'Markdown', $mainKeyboard);
} else {
    $bale->sendMessage("دستور شناسایی نشد. لطفاً از گزینه‌های منوی زیر استفاده نمایید:", $chatId, 'Markdown', $mainKeyboard);
}

echo json_encode(['ok' => true]);
