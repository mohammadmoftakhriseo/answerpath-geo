<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl">
        <div>
            <h1 class="text-xl font-black text-white flex items-center gap-2">
                <i class="fas fa-sliders text-blue-400"></i>
                تنظیمات عمومی سئو و هویت سایت
            </h1>
            <p class="text-xs text-slate-400 mt-1">تنظیم اطلاعات برند، تلفن تماس، شبکه‌های اجتماعی، سال‌های تجربه و تنظیمات متا تگ‌های پیش‌فرض</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/" target="_blank" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-700">
                <i class="fas fa-arrow-up-right-from-square"></i>
                مشاهده سایت اصلی
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if (!empty($success)): ?>
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs font-bold flex items-center gap-2">
            <i class="fas fa-circle-check"></i>
            <?= e($success) ?>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-xs font-bold flex items-center gap-2">
            <i class="fas fa-triangle-exclamation"></i>
            <?= e($error) ?>
        </div>
    <?php endif; ?>

    <!-- Settings Form -->
    <form method="POST" action="/admin/settings" class="space-y-6">
        <?= csrf_field() ?>

        <!-- بخش ۱: هویت برند و اطلاعات سئو -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-sm font-black text-white flex items-center gap-2 border-b border-slate-800 pb-3">
                <i class="fas fa-globe text-blue-400"></i>
                هویت برند و سئوی پیش‌فرض
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">نام برند / صاحب سایت</label>
                    <input type="text" name="site_name" value="<?= e($settings['site_name'] ?? 'محمد مفتخری') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">تعداد سال‌های سابقه کاری</label>
                    <input type="text" name="admin_experience_years" value="<?= e($settings['admin_experience_years'] ?? '+۶') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">عنوان پیش‌فرض سایت (Meta Title)</label>
                    <input type="text" name="site_title" value="<?= e($settings['site_title'] ?? 'محمد مفتخری | کارشناس و استراتژیست سئو') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">توضیحات پیش‌فرض سایت (Meta Description)</label>
                    <textarea name="site_description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500"><?= e($settings['site_description'] ?? 'سایت شخصی محمد مفتخری (Mohammad Moftakhari)، کارشناس ارشد سئو با ۶ سال تجربه کاری در آژانس دیجیتال مارکتینگ اینتن.') ?></textarea>
                </div>
            </div>
        </div>

        <!-- بخش ۲: اطلاعات تماس و شبکه‌های اجتماعی -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-sm font-black text-white flex items-center gap-2 border-b border-slate-800 pb-3">
                <i class="fas fa-address-book text-emerald-400"></i>
                اطلاعات تماس و شبکه‌های اجتماعی
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">شماره تماس مستقیم</label>
                    <input type="text" name="admin_phone" value="<?= e($settings['admin_phone'] ?? '09302928001') ?>" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">آیدی / لینک تلگرام</label>
                    <input type="text" name="admin_telegram" value="<?= e($settings['admin_telegram'] ?? 'maaad_mr') ?>" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">آیدی / لینک بله (پیوی شخصی)</label>
                    <input type="text" name="admin_bale" value="<?= e($settings['admin_bale'] ?? 'maaad_mr') ?>" dir="ltr" placeholder="maaad_mr یا لینک ble.ir/maaad_mr" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">آیدی / لینک اینستاگرام</label>
                    <input type="text" name="admin_instagram" value="<?= e($settings['admin_instagram'] ?? 'maaad_mr') ?>" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">شماره واتساپ</label>
                    <input type="text" name="admin_whatsapp" value="<?= e($settings['admin_whatsapp'] ?? '09302928001') ?>" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500 font-mono">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">پروفایل لینکدین</label>
                    <input type="text" name="admin_linkedin" value="<?= e($settings['admin_linkedin'] ?? 'https://www.linkedin.com/in/mohammad-moftakhari-b90687217') ?>" dir="ltr" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500 font-mono">
                </div>
            </div>
        </div>

        <!-- بخش ۳: سیستم مانیتورینگ لیدها و ربات تلگرام -->
        <div id="telegram-section" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-800 pb-3">
                <h2 class="text-sm font-black text-white flex items-center gap-2">
                    <i class="fab fa-telegram text-sky-400 text-base"></i>
                    سیستم مانیتورینگ لحظه‌ای لیدها با تلگرام
                </h2>
                <div class="flex items-center gap-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="telegram_enabled" value="1" <?= ($settings['telegram_enabled'] ?? '1') === '1' ? 'checked' : '' ?> class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-sky-500"></div>
                        <span class="mr-2 text-xs font-bold text-slate-300">ارسال اعلان‌ها فعال است</span>
                    </label>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-sky-500/10 border border-sky-500/20 text-sky-300 text-xs leading-relaxed space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-white">
                    <i class="fas fa-circle-info text-sky-400"></i>
                    نحوه کارکرد و اتصال به تلگرام:
                </div>
                <div>۱. توکن ربات تلگرام خود را وارد کنید (همان رباتی که برای کانال استفاده کرده‌اید).</div>
                <div>۲. شناسه چت شخصی (Chat ID) خود یا آیدی کانال (مثلاً <code>@yourchannel</code>) را وارد نمایید.</div>
                <div>۳. <b>نکته مهم:</b> برای دریافت پیام در پی‌وی، حتماً یک‌بار در تلگرام وارد ربات شوید و دکمه <b>Start</b> را بزنید. سپس دکمه «تست ارسال پیام» را فشار دهید.</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">توکن ربات تلگرام (Telegram Bot Token)</label>
                    <input type="text" name="telegram_bot_token" id="telegram_bot_token_input" value="<?= e($settings['telegram_bot_token'] ?? '8779388909:AAFgn3Gve1Oo-9r-gbWPdZPUcj0S58wQJ3M') ?>" dir="ltr" placeholder="مثال: 8779388909:AAFgn..." class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">شناسه سوپرگروه (Supergroup Chat ID)</label>
                    <input type="text" name="telegram_chat_id" id="telegram_chat_id_input" value="<?= e($settings['telegram_chat_id'] ?? '-1004392803397') ?>" dir="ltr" placeholder="مثال: -1004392803397" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono">
                </div>
            </div>

            <!-- تنظیمات تاپیک‌های اختصاصی سوپرگروه -->
            <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/80 space-y-3">
                <div class="text-xs font-bold text-sky-400 flex items-center gap-1.5">
                    <i class="fas fa-layer-group"></i>
                    <span>تفکیک و هدایت پیام‌ها به تاپیک‌های مشخص سوپرگروه (Forum Topics):</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">📩 تاپیک لیدها</label>
                        <input type="text" name="telegram_thread_leads" value="<?= e($settings['telegram_thread_leads'] ?? '7') ?>" dir="ltr" placeholder="7" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono text-center">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">✍️ تاپیک مقالات وبلاگ</label>
                        <input type="text" name="telegram_thread_blog" value="<?= e($settings['telegram_thread_blog'] ?? '') ?>" dir="ltr" placeholder="شناسه تاپیک وبلاگ" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono text-center">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">💼 تاپیک لینکدین</label>
                        <input type="text" name="telegram_thread_content" value="<?= e($settings['telegram_thread_content'] ?? '') ?>" dir="ltr" placeholder="شناسه تاپیک لینکدین" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono text-center">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">📌 تاپیک Pinterest</label>
                        <input type="text" name="telegram_thread_pinterest" value="<?= e($settings['telegram_thread_pinterest'] ?? '') ?>" dir="ltr" placeholder="شناسه پینترست" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono text-center">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-300 mb-1">👾 تاپیک Reddit</label>
                        <input type="text" name="telegram_thread_reddit" value="<?= e($settings['telegram_thread_reddit'] ?? '') ?>" dir="ltr" placeholder="شناسه ردیت" class="w-full px-3 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-sky-500 font-mono text-center">
                    </div>
                </div>
            </div>
        </div>

        <!-- Bale Messenger Section (Domestic Fail-safe) -->
        <div id="bale-section" class="p-6 rounded-2xl bg-slate-900 border border-emerald-500/30 space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-white flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    سیستم مانیتورینگ بدون فیلترشکن با پیام‌رسان بله (Bale Bot)
                </h2>
                <div class="flex items-center gap-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="bale_enabled" value="1" <?= ($settings['bale_enabled'] ?? '1') === '1' ? 'checked' : '' ?> class="sr-only peer">
                        <div class="w-9 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                        <span class="mr-2 text-xs font-bold text-slate-300">ارسال اعلان‌های بله فعال است</span>
                    </label>
                </div>
            </div>

            <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-300 text-xs leading-relaxed space-y-1">
                <div class="font-bold flex items-center gap-1.5 text-white">
                    <i class="fas fa-shield-check text-emerald-400"></i>
                    کانال پایدار و ملی (همیشه در دسترس حتی در صورت قطعی اینترنت بین‌الملل):
                </div>
                <div>۱. توکن بازوی بله شما با نام <code>@maaad_mrbot</code> تنظیم شده است.</div>
                <div>۲. در اپلیکیشن بله وارد بازوی <a href="https://ble.ir/maaad_mrbot" target="_blank" class="underline font-bold text-white">ble.ir/maaad_mrbot</a> شوید و دکمه <b>شروع (Start)</b> را بزنید.</div>
                <div>۳. با زدن دکمه «ثبت وب‌هوک بله» در پایین، با ارسال هر پیام در بازو، شناسه چت شما به صورت <b>خودکار</b> ذخیره خواهد شد.</div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">توکن بازوی بله (Bale Bot Token)</label>
                    <input type="text" name="bale_bot_token" id="bale_bot_token_input" value="<?= e($settings['bale_bot_token'] ?? '575625957:UC1J1ErjQCdclDALGapkRPTlzMi6lHc8L0Q') ?>" dir="ltr" placeholder="575625957:UC1J1Erj..." class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500 font-mono">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">شناسه چت مقصد در بله (Chat ID)</label>
                    <input type="text" name="bale_chat_id" id="bale_chat_id_input" value="<?= e($settings['bale_chat_id'] ?? '') ?>" dir="ltr" placeholder="مثال: 123456789 (با ارسال پیام به بازو خودکار ثبت می‌شود)" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-emerald-500 font-mono">
                </div>
            </div>
        </div>

        <!-- بخش ۵: ادغام Cloudflare API (شتاب‌دهنده سرعت، پاکسازی کش و Core Web Vitals) -->
        <div id="cloudflare-section" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h2 class="text-sm font-black text-white flex items-center gap-2">
                    <i class="fas fa-bolt text-amber-400"></i>
                    اتصال Cloudflare API (شتاب‌دهنده جهانی، کشینگ لبه شبکه و امنیت)
                </h2>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="cloudflare_enabled" value="1" <?= (!empty($settings['cloudflare_enabled']) && $settings['cloudflare_enabled'] === '1') || !isset($settings['cloudflare_enabled']) ? 'checked' : '' ?> class="w-4 h-4 rounded text-amber-500 bg-slate-800 border-slate-700">
                    <span class="text-xs font-bold text-slate-300">فعال‌سازی ماژول کلودفلر</span>
                </label>
            </div>

            <p class="text-xs text-slate-400 leading-relaxed">
                با اتصال API کلودفلر، هنگام انتشار یا به‌روزرسانی مقالات سئو توسط ربات تلگرام یا پنل، کش صفحه جدید و صفحه اصلی وب‌سایت در صدها دیتاسنتر لبه شبکه (Edge) به صورت خودکار و زیر ۱ ثانیه پاکسازی (Purge) می‌شود تا کاربران همیشه جدیدترین نسخه را با سرعت بی‌نظیر (TTFB کمتر از ۵۰ms) ببینند.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">
                        Cloudflare API Token
                        <span class="text-rose-400">*</span>
                    </label>
                    <input type="password" name="cloudflare_api_token" id="cloudflare_api_token_input" value="<?= e($settings['cloudflare_api_token'] ?? '') ?>" dir="ltr" placeholder="Bearer Token (دسترسی Cache Purge و Zone)" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-amber-500 font-mono">
                    <span class="text-[10px] text-slate-500 mt-1 block">ساخته شده از بخش My Profile > API Tokens در Cloudflare</span>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">
                        Zone ID دامنه
                        <span class="text-rose-400">*</span>
                    </label>
                    <input type="text" name="cloudflare_zone_id" id="cloudflare_zone_id_input" value="<?= e($settings['cloudflare_zone_id'] ?? '') ?>" dir="ltr" placeholder="مثال: 023e105f4ecef8ad9ca31a8372d0c353" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-amber-500 font-mono">
                    <span class="text-[10px] text-slate-500 mt-1 block">موجود در صفحه Overview دامنه maaadmr.ir در سایدبار سمت راست</span>
                </div>
            </div>

            <!-- دکمه‌های عملیات سریع کلودفلر -->
            <div class="pt-2 flex flex-wrap items-center gap-2">
                <button type="button" onclick="document.getElementById('test-cloudflare-form').submit();" class="px-3.5 py-2 rounded-xl bg-amber-500/10 hover:bg-amber-500/20 border border-amber-500/30 text-amber-300 text-xs font-bold transition flex items-center gap-2">
                    <i class="fas fa-plug text-xs"></i>
                    <span>تست اتصال و وضعیت</span>
                </button>
                <button type="button" onclick="if(confirm('آیا مایل به پاکسازی کامل تمام فایل‌ها و صفحات کش شده در کلودفلر هستید؟')) document.getElementById('purge-cloudflare-form').submit();" class="px-3.5 py-2 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs font-bold transition flex items-center gap-2">
                    <i class="fas fa-trash-can text-xs"></i>
                    <span>پاکسازی کامل کش (Purge All)</span>
                </button>
                <button type="button" onclick="document.getElementById('optimize-cloudflare-form').submit();" class="px-3.5 py-2 rounded-xl bg-indigo-500/10 hover:bg-indigo-500/20 border border-indigo-500/30 text-indigo-300 text-xs font-bold transition flex items-center gap-2">
                    <i class="fas fa-rocket text-xs"></i>
                    <span>فعال‌سازی بهینه‌سازی‌های سرعت (Early Hints & Brotli)</span>
                </button>
            </div>
        </div>

        <!-- بخش ۶: بک‌آپ ابری و همگام‌سازی لحظه‌ای گیت‌هاب (GitHub Auto-Sync) -->
        <div id="github-section" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h2 class="text-sm font-black text-white flex items-center gap-2">
                    <i class="fab fa-github text-purple-400"></i>
                    همگام‌سازی ابری و بک‌آپ لحظه‌ای گیت‌هاب (GitHub REST API & Git Sync)
                </h2>
                <span class="px-2.5 py-1 rounded-lg bg-purple-500/10 border border-purple-500/20 text-purple-400 text-[10px] font-bold">Auto Push & Cloud Backup</span>
            </div>

            <div class="p-4 rounded-xl bg-purple-950/20 border border-purple-900/40 text-slate-300 text-xs leading-relaxed space-y-2">
                <p class="font-bold text-white flex items-center gap-2">
                    <i class="fas fa-shield-halved text-purple-400"></i>
                    ریپازیتوری هدف: <code class="text-purple-300 font-mono text-xs">mohammadmoftakhriseo/answerpath-geo</code>
                </p>
                <p class="text-[11px] text-slate-400">
                    با فعال بودن این بخش، کلیه رویدادهای زنده (لیدهای ثبت شده، درخواست‌های نقشه راه و پیام‌ها) از طریق GitHub REST API به صورت فایل‌های JSON درون ریپازیتوری ذخیره شده و کدهای سایت نیز از طریق اسکریپت بک‌آپ اتوماتیک در برنچ main پوش خواهند شد.
                </p>
            </div>

            <div class="pt-2 flex flex-wrap items-center gap-2">
                <button type="button" onclick="document.getElementById('test-github-form').submit();" class="px-4 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white text-xs font-bold transition flex items-center gap-2 shadow-lg shadow-purple-900/30">
                    <i class="fab fa-github text-sm"></i>
                    <span>تست ارسال و پوش به ریپازیتوری گیت‌هاب</span>
                </button>
            </div>
        </div>


        <!-- Submit & Test Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-4">
            <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
                <button type="button" onclick="document.getElementById('test-telegram-form').submit();" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 border border-slate-700 text-sky-400 text-xs font-bold transition flex items-center justify-center gap-2">
                    <i class="fab fa-telegram-plane text-base"></i>
                    <span>تست تلگرام</span>
                </button>
                <button type="button" onclick="document.getElementById('webhook-telegram-form').submit();" class="px-4 py-2.5 rounded-xl bg-sky-950/80 hover:bg-sky-900/90 border border-sky-600/40 text-sky-300 text-xs font-bold transition flex items-center justify-center gap-2">
                    <i class="fas fa-link text-xs"></i>
                    <span>وب‌هوک تلگرام</span>
                </button>

                <button type="button" onclick="document.getElementById('test-bale-form').submit();" class="px-4 py-2.5 rounded-xl bg-emerald-950/80 hover:bg-emerald-900/90 border border-emerald-600/40 text-emerald-400 text-xs font-bold transition flex items-center justify-center gap-2">
                    <i class="fas fa-paper-plane text-xs"></i>
                    <span>تست پیام بله</span>
                </button>
                <button type="button" onclick="document.getElementById('webhook-bale-form').submit();" class="px-4 py-2.5 rounded-xl bg-teal-950/80 hover:bg-teal-900/90 border border-teal-600/40 text-teal-300 text-xs font-bold transition flex items-center justify-center gap-2">
                    <i class="fas fa-plug text-xs"></i>
                    <span>ثبت وب‌هوک بله</span>
                </button>
            </div>

            <button type="submit" class="w-full sm:w-auto px-8 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow-lg flex items-center justify-center gap-2">
                <i class="fas fa-save"></i>
                <span>ذخیره کلیه تنظیمات</span>
            </button>
        </div>
    </form>

    <!-- Hidden Form for Telegram Testing -->
    <form id="test-telegram-form" method="POST" action="/admin/settings/test-telegram" class="hidden">
        <?= csrf_field() ?>
        <input type="hidden" name="telegram_bot_token" id="test_bot_token">
        <input type="hidden" name="telegram_chat_id" id="test_chat_id">
    </form>

    <!-- Hidden Form for Telegram Webhook Setting -->
    <form id="webhook-telegram-form" method="POST" action="/admin/settings/set-telegram-webhook" class="hidden">
        <?= csrf_field() ?>
        <input type="hidden" name="telegram_bot_token" id="webhook_bot_token">
    </form>

    <!-- Hidden Form for Bale Testing -->
    <form id="test-bale-form" method="POST" action="/admin/settings/test-bale" class="hidden">
        <?= csrf_field() ?>
        <input type="hidden" name="bale_bot_token" id="test_bale_bot_token">
        <input type="hidden" name="bale_chat_id" id="test_bale_chat_id">
    </form>

    <!-- Hidden Form for Bale Webhook Setting -->
    <form id="webhook-bale-form" method="POST" action="/admin/settings/set-bale-webhook" class="hidden">
        <?= csrf_field() ?>
        <input type="hidden" name="bale_bot_token" id="webhook_bale_bot_token">
    </form>

    <!-- Hidden Form for Cloudflare Testing -->
    <form id="test-cloudflare-form" method="POST" action="/admin/settings/test-cloudflare" class="hidden">
        <?= csrf_field() ?>
        <input type="hidden" name="cloudflare_api_token" id="test_cloudflare_token">
        <input type="hidden" name="cloudflare_zone_id" id="test_cloudflare_zone">
    </form>

    <!-- Hidden Form for Cloudflare Purge All -->
    <form id="purge-cloudflare-form" method="POST" action="/admin/settings/purge-cloudflare" class="hidden">
        <?= csrf_field() ?>
        <input type="hidden" name="purge_type" value="all">
    </form>

    <!-- Hidden Form for GitHub Sync Testing -->
    <form id="test-github-form" method="POST" action="/admin/settings/test-github" class="hidden">
        <?= csrf_field() ?>
    </form>
</div>


<script>
document.getElementById('test-telegram-form').addEventListener('submit', function() {
    document.getElementById('test_bot_token').value = document.getElementById('telegram_bot_token_input').value;
    document.getElementById('test_chat_id').value = document.getElementById('telegram_chat_id_input').value;
});

document.getElementById('webhook-telegram-form').addEventListener('submit', function() {
    document.getElementById('webhook_bot_token').value = document.getElementById('telegram_bot_token_input').value;
});

document.getElementById('test-bale-form').addEventListener('submit', function() {
    document.getElementById('test_bale_bot_token').value = document.getElementById('bale_bot_token_input').value;
    document.getElementById('test_bale_chat_id').value = document.getElementById('bale_chat_id_input').value;
});

document.getElementById('webhook-bale-form').addEventListener('submit', function() {
    document.getElementById('webhook_bale_bot_token').value = document.getElementById('bale_bot_token_input').value;
});

document.getElementById('test-cloudflare-form').addEventListener('submit', function() {
    document.getElementById('test_cloudflare_token').value = document.getElementById('cloudflare_api_token_input').value;
    document.getElementById('test_cloudflare_zone').value = document.getElementById('cloudflare_zone_id_input').value;
});
</script>

