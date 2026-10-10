<?php
/**
 * View: front/contact.php
 * صفحه اختصاصی تماس هوشمند و مشاوره سئو (محمد مفتخری)
 * منطبق ۱۰۰٪ با هویت بصری و تم رنگی اصلی برند (سرمه‌ای سلطنتی، مشکی عمیق و طوسی روشن)
 */
?>

<!-- مسیر راهنما (Breadcrumb) -->
<div class="max-w-3xl mx-auto px-4 sm:px-6 pt-6">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خانه</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <span class="text-accent dark:text-blue-400 font-bold">تماس و مشاوره</span>
    </nav>
</div>

<!-- ========================================================================= -->
<!-- بخش ۱: Hero Section (مگنت اصلی و قلاب شروع مکالمه)                     -->
<!-- ========================================================================= -->
<section class="text-center pt-6 pb-2 max-w-3xl mx-auto px-4 sm:px-6">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 text-textMain dark:text-slate-200 text-xs sm:text-sm font-bold shadow-sm border border-gray-200 dark:border-slate-700 mb-6">
        <span class="w-2.5 h-2.5 rounded-full bg-accent animate-pulse"></span>
        <span>پایپ‌لاین ارتباط هوشمند و تحلیل لیدها</span>
    </div>

    <!-- تیتر مگنت اصلی -->
    <h1 class="text-3xl sm:text-5xl font-black text-textMain dark:text-white leading-tight mb-5">
        قبل از جلسه، اجازه بده سایتت را <br class="hidden sm:inline">
        <span class="text-accent dark:text-blue-400">
            با هوش مصنوعی آنالیز کنم
        </span>
    </h1>

    <p class="text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
        وقت شما و من ارزشمند است. فرم ۳ مرحله‌ای زیر را تکمیل کنید تا با دیتای آماده، بررسی دقیق سرعت و راهکار مشخص در جلسه حاضر شوم.
    </p>
</section>

<!-- ========================================================================= -->
<!-- بخش ۲: جایگاه دستیار هوشمند گوگل (AI Bot Integration Placeholder)     -->
<!-- ========================================================================= -->
<section class="max-w-3xl mx-auto px-4 sm:px-6">
    <div id="seliap-ai-assistant" class="w-full max-w-3xl mx-auto my-6 bg-white dark:bg-slate-800 rounded-2xl shadow-sm p-6 border border-gray-200 dark:border-slate-700 relative overflow-hidden group">
        <div class="flex items-center justify-between border-b border-gray-200 dark:border-slate-700 pb-4 mb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-lg">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h3 class="text-sm font-black text-textMain dark:text-white">دستیار هوشمند سئوی سلیاپ (AI Assistant)</h3>
                    <span class="text-[11px] text-accent dark:text-blue-300 flex items-center gap-1 font-bold">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent animate-ping"></span>
                        موتور پردازش Google Gemini متصل و آماده اسکن
                    </span>
                </div>
            </div>
            <span class="text-xs font-mono text-slate-500 font-bold">v2.4-active</span>
        </div>
        
        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed font-normal">
            «با وارد کردن آدرس دامنه در استپ دوم فرم زیر، وضعیت دیتابیس، کش لایت‌اسپید و ساختار اسکیماهای سایت شما بلافاصله اسکن شده و ضمیمه بریف جلسه خواهد شد.»
        </p>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۳: فرم تعاملی چندمرحله‌ای (Multi-step Form UI & JS)                -->
