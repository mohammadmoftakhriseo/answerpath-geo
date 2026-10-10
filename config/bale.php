<?php
declare(strict_types=1);

use App\Core\Env;
use App\Models\SiteSetting;

/**
 * Bale Messenger Notification System Configuration (Domestic Fail-safe)
 * بازوی پیام‌رسان بله - سامانه اعلان‌های لحظه‌ای لید و نقشه راه (بدون نیاز به فیلترشکن)
 * Mohammad Moftakhari Website (maaadmr.ir)
 */

return [
    // توکن اختصاصی بازوی بله
    'bot_token' => SiteSetting::get('bale_bot_token') ?: (Env::get('BALE_BOT_TOKEN') ?: '575625957:UC1J1ErjQCdclDALGapkRPTlzMi6lHc8L0Q'),

    // شناسه چت شخصی مدیر یا کانال در بله
    'chat_id'   => SiteSetting::get('bale_chat_id') ?: (Env::get('BALE_CHAT_ID') ?: ''),

    // وضعیت فعال بودن نوتیفیکیشن‌های بله
    'enabled'   => (bool)(SiteSetting::get('bale_enabled', (string)Env::get('BALE_ENABLED', '1')) === '1'),

    // آدرس وب‌سرویس API بله
    'api_base'  => 'https://tapi.bale.ai/bot',

    // تایم‌اوت ارتباط با سرورهای بله به ثانیه (سرعت اینترانت داخلی بسیار بالاست)
    'timeout'   => 5,
    'connect_timeout' => 3,
];
