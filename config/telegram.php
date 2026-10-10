<?php
declare(strict_types=1);

use App\Core\Env;
use App\Models\SiteSetting;

/**
 * Telegram Notification System Configuration
 * Mohammad Moftakhari Website (maaadmr.ir)
 */

return [
    // توکن اختصاصی ربات تلگرام
    'bot_token' => SiteSetting::get('telegram_bot_token') ?: (Env::get('TELEGRAM_BOT_TOKEN') ?: '8779388909:AAFgn3Gve1Oo-9r-gbWPdZPUcj0S58wQJ3M'),

    // شناسه چت شخصی مدیر، سوپرگروه، یا آیدی کانال
    'chat_id'   => SiteSetting::get('telegram_chat_id') ?: (Env::get('TELEGRAM_CHAT_ID') ?: '-1004392803397'),

    // شناسه تاپیک‌های سوپرگروه (Forum Topics)
    'thread_leads'   => SiteSetting::get('telegram_thread_leads') ?: '7',
    'thread_blog'    => SiteSetting::get('telegram_thread_blog') ?: '',
    'thread_content' => SiteSetting::get('telegram_thread_content') ?: '',

    // وضعیت فعال بودن نوتیفیکیشن‌ها
    'enabled'   => (bool)(SiteSetting::get('telegram_enabled', (string)Env::get('TELEGRAM_ENABLED', '1')) !== '0'),

    // تایم‌اوت ارتباط با تلگرام به ثانیه
    'timeout'   => 5,
    'connect_timeout' => 3,
];