<!-- ========================================================================= -->
<section class="max-w-3xl mx-auto px-4 sm:px-6 mb-16">
    <div class="bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-3xl p-6 sm:p-10 shadow-sm relative">
        
        <!-- نوار پیشرفت مراحل (Progress Indicator) -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3 text-xs font-bold">
                <span id="step-label-1" class="text-accent dark:text-blue-400 transition-colors">۱. نوع چالش و نیاز</span>
                <span id="step-label-2" class="text-slate-400 dark:text-slate-500 transition-colors">۲. دیتای وب‌سایت و بودجه</span>
                <span id="step-label-3" class="text-slate-400 dark:text-slate-500 transition-colors">۳. اطلاعات تماس</span>
            </div>
            <div class="w-full bg-slate-100 dark:bg-slate-700 h-2 rounded-full overflow-hidden">
                <div id="form-progress-bar" class="bg-accent dark:bg-blue-600 h-full w-1/3 transition-all duration-500 ease-out"></div>
            </div>
        </div>

        <!-- فرم اصلی -->
        <form id="smart-contact-form" action="/lead/submit" method="POST" class="space-y-6">
            <?= csrf_field() ?>
            <input type="hidden" name="source" value="smart_contact_page" />

            <!-- ==================== استپ ۱: چالش ==================== -->
            <div id="form-step-1" class="form-step transition-all duration-300 space-y-5">
                <h3 class="text-lg font-black text-textMain dark:text-white flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-accent dark:text-blue-300 text-xs flex items-center justify-center font-mono font-bold">1</span>
                    بزرگ‌ترین چالش فعلی وب‌سایت شما چیست؟
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">یکی از حوزه‌های زیر را برای اولویت‌بندی آنالیز انتخاب نمایید:</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                    
                    <!-- گزینه ۱: سرعت سایت -->
                    <label class="cursor-pointer">
                        <input type="radio" name="project_need" value="speed_optimization" class="peer sr-only" checked />
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/70 border border-gray-200 dark:border-slate-700 peer-checked:border-accent peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-950/30 transition-all h-full flex flex-col justify-between">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-slate-800 text-accent dark:text-blue-400 flex items-center justify-center text-lg mb-3">
                                <i class="fas fa-bolt"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-textMain dark:text-white mb-1">سرعت و سئوی فنی</h4>
                                <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">رفع کندی سرور، TTFB، دیتابیس و خطاهای Core Web Vitals.</p>
                            </div>
                        </div>
                    </label>

                    <!-- گزینه ۲: سئوی محلی و استراتژی -->
                    <label class="cursor-pointer">
                        <input type="radio" name="project_need" value="local_ecommerce_seo" class="peer sr-only" />
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/70 border border-gray-200 dark:border-slate-700 peer-checked:border-accent peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-950/30 transition-all h-full flex flex-col justify-between">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-slate-800 text-accent dark:text-blue-400 flex items-center justify-center text-lg mb-3">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-textMain dark:text-white mb-1">سئوی محلی و مپ</h4>
                                <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">تسخیر کلمات منطقه، گوگل مپ و بالا بردن زنگ‌خور و لیدهای B2B.</p>
                            </div>
                        </div>
                    </label>

                    <!-- گزینه ۳: اتوماسیون هوش مصنوعی -->
                    <label class="cursor-pointer">
                        <input type="radio" name="project_need" value="ai_automation_geo" class="peer sr-only" />
                        <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/70 border border-gray-200 dark:border-slate-700 peer-checked:border-accent peer-checked:bg-blue-50/50 dark:peer-checked:bg-blue-950/30 transition-all h-full flex flex-col justify-between">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-slate-800 text-accent dark:text-blue-400 flex items-center justify-center text-lg mb-3">
                                <i class="fas fa-brain"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-textMain dark:text-white mb-1">اتوماسیون و CRO / GEO</h4>
                                <p class="text-[11px] text-slate-600 dark:text-slate-400 leading-relaxed">طراحی لندینگ نرخ تبدیل، سیستم‌سازی محتوا و موتورهای AI.</p>
                            </div>
                        </div>
                    </label>

                </div>

                <div class="pt-4 flex justify-end">
                    <button type="button" id="btn-next-1" class="px-7 py-3.5 rounded-xl bg-accent text-white font-bold text-sm shadow-md hover:bg-opacity-90 active:scale-95 transition-all flex items-center gap-2">
                        <span>مرحله بعد: ثبت آدرس سایت</span>
                        <svg class="w-4 h-4 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7l-7-7 7-7"/></svg>
                    </button>
                </div>
            </div>

            <!-- ==================== استپ ۲: دیتا ==================== -->
            <div id="form-step-2" class="form-step hidden opacity-0 transition-all duration-300 space-y-5">
                <h3 class="text-lg font-black text-textMain dark:text-white flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-accent dark:text-blue-300 text-xs flex items-center justify-center font-mono font-bold">2</span>
                    مشخصات وب‌سایت و مقیاس پروژه
                </h3>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">آدرس وب‌سایت (جهت اسکن لاگ‌ها و شاخص‌های سرعتی) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3.5 pointer-events-none text-slate-400">
                                <i class="fas fa-link text-accent dark:text-blue-400"></i>
                            </span>
                            <input type="url" id="field-website" name="website" required placeholder="https://yourdomain.com" class="w-full pl-4 pr-11 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent focus:ring-1 focus:ring-accent transition-all text-left dir-ltr font-mono" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">بودجه حدودی مدنظر شما برای این پروژه</label>
                        <select name="budget_range" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white text-sm focus:outline-none focus:border-accent transition-all">
                            <option value="under_15m">کمتر از ۱۵ میلیون تومان (ارزیابی و رفع خطاهای فوری)</option>
                            <option value="15m_30m" selected>۱۵ تا ۳۰ میلیون تومان (پکیج جامع سئوی تکنیکال و سرعت)</option>
                            <option value="30m_60m">۳۰ تا ۶۰ میلیون تومان (مدیریت ماهانه و استراتژی رشد ارگانیک)</option>
                            <option value="enterprise">بیش از ۶۰ میلیون تومان (پروژه‌های کلان سازمانی و B2B)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" id="btn-prev-2" class="px-5 py-3 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white text-sm font-bold transition">
                        بازگشت
                    </button>
                    <button type="button" id="btn-next-2" class="px-7 py-3.5 rounded-xl bg-accent text-white font-bold text-sm shadow-md hover:bg-opacity-90 active:scale-95 transition-all flex items-center gap-2">
                        <span>مرحله بعد: اطلاعات تماس</span>
                        <svg class="w-4 h-4 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7l-7-7 7-7"/></svg>
                    </button>
                </div>
            </div>

            <!-- ==================== استپ ۳: تماس ==================== -->
            <div id="form-step-3" class="form-step hidden opacity-0 transition-all duration-300 space-y-5">
                <h3 class="text-lg font-black text-textMain dark:text-white flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900 text-accent dark:text-blue-300 text-xs flex items-center justify-center font-mono font-bold">3</span>
                    دریافت تحلیل و هماهنگی جلسه
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">نام و نام خانوادگی <span class="text-red-500">*</span></label>
                        <input type="text" id="field-name" name="name" required placeholder="مثال: مهندس حسینی" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent transition-all" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">شماره تماس (موبایل یا آیدی تلگرام) <span class="text-red-500">*</span></label>
                        <input type="tel" id="field-phone" name="phone" required placeholder="۰۹۱۲... یا @telegram_id" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent transition-all text-left dir-ltr" />
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">توضیح تکمیلی یا سوال مشخص (اختیاری)</label>
                    <textarea name="message" rows="3" placeholder="اگر نکته خاصی وجود دارد که باید قبل از جلسه بدانم، بنویسید..." class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent transition-all resize-none"></textarea>
                </div>

                <div class="pt-4 flex items-center justify-between">
                    <button type="button" id="btn-prev-3" class="px-5 py-3 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white text-sm font-bold transition">
                        بازگشت
                    </button>
                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-accent text-white font-bold text-sm sm:text-base shadow-lg hover:bg-opacity-90 active:scale-95 transition-all flex items-center gap-2">
                        <span>ارسال و دریافت ارزیابی هوشمند</span>
                        <i class="fas fa-check-circle"></i>
                    </button>
                </div>
            </div>

        </form>

    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۴: ارتباط مستقیم و شبکه‌های اجتماعی                              -->
<!-- ========================================================================= -->
<section id="contact-channels" class="max-w-5xl mx-auto px-4 sm:px-6 mb-16" aria-label="ارتباط مستقیم و شبکه‌های اجتماعی">
    <div class="bg-slate-900 text-white rounded-3xl p-6 sm:p-10 border border-slate-800 shadow-xl">
        <div class="text-center max-w-2xl mx-auto mb-8 space-y-3">
            <h2 class="text-2xl sm:text-3xl font-black text-white">ارتباط مستقیم</h2>
            <p class="text-slate-300 font-medium text-xs sm:text-sm leading-relaxed">
                برای بررسی وضعیت سئوی سایت شما، مشاوره تخصصی و شروع همکاری، می‌توانید از طریق راه‌های زیر مستقیماً با من در ارتباط باشید.
            </p>
        </div>

        <!-- Social & Direct Channels Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3.5">
            <!-- Instagram -->
            <a href="https://www.instagram.com/maaad_mr/" target="_blank" rel="noopener" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                    <i class="fab fa-instagram text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">اینستاگرام</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">@maaad_mr</p>
                </div>
            </a>

            <!-- Telegram -->
            <a href="https://t.me/maaad_mr" target="_blank" rel="noopener" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-[#229ED9] text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                    <i class="fab fa-telegram-plane text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">تلگرام</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">@maaad_mr</p>
                </div>
            </a>

            <!-- Bale PV -->
            <a href="https://ble.ir/maaad_mr" target="_blank" rel="noopener" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group"
               title="پیام‌رسان بله (پیوی مستقیم)">
                <div class="w-10 h-10 bg-[#00B894] text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0 p-2.5">
                    <svg class="w-full h-full text-white fill-current" viewBox="54 4 32 32">
                        <path d="M72.2139 4.1563C72.2051 4.15482 72.1962 4.15433 72.1878 4.15285C71.9482 4.12031 71.707 4.09171 71.464 4.06952C71.3821 4.06213 71.2993 4.0572 71.2169 4.05079C71.0409 4.03747 70.8649 4.02465 70.6869 4.01726C70.5631 4.01183 70.4383 4.01035 70.3141 4.00789C70.2091 4.00592 70.1055 4 70 4C69.9522 4 69.9043 4.00247 69.8565 4.00296C69.8235 4.00345 69.7909 4.00148 69.7579 4.00197C69.6864 4.00296 69.6159 4.0074 69.5449 4.00937C69.4423 4.01233 69.3393 4.01529 69.2367 4.01972C69.1253 4.02515 69.0148 4.03205 68.9039 4.03994C68.8018 4.04684 68.7002 4.05374 68.5987 4.06262C68.4882 4.07248 68.3787 4.08382 68.2688 4.09565C68.1687 4.1065 68.0681 4.11686 67.9685 4.12968C67.859 4.14348 67.7506 4.15975 67.6416 4.17553C67.5425 4.19032 67.4434 4.20413 67.3452 4.22089C67.2368 4.23914 67.1298 4.25935 67.0223 4.27957C66.9247 4.29781 66.827 4.31556 66.7304 4.33578C66.6229 4.35797 66.5169 4.38262 66.4104 4.40727C66.3147 4.42897 66.2191 4.45017 66.1244 4.47384C66.0174 4.50046 65.9119 4.52955 65.8059 4.55815C65.7127 4.5833 65.619 4.60795 65.5268 4.63458C65.4212 4.66515 65.3172 4.69818 65.2132 4.73122C65.1215 4.75982 65.0297 4.78792 64.9385 4.818C64.835 4.85251 64.7324 4.88998 64.6299 4.92647C64.5396 4.95852 64.4494 4.98958 64.3601 5.02311C64.2576 5.06206 64.156 5.10348 64.0539 5.14441C63.9671 5.17941 63.8794 5.21294 63.7931 5.24943C63.69 5.29282 63.589 5.33917 63.4874 5.38453C63.4036 5.422 63.3192 5.458 63.2359 5.49695C63.1343 5.54428 63.0342 5.59507 62.9337 5.64438C62.8528 5.68431 62.7709 5.72277 62.6906 5.76419C62.5895 5.81646 62.4899 5.87119 62.3903 5.92542C62.3124 5.96783 62.2335 6.00826 62.1566 6.05165C62.054 6.10934 61.9539 6.16998 61.8528 6.23014C61.7803 6.27304 61.7074 6.31445 61.6359 6.35834C61.5269 6.42539 61.4204 6.49541 61.3129 6.56493C61.2513 6.60487 60.6329 7.02743 60.6329 7.02743C60.6329 7.02743 57.7178 4.80616 56.5547 4.20018C55.3915 3.59421 54 4.43834 54 5.74989V8.70336V19.6933C54 19.7983 54 19.9014 54 20C54 28.4822 60.6014 35.4182 68.9463 35.9615C68.9946 35.965 69.0424 35.9694 69.0908 35.9724C69.251 35.9813 69.4127 35.9847 69.574 35.9892C69.6741 35.9921 69.7727 35.9985 69.8733 35.9995C69.8945 35.9995 69.9157 35.9985 69.9369 35.9985C69.9581 35.9985 69.9793 36 70.001 36C70.1213 36 70.2396 35.9936 70.3595 35.9911C70.4941 35.9882 70.6292 35.9872 70.7633 35.9808C70.9033 35.9744 71.0424 35.9625 71.1814 35.9522C71.3141 35.9423 71.4467 35.9349 71.5784 35.9221C71.7164 35.9088 71.853 35.8896 71.9901 35.8728C72.1207 35.8565 72.2524 35.8422 72.3826 35.823C72.5182 35.8028 72.6518 35.7771 72.7864 35.754C72.9156 35.7313 73.0448 35.7106 73.173 35.6849C73.3071 35.6578 73.4392 35.6258 73.5719 35.5957C73.6981 35.5671 73.8248 35.54 73.9496 35.5084C74.0812 35.4749 74.2109 35.4364 74.3411 35.3999C74.4649 35.3649 74.5891 35.3324 74.7114 35.2949C74.8406 35.255 74.9673 35.2106 75.095 35.1677C75.2158 35.1273 75.3381 35.0883 75.4574 35.0449C75.5837 34.9991 75.7074 34.9488 75.8322 34.9C75.9505 34.8536 76.0698 34.8092 76.1872 34.7599C76.3105 34.7082 76.4313 34.652 76.5526 34.5972C76.6679 34.5455 76.7843 34.4957 76.8982 34.4409C77.018 34.3837 77.1354 34.3216 77.2532 34.2614C77.3661 34.2038 77.48 34.1485 77.591 34.0884C77.7069 34.0258 77.8198 33.9587 77.9337 33.8936C78.0436 33.8305 78.1551 33.7694 78.2636 33.7038C78.3765 33.6357 78.4864 33.5633 78.5974 33.4923C78.7034 33.4247 78.8109 33.3586 78.9154 33.2886C79.0249 33.2152 79.1309 33.1373 79.2384 33.0608C79.3409 32.9884 79.4445 32.9173 79.5451 32.8429C79.6506 32.764 79.7531 32.6812 79.8567 32.6003C79.9553 32.5229 80.0549 32.448 80.1516 32.3686C80.2541 32.2843 80.3532 32.196 80.4533 32.1092C80.547 32.0284 80.6427 31.949 80.7344 31.8656C80.833 31.7764 80.9282 31.6827 81.0248 31.591C81.1141 31.5062 81.2053 31.4229 81.2925 31.3356C81.3867 31.2414 81.4775 31.1438 81.5692 31.0471C81.6545 30.9579 81.7413 30.8706 81.8246 30.7794C81.9143 30.6808 82.0001 30.5787 82.0874 30.4777C82.1683 30.3845 82.2511 30.2933 82.3295 30.1981C82.4143 30.096 82.4947 29.99 82.5765 29.8855C82.6535 29.7879 82.7323 29.6922 82.8068 29.5926C82.8862 29.4866 82.9611 29.3771 83.0381 29.2692C83.1105 29.1676 83.185 29.0675 83.2545 28.9644C83.3295 28.854 83.3995 28.7401 83.472 28.6277C83.539 28.5231 83.6081 28.4206 83.6727 28.3146C83.7422 28.2007 83.8068 28.0833 83.8738 27.967C83.936 27.859 84.0006 27.7525 84.0602 27.643C84.1248 27.5237 84.185 27.4019 84.2466 27.2806C84.3028 27.1712 84.361 27.0632 84.4147 26.9522C84.4749 26.828 84.5291 26.7008 84.5863 26.575C84.6366 26.4641 84.6894 26.3541 84.7367 26.2417C84.791 26.1135 84.8398 25.9824 84.8911 25.8527C84.9354 25.7398 84.9828 25.6284 85.0247 25.514C85.0735 25.3813 85.1164 25.2457 85.1618 25.1111C85.2002 24.9967 85.2416 24.8843 85.2776 24.7689C85.3205 24.6314 85.3575 24.4913 85.3965 24.3523C85.429 24.2374 85.4645 24.124 85.4941 24.0081C85.5311 23.8656 85.5612 23.7212 85.5942 23.5772C85.6203 23.4618 85.6499 23.3484 85.6736 23.232C85.7042 23.0841 85.7278 22.9342 85.754 22.7848C85.7742 22.6704 85.7973 22.5575 85.8151 22.4427C85.8393 22.2854 85.8565 22.1261 85.8757 21.9678C85.8891 21.8584 85.9063 21.7504 85.9172 21.6399C85.9354 21.4619 85.9463 21.2815 85.9581 21.1015C85.9645 21.0093 85.9744 20.9181 85.9793 20.8254C85.9926 20.5665 85.9985 20.3057 85.999 20.0434C85.999 20.0291 86 20.0148 86 20C86.001 11.9152 80.0026 5.23464 72.2139 4.1563ZM79.3404 17.9528L70.0503 27.2431C69.4404 27.8526 68.6416 28.1573 67.8423 28.1573C67.043 28.1573 66.2442 27.8526 65.6343 27.2431L60.6605 22.2691C59.4412 21.0497 59.4412 19.073 60.6605 17.8537C61.8799 16.6348 63.8567 16.6348 65.0761 17.8537L67.8428 20.6203L74.9254 13.5374C76.1448 12.3185 78.1215 12.3185 79.3409 13.5374C80.5598 14.7572 80.5598 16.7334 79.3404 17.9528Z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">پیام‌رسان بله</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">@maaad_mr</p>
                </div>
            </a>

            <!-- Bale Bot -->
            <a href="https://ble.ir/maaad_mrbot" target="_blank" rel="noopener" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group"
               title="بازوی هوشمند بله (بات شخصی)">
                <div class="w-10 h-10 bg-gradient-to-tr from-[#00B894] to-emerald-700 text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0 p-2.5 relative">
                    <svg class="w-full h-full text-white fill-current" viewBox="54 4 32 32">
                        <path d="M72.2139 4.1563C72.2051 4.15482 72.1962 4.15433 72.1878 4.15285C71.9482 4.12031 71.707 4.09171 71.464 4.06952C71.3821 4.06213 71.2993 4.0572 71.2169 4.05079C71.0409 4.03747 70.8649 4.02465 70.6869 4.01726C70.5631 4.01183 70.4383 4.01035 70.3141 4.00789C70.2091 4.00592 70.1055 4 70 4C69.9522 4 69.9043 4.00247 69.8565 4.00296C69.8235 4.00345 69.7909 4.00148 69.7579 4.00197C69.6864 4.00296 69.6159 4.0074 69.5449 4.00937C69.4423 4.01233 69.3393 4.01529 69.2367 4.01972C69.1253 4.02515 69.0148 4.03205 68.9039 4.03994C68.8018 4.04684 68.7002 4.05374 68.5987 4.06262C68.4882 4.07248 68.3787 4.08382 68.2688 4.09565C68.1687 4.1065 68.0681 4.11686 67.9685 4.12968C67.859 4.14348 67.7506 4.15975 67.6416 4.17553C67.5425 4.19032 67.4434 4.20413 67.3452 4.22089C67.2368 4.23914 67.1298 4.25935 67.0223 4.27957C66.9247 4.29781 66.827 4.31556 66.7304 4.33578C66.6229 4.35797 66.5169 4.38262 66.4104 4.40727C66.3147 4.42897 66.2191 4.45017 66.1244 4.47384C66.0174 4.50046 65.9119 4.52955 65.8059 4.55815C65.7127 4.5833 65.619 4.60795 65.5268 4.63458C65.4212 4.66515 65.3172 4.69818 65.2132 4.73122C65.1215 4.75982 65.0297 4.78792 64.9385 4.818C64.835 4.85251 64.7324 4.88998 64.6299 4.92647C64.5396 4.95852 64.4494 4.98958 64.3601 5.02311C64.2576 5.06206 64.156 5.10348 64.0539 5.14441C63.9671 5.17941 63.8794 5.21294 63.7931 5.24943C63.69 5.29282 63.589 5.33917 63.4874 5.38453C63.4036 5.422 63.3192 5.458 63.2359 5.49695C63.1343 5.54428 63.0342 5.59507 62.9337 5.64438C62.8528 5.68431 62.7709 5.72277 62.6906 5.76419C62.5895 5.81646 62.4899 5.87119 62.3903 5.92542C62.3124 5.96783 62.2335 6.00826 62.1566 6.05165C62.054 6.10934 61.9539 6.16998 61.8528 6.23014C61.7803 6.27304 61.7074 6.31445 61.6359 6.35834C61.5269 6.42539 61.4204 6.49541 61.3129 6.56493C61.2513 6.60487 60.6329 7.02743 60.6329 7.02743C60.6329 7.02743 57.7178 4.80616 56.5547 4.20018C55.3915 3.59421 54 4.43834 54 5.74989V8.70336V19.6933C54 19.7983 54 19.9014 54 20C54 28.4822 60.6014 35.4182 68.9463 35.9615C68.9946 35.965 69.0424 35.9694 69.0908 35.9724C69.251 35.9813 69.4127 35.9847 69.574 35.9892C69.6741 35.9921 69.7727 35.9985 69.8733 35.9995C69.8945 35.9995 69.9157 35.9985 69.9369 35.9985C69.9581 35.9985 69.9793 36 70.001 36C70.1213 36 70.2396 35.9936 70.3595 35.9911C70.4941 35.9882 70.6292 35.9872 70.7633 35.9808C70.9033 35.9744 71.0424 35.9625 71.1814 35.9522C71.3141 35.9423 71.4467 35.9349 71.5784 35.9221C71.7164 35.9088 71.853 35.8896 71.9901 35.8728C72.1207 35.8565 72.2524 35.8422 72.3826 35.823C72.5182 35.8028 72.6518 35.7771 72.7864 35.754C72.9156 35.7313 73.0448 35.7106 73.173 35.6849C73.3071 35.6578 73.4392 35.6258 73.5719 35.5957C73.6981 35.5671 73.8248 35.54 73.9496 35.5084C74.0812 35.4749 74.2109 35.4364 74.3411 35.3999C74.4649 35.3649 74.5891 35.3324 74.7114 35.2949C74.8406 35.255 74.9673 35.2106 75.095 35.1677C75.2158 35.1273 75.3381 35.0883 75.4574 35.0449C75.5837 34.9991 75.7074 34.9488 75.8322 34.9C75.9505 34.8536 76.0698 34.8092 76.1872 34.7599C76.3105 34.7082 76.4313 34.652 76.5526 34.5972C76.6679 34.5455 76.7843 34.4957 76.8982 34.4409C77.018 34.3837 77.1354 34.3216 77.2532 34.2614C77.3661 34.2038 77.48 34.1485 77.591 34.0884C77.7069 34.0258 77.8198 33.9587 77.9337 33.8936C78.0436 33.8305 78.1551 33.7694 78.2636 33.7038C78.3765 33.6357 78.4864 33.5633 78.5974 33.4923C78.7034 33.4247 78.8109 33.3586 78.9154 33.2886C79.0249 33.2152 79.1309 33.1373 79.2384 33.0608C79.3409 32.9884 79.4445 32.9173 79.5451 32.8429C79.6506 32.764 79.7531 32.6812 79.8567 32.6003C79.9553 32.5229 80.0549 32.448 80.1516 32.3686C80.2541 32.2843 80.3532 32.196 80.4533 32.1092C80.547 32.0284 80.6427 31.949 80.7344 31.8656C80.833 31.7764 80.9282 31.6827 81.0248 31.591C81.1141 31.5062 81.2053 31.4229 81.2925 31.3356C81.3867 31.2414 81.4775 31.1438 81.5692 31.0471C81.6545 30.9579 81.7413 30.8706 81.8246 30.7794C81.9143 30.6808 82.0001 30.5787 82.0874 30.4777C82.1683 30.3845 82.2511 30.2933 82.3295 30.1981C82.4143 30.096 82.4947 29.99 82.5765 29.8855C82.6535 29.7879 82.7323 29.6922 82.8068 29.5926C82.8862 29.4866 82.9611 29.3771 83.0381 29.2692C83.1105 29.1676 83.185 29.0675 83.2545 28.9644C83.3295 28.854 83.3995 28.7401 83.472 28.6277C83.539 28.5231 83.6081 28.4206 83.6727 28.3146C83.7422 28.2007 83.8068 28.0833 83.8738 27.967C83.936 27.859 84.0006 27.7525 84.0602 27.643C84.1248 27.5237 84.185 27.4019 84.2466 27.2806C84.3028 27.1712 84.361 27.0632 84.4147 26.9522C84.4749 26.828 84.5291 26.7008 84.5863 26.575C84.6366 26.4641 84.6894 26.3541 84.7367 26.2417C84.791 26.1135 84.8398 25.9824 84.8911 25.8527C84.9354 25.7398 84.9828 25.6284 85.0247 25.514C85.0735 25.3813 85.1164 25.2457 85.1618 25.1111C85.2002 24.9967 85.2416 24.8843 85.2776 24.7689C85.3205 24.6314 85.3575 24.4913 85.3965 24.3523C85.429 24.2374 85.4645 24.124 85.4941 24.0081C85.5311 23.8656 85.5612 23.7212 85.5942 23.5772C85.6203 23.4618 85.6499 23.3484 85.6736 23.232C85.7042 23.0841 85.7278 22.9342 85.754 22.7848C85.7742 22.6704 85.7973 22.5575 85.8151 22.4427C85.8393 22.2854 85.8565 22.1261 85.8757 21.9678C85.8891 21.8584 85.9063 21.7504 85.9172 21.6399C85.9354 21.4619 85.9463 21.2815 85.9581 21.1015C85.9645 21.0093 85.9744 20.9181 85.9793 20.8254C85.9926 20.5665 85.9985 20.3057 85.999 20.0434C85.999 20.0291 86 20.0148 86 20C86.001 11.9152 80.0026 5.23464 72.2139 4.1563ZM79.3404 17.9528L70.0503 27.2431C69.4404 27.8526 68.6416 28.1573 67.8423 28.1573C67.043 28.1573 66.2442 27.8526 65.6343 27.2431L60.6605 22.2691C59.4412 21.0497 59.4412 19.073 60.6605 17.8537C61.8799 16.6348 63.8567 16.6348 65.0761 17.8537L67.8428 20.6203L74.9254 13.5374C76.1448 12.3185 78.1215 12.3185 79.3409 13.5374C80.5598 14.7572 80.5598 16.7334 79.3404 17.9528Z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">بازوی بله (بات)</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">@maaad_mrbot</p>
                </div>
            </a>

            <!-- WhatsApp -->
            <a href="https://wa.me/989302928001" target="_blank" rel="noopener" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-[#25D366] text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                    <i class="fab fa-whatsapp text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">واتساپ</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">0930 292 8001</p>
                </div>
            </a>

            <!-- LinkedIn -->
            <a href="https://www.linkedin.com/in/mohammad-moftakhari-b90687217" target="_blank" rel="noopener" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-[#0A66C2] text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                    <i class="fab fa-linkedin-in text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">لینکدین</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">Mohammad Moftakhari</p>
                </div>
            </a>

            <!-- Phone -->
            <a href="tel:09302928001" 
               class="bg-white/5 border border-white/10 p-4 rounded-2xl flex items-center gap-3.5 hover:bg-white/10 hover:-translate-y-1 transition-all group">
                <div class="w-10 h-10 bg-accent text-white rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform flex-shrink-0">
                    <i class="fas fa-phone text-sm"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="font-black text-sm text-white">تماس مستقیم</h3>
                    <p class="text-gray-400 font-medium text-xs truncate" dir="ltr">0930 292 8001</p>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- اسکریپت فرم چندمرحله‌ای -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const step1 = document.getElementById('form-step-1');
    const step2 = document.getElementById('form-step-2');
    const step3 = document.getElementById('form-step-3');
    const progressBar = document.getElementById('form-progress-bar');

    const label1 = document.getElementById('step-label-1');
    const label2 = document.getElementById('step-label-2');
    const label3 = document.getElementById('step-label-3');

    function goToStep(step) {
        [step1, step2, step3].forEach(el => {
            el.classList.add('opacity-0');
            setTimeout(() => el.classList.add('hidden'), 200);
        });

        setTimeout(() => {
            let activeEl = step === 1 ? step1 : (step === 2 ? step2 : step3);
            activeEl.classList.remove('hidden');
            setTimeout(() => activeEl.classList.remove('opacity-0'), 20);

            progressBar.style.width = (step === 1 ? '33.33%' : (step === 2 ? '66.66%' : '100%'));

            label1.className = step >= 1 ? 'text-accent dark:text-blue-400 transition-colors' : 'text-slate-400 dark:text-slate-500 transition-colors';
            label2.className = step >= 2 ? 'text-accent dark:text-blue-400 transition-colors' : 'text-slate-400 dark:text-slate-500 transition-colors';
            label3.className = step >= 3 ? 'text-accent dark:text-blue-400 transition-colors' : 'text-slate-400 dark:text-slate-500 transition-colors';
        }, 210);
    }

    document.getElementById('btn-next-1').addEventListener('click', () => {
        goToStep(2);
    });

    document.getElementById('btn-prev-2').addEventListener('click', () => {
        goToStep(1);
    });

    document.getElementById('btn-next-2').addEventListener('click', () => {
        const websiteInput = document.getElementById('field-website');
        if (!websiteInput.checkValidity()) {
            websiteInput.reportValidity();
            return;
        }
        goToStep(3);
    });

    document.getElementById('btn-prev-3').addEventListener('click', () => {
        goToStep(2);
    });
});
</script>
