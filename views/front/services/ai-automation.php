<?php
/**
 * View: front/services/ai-automation.php
 * لندینگ پیلار دوم: اتوماسیون هوش مصنوعی و سیستم‌سازی محتوا
 * منطبق ۱۰۰٪ با هویت بصری و تم رنگی اصلی برند (سرمه‌ای سلطنتی، مشکی عمیق و طوسی روشن)
 */
?>

<!-- مسیر راهنما (Breadcrumb) -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 pt-6">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خانه</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <a href="/#services" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خدمات سئو</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <span class="text-accent dark:text-blue-400 font-bold">اتوماسیون هوش مصنوعی و سیستم‌سازی محتوا</span>
    </nav>
</div>

<!-- ========================================================================= -->
<!-- بخش ۱: Hero Section (قلاب اصلی مدیران با تم برند)                         -->
<!-- ========================================================================= -->
<section class="relative pt-8 pb-16 overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center relative z-10">
        
        <!-- بج هویت و تکنولوژی -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 text-textMain dark:text-slate-200 text-xs sm:text-sm font-bold shadow-sm border border-gray-200 dark:border-slate-700 mb-6">
            <span class="w-2.5 h-2.5 rounded-full bg-accent animate-pulse"></span>
            <span>معماری اتوماسیون سئو با Gemini API | توسعه‌دهنده: <a href="/about" class="underline hover:text-accent">محمد مفتخری</a></span>
        </div>

        <!-- تیتر اصلی H1 -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[2.6rem] font-black text-textMain dark:text-white leading-[1.35] sm:leading-[1.3] mb-6 max-w-4xl mx-auto">
            تبدیل سایت شما به یک <br class="hidden sm:inline">
            <span class="text-accent dark:text-blue-400">
                ماشین تولید محتوای خودکار
            </span>
            با هوش مصنوعی
        </h1>

        <!-- ساب‌تیتر توضیحی B2B -->
        <p class="text-base sm:text-lg text-slate-700 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed mb-8 font-normal text-justify sm:text-center">
            سیستم‌سازی هوشمند سئو؛ از دریافت بریف در تلگرام تا تولید مقالات سئوشده، ساخت تصاویر اختصاصی (بدون متن) با Imagen 3 و انتشار خودکار در وردپرس، <strong class="text-accent dark:text-blue-400 font-bold">بدون نیاز به استخدام تیم محتوا</strong>.
        </p>

        <!-- بج‌های پشته فنی -->
        <div class="flex flex-wrap items-center justify-center gap-3 mb-8 text-xs font-mono text-slate-700 dark:text-slate-300">
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-brain text-accent dark:text-blue-400"></i> Google Gemini 1.5 Pro / Flash
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-image text-accent dark:text-blue-400"></i> Google Imagen 3 (No-Text Engine)
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fab fa-telegram text-accent dark:text-blue-400"></i> Telegram Bot Engine
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fab fa-wordpress text-accent dark:text-blue-400"></i> WordPress REST API Sync
            </span>
        </div>

        <!-- دکمه‌های فراخوان (CTA Buttons) -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-lg mx-auto">
            <a href="/start" class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-3.5 rounded-xl bg-accent text-white font-bold text-base shadow-md hover:bg-opacity-90 active:scale-95 transition-all">
                <span>آنالیز پتانسیل اتوماسیون سایت من</span>
                <svg class="w-4 h-4 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7l-7-7 7-7"/></svg>
            </a>
            <a href="#workflow" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl border-2 border-textMain dark:border-slate-600 text-textMain dark:text-slate-200 bg-transparent font-bold text-sm hover:bg-textMain hover:text-white transition-all">
                <span>نحوه عملکرد سیستم</span>
                <i class="fas fa-chevron-down text-xs"></i>
            </a>
        </div>

        <!-- یادداشت شفافیت زیر CTA -->
        <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">
            <i class="fas fa-shield-alt text-accent dark:text-blue-400 ml-1"></i> مهندسی پرامپت مطابق با استانداردهای E-E-A-T گوگل بدون خطر افت کیفیت
        </p>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۲: مقایسه و ROI (بازگشت سرمایه - Pain Points مدیران)                 -->
<!-- ========================================================================= -->
<section class="py-14 bg-slate-100/70 dark:bg-slate-900/50 border-y border-gray-200 dark:border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800/60 text-accent dark:text-blue-300 text-xs font-bold mb-3 font-mono">
                <i class="fas fa-balance-scale"></i> مقایسه اقتصادی و سئو (ROI)
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-textMain dark:text-white mb-3">
                تیم سنتی تولید محتوا یا اتوماسیون هوشمند سلیاپ؟
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
                چرا شرکت‌ها و وب‌سایت‌های پیشرو، بودجه‌های سنگین استخدام نویسنده را به سیستم‌سازی مقیاس‌پذیر و بی‌وقفه تغییر می‌دهند؟
            </p>
        </div>

        <!-- جدول مقایسه دو ستونه -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-stretch">
            <!-- ستون ۱: روش سنتی -->
            <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between relative overflow-hidden">
                <div>
                    <div class="flex items-center justify-between pb-5 border-b border-gray-200 dark:border-slate-700 mb-6">
                        <div>
                            <span class="text-xs font-bold text-red-600 dark:text-red-400 uppercase tracking-wider block mb-1">روش سنتی</span>
                            <h3 class="text-xl font-black text-textMain dark:text-white">تیم سنتی تولید محتوا</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-red-50 dark:bg-slate-700 text-red-600 dark:text-red-400 flex items-center justify-center text-xl">
                            <i class="fas fa-user-clock"></i>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-500 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">هزینه‌های ماهانه سرسام‌آور:</strong>
                                حقوق ثابت نویسندگان، ویراستاران، طراح گرافیک و کارشناس بارگذاری محتوا (بیش از ۲۰ تا ۵۰ میلیون تومان در ماه).
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-500 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">زمان‌بر بودن فرآیند و کندی انتشار:</strong>
                                تاخیر در تحویل متن‌ها، اصلاحیه‌های چندباره و خوابیدن کمپین‌های سئو به دلیل بدقولی‌های نیروی انسانی.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-times-circle text-red-500 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">خطای انسانی در سئو و لینک‌سازی:</strong>
                                فراموشی تگ‌های آلت تصاویر، عدم رعایت چگالی کلمات LSI، ساختارهای نامناسب هدینگ‌ها و بی‌توجهی به سرچ‌اینتنت.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 dark:border-slate-700 text-xs text-red-600 dark:text-red-400 font-bold flex items-center gap-1.5">
                    <i class="fas fa-exclamation-triangle"></i> خروجی نهایی: مقیاس‌ناپذیر، پرهزینه و وابسته به افراد
                </div>
            </div>

            <!-- ستون ۲: اتوماسیون سلیاپ -->
            <div class="p-8 rounded-2xl bg-white dark:bg-slate-800 border-2 border-accent dark:border-blue-500 shadow-md flex flex-col justify-between relative overflow-hidden">
                <div class="absolute -top-3 left-6 px-3 py-1 rounded-full bg-accent text-white text-xs font-bold shadow-sm">
                    راهکار اختصاصی سلیاپ
                </div>

                <div>
                    <div class="flex items-center justify-between pb-5 border-b border-gray-200 dark:border-slate-700 mb-6">
                        <div>
                            <span class="text-xs font-bold text-accent dark:text-blue-400 uppercase tracking-wider block mb-1">سیستم‌سازی نوین</span>
                            <h3 class="text-xl font-black text-textMain dark:text-white">اتوماسیون هوش مصنوعی و Gemini</h3>
                        </div>
                        <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xl">
                            <i class="fas fa-microchip"></i>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-700 dark:text-slate-300">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-accent dark:text-blue-400 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">کاهش ۹۰ درصدی هزینه‌ها (ROI آنی):</strong>
                                پرداخت تنها هزینه بسیار ناچیز توکن‌های گوگل جمنای؛ بدون نیاز به حقوق ثابت ماهانه و بیمه پرسنل.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-accent dark:text-blue-400 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">تولید و انتشار ۲۴ ساعته و مقیاس‌پذیر:</strong>
                                انتشار ده‌ها مقاله سئوشده و عمیق در هفته به طور منظم و برنامه‌ریزی‌شده در اوج ساعات ترافیک مخاطبان.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-accent dark:text-blue-400 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">سئوی مهندسی‌شده و بر مبنای E-E-A-T:</strong>
                                پرامپت‌های شخصی‌سازی‌شده با لحن برند شما، تزریق خودکار جداول مقایسه‌ای، لیست‌های ساختاریافته و کلمات کلیدی LSI.
                            </div>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fas fa-check-circle text-accent dark:text-blue-400 mt-1 shrink-0 text-base"></i>
                            <div>
                                <strong class="text-textMain dark:text-white block font-bold">تصویرسازی یونیک با Imagen 3 (ضد متن):</strong>
                                تولید اتوماتیک کاور و تصاویر داخل متن با موتور پرامپت نویسی No-Text برای کسب بالاترین امتیاز در Google Discover.
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="mt-8 pt-4 border-t border-gray-200 dark:border-slate-700 text-xs text-accent dark:text-blue-400 font-bold flex items-center justify-between">
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-rocket"></i> بازدهی تضمینی و استقلال کامل کسب‌وکار
                    </span>
                    <a href="/start" class="hover:underline font-bold">رزرو پیاده‌سازی</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۳: The Workflow (این سیستم چطور کار می‌کند؟)                          -->
<!-- ========================================================================= -->
<section id="workflow" class="py-16 relative overflow-hidden">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800/60 text-accent dark:text-blue-300 text-xs font-bold mb-3 font-mono">
                <i class="fas fa-project-diagram"></i> معماری جریان کار (Workflow)
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-textMain dark:text-white mb-3">
                از یک ایده خام تا مقاله منتشرشده در وردپرس
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
                تمام پیچیدگی‌های فنی پشت پرده اتفاق می‌افتد؛ شما فقط ایده می‌دهید، سیستم بقیه مراحل را روی خلبان خودکار انجام می‌دهد:
            </p>
        </div>

        <!-- نمودار مرحله‌ای (Workflow Grid) -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- مرحله ۱ -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xl">
                            <i class="fab fa-telegram-plane"></i>
                        </div>
                        <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300">گام ۰۱</span>
                    </div>
                    <h3 class="text-base font-black text-textMain dark:text-white mb-2">۱. ورودی خام (Input)</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        ارسال ایده، عنوان کلمه کلیدی، ویس توضیحی یا لینک منبع در ربات تلگرام اختصاصی بدون نیاز به ورود به پیشخوان وردپرس.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-slate-700 text-xs text-accent dark:text-blue-400 font-mono font-bold">
                    Telegram Webhook Trigger
                </div>
            </div>

            <!-- مرحله ۲ -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xl">
                            <i class="fas fa-brain"></i>
                        </div>
                        <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300">گام ۰۲</span>
                    </div>
                    <h3 class="text-base font-black text-textMain dark:text-white mb-2">۲. مغز پردازشگر (Gemini)</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        تحلیل کلمات کلیدی، استخراج نیت کاربر (Search Intent)، ایجاد سرفصل‌های جامع، نگارش بدنه مقاله و پاسخ به سوالات متداول.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-slate-700 text-xs text-accent dark:text-blue-400 font-mono font-bold">
                    Gemini 1.5 Prompt Engine
                </div>
            </div>

            <!-- مرحله ۳ -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xl">
                            <i class="fas fa-palette"></i>
                        </div>
                        <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300">گام ۰۳</span>
                    </div>
                    <h3 class="text-base font-black text-textMain dark:text-white mb-2">۳. تصویرسازی (Imagen 3)</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        تولید تصاویر بدون متن (No-Text) متناسب با هر بخش، فشرده‌سازی خودکار به فرمت مدرن WebP و تولید تگ‌های Alt سئوشده.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-slate-700 text-xs text-accent dark:text-blue-400 font-mono font-bold">
                    Imagen 3 & WebP Optimizer
                </div>
            </div>

            <!-- مرحله ۴ -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xl">
                            <i class="fas fa-paper-plane"></i>
                        </div>
                        <span class="text-xs font-mono font-bold px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300">گام ۰۴</span>
                    </div>
                    <h3 class="text-base font-black text-textMain dark:text-white mb-2">۴. انتشار خودکار (Autopilot)</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed">
                        تزریق مستقیم به وردپرس از طریق REST API با تگ‌های کنونیکال، اسکیمای Article و FAQPage، لینک‌سازی داخلی و زمان‌بندی.
                    </p>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-200 dark:border-slate-700 text-xs text-accent dark:text-blue-400 font-mono font-bold">
                    WP REST API & Schema Injector
                </div>
            </div>
        </div>

        <!-- باکس فنی زیر دیاگرام -->
        <div class="mt-8 p-6 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center shrink-0 text-xl">
                    <i class="fas fa-code-branch"></i>
                </div>
                <div>
                    <h4 class="font-bold text-base text-textMain dark:text-white">اتصال دوطرفه و سیستم هشدار هوشمند</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">پس از انتشار هر مقاله، گزارش کامل وضعیت سئو و لینک زنده مستقیماً به تلگرام شما ارسال می‌شود.</p>
                </div>
            </div>
            <a href="/start" class="shrink-0 px-6 py-3 rounded-xl bg-accent text-white font-bold text-xs sm:text-sm hover:bg-opacity-90 transition-all shadow-md">
                درخواست دمو و اتصال به سایت شما
            </a>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۴: The E-E-A-T Section (نمونه‌کارهای اتوماسیون)                         -->
<!-- ========================================================================= -->
<section class="py-14 bg-slate-100/70 dark:bg-slate-900/50 border-y border-gray-200 dark:border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800/60 text-accent dark:text-blue-300 text-xs font-bold mb-2 font-mono">
                    <i class="fas fa-check-double"></i> پروژه‌های عملی و E-E-A-T
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-textMain dark:text-white">
                    پروژه‌هایی که روی خلبان خودکار گذاشتم
                </h2>
                <p class="text-slate-600 dark:text-slate-400 text-sm mt-1 max-w-2xl">
                    سیستم‌های اتوماسیونی که با اتصال به دیتابیس، تلگرام و API گوگل باعث رشد ارگانیک و صرفه‌جویی صدها ساعت کار تیمی شدند:
                </p>
            </div>
            <a href="/projects" class="mt-4 md:mt-0 inline-flex items-center gap-1.5 text-sm font-bold text-accent dark:text-blue-400 hover:underline">
                <span>مشاهده تمام نمونه‌کارها</span>
                <i class="fas fa-arrow-left text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden hover:border-accent/40 transition-all duration-300 group flex flex-col justify-between shadow-sm">
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs text-accent dark:text-blue-400 font-bold mb-3">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-tag"></i> لواسانی موتورز (Lavasani Motors)
                        </span>
                        <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300 font-mono text-[11px] font-bold">
                            +۲۸۰٪ ایندکس در ۳ ماه
                        </span>
                    </div>

                    <h3 class="text-base sm:text-lg font-black text-textMain dark:text-white mb-2 group-hover:text-accent transition-colors">
                        سیستم خودکار تولید محتوای سئومحور لواسانی موتورز
                    </h3>

                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed mb-4">
                        سیستم‌سازی فرآیند بررسی خودروها و اخبار صنعت با اتصال ربات تلگرام به Gemini API، تولید خودکار ۵۰ مقاله تخصصی در هفته با عکس‌های اختصاصی بدون دخالت انسان.
                    </p>
                </div>

                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/60 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-mono">Gemini API + Telegram</span>
                    <a href="/projects" class="text-accent dark:text-blue-400 font-bold hover:underline">جزییات پروژه</a>
                </div>
            </div>

            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden hover:border-accent/40 transition-all duration-300 group flex flex-col justify-between shadow-sm">
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs text-accent dark:text-blue-400 font-bold mb-3">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-tag"></i> پایگاه رسانه‌ای سلیاپ
                        </span>
                        <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300 font-mono text-[11px] font-bold">
                            ۱۰۰٪ خودکار
                        </span>
                    </div>

                    <h3 class="text-base sm:text-lg font-black text-textMain dark:text-white mb-2 group-hover:text-accent transition-colors">
                        ربات تلگرام هوشمند خبرخوان و دایجِست سئو (SEJ Bot)
                    </h3>

                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed mb-4">
                        پایش زنده اخبار Search Engine Journal، ترجمه و خلاصه سازی مفهومی توسط Gemini Flash و انتشار در کانال تلگرام و وردپرس با لینک‌سازی اتوماتیک.
                    </p>
                </div>

                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/60 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-mono">Python + Webhooks</span>
                    <a href="/projects" class="text-accent dark:text-blue-400 font-bold hover:underline">جزییات پروژه</a>
                </div>
            </div>

            <div class="rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden hover:border-accent/40 transition-all duration-300 group flex flex-col justify-between shadow-sm">
                <div class="p-6">
                    <div class="flex items-center justify-between text-xs text-accent dark:text-blue-400 font-bold mb-3">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-tag"></i> شبکه سایت‌های مارکتینگ
                        </span>
                        <span class="px-2 py-0.5 rounded bg-blue-50 dark:bg-slate-900 text-accent dark:text-blue-300 font-mono text-[11px] font-bold">
                            +۱۵۰٪ دیسکاور
                        </span>
                    </div>

                    <h3 class="text-base sm:text-lg font-black text-textMain dark:text-white mb-2 group-hover:text-accent transition-colors">
                        پایپ‌لاین تصویرسازی اختصاصی Imagen 3 برای وب‌سایت‌های وردپرسی
                    </h3>

                    <p class="text-slate-600 dark:text-slate-400 text-xs sm:text-sm leading-relaxed mb-4">
                        تولید تصاویر کاور استاندارد با متدهای ضد متن (No-Text Prompting) و تبدیل آنی به WebP در مدیا لایبرری وردپرس جهت بهبود سئوی بصری و دیسکاور.
                    </p>
                </div>

                <div class="px-6 py-4 bg-slate-50 dark:bg-slate-900/60 border-t border-gray-200 dark:border-slate-700 flex items-center justify-between text-xs">
                    <span class="text-slate-500 font-mono">Google Imagen 3</span>
                    <a href="/projects" class="text-accent dark:text-blue-400 font-bold hover:underline">جزییات پروژه</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۴.۵: بنر ویژه ارتقا به معماری MCP (Enterprise Upgrade)                 -->
<!-- ========================================================================= -->
<section class="py-12 bg-slate-900 text-white border-y border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        <div class="rounded-3xl p-8 sm:p-10 bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 border border-blue-800/40 shadow-2xl relative overflow-hidden flex flex-col lg:flex-row items-center justify-between gap-8">
            <div class="space-y-4 max-w-2xl text-right relative z-10">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold font-mono">
                    <span class="w-2 h-2 rounded-full bg-blue-400 animate-ping"></span>
                    <span>ENTERPRISE ARCHITECTURE • MODEL CONTEXT PROTOCOL</span>
                </div>
                <h3 class="text-xl sm:text-3xl font-black text-white leading-snug">
                    فراتر از تولید محتوا: یکپارچه‌سازی کامل AI با دیتابیس سازمان شما (MCP)
                </h3>
                <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light">
                    اگر به دنبال تبدیل هوش مصنوعی به یک کارمند اجرایی سازمانی با اتصال زنده به دیتابیس MySQL، CRM و اسناد شرکت در محیطی ایزوله و امن هستید، صفحه لندینگ تخصصی MCP را مشاهده کنید.
                </p>
                <div class="flex flex-wrap gap-3 pt-2 text-xs font-medium text-blue-200">
                    <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-400"></i> اتصال مستقیم به MySQL</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-400"></i> حریم خصوصی ۱۰۰٪ داده‌ها</span>
                    <span class="flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-400"></i> ارکستراسیون ایجنت‌های اجرایی</span>
                </div>
            </div>
            <div class="shrink-0 relative z-10 flex flex-col sm:flex-row lg:flex-col gap-3 w-full lg:w-auto">
                <a href="/services/mcp-automation" class="w-full inline-flex items-center justify-center gap-2.5 px-7 py-3.5 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-black text-sm shadow-lg transition-all">
                    <i class="fas fa-network-wired"></i>
                    <span>مشاهده لندینگ تخصصی MCP</span>
                </a>
                <a href="/services/mcp-simulator" class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold text-xs sm:text-sm transition-all">
                    <i class="fas fa-terminal"></i>
                    <span>تست زنده در کنسول شبیه‌ساز</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۵: سوالات متداول مدیران و کارفرمایان                                  -->
<!-- ========================================================================= -->
<section class="py-16 relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-4xl font-black text-textMain dark:text-white mb-2">
                پاسخ به دغدغه‌های کارفرمایان درباره محتوای AI
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm">
                شفاف‌سازی کامل درباره امنیت، سیاست‌های گوگل و هزینه‌های نگهداری سیستم
            </p>
        </div>

        <div class="space-y-3" id="ai-faq-accordion">
            <!-- سوال ۱ -->
            <div class="faq-item rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm">
                <button type="button" class="faq-toggle w-full p-5 text-right flex items-center justify-between gap-4 font-black text-textMain dark:text-white hover:text-accent transition-colors cursor-pointer" aria-expanded="false">
                    <span class="text-sm sm:text-base flex items-center gap-3">
                        <i class="fas fa-robot text-accent dark:text-blue-400 shrink-0"></i>
                        آیا گوگل وب‌سایت‌هایی که با هوش مصنوعی محتوا تولید می‌کنند را جریمه می‌کند؟
                    </span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-300 shrink-0"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-gray-200 dark:border-slate-700 pt-4">
                    خیر. طبق بیانیه رسمی گوگل (Google Search Central Guidelines on AI Content)، الگوریتم‌های گوگل روش تولید محتوا را جریمه نمی‌کنند؛ بلکه کیفیت، اصالت و میزان پاسخگویی به نیاز کاربر را بر اساس فاکتورهای E-E-A-T می‌سنجند. در سیستم‌های ما، پرامپت‌ها به گونه‌ای مهندسی شده‌اند که مقالات با ساختار عمیق، داده‌های تحلیلی، جداول مقایسه‌ای و پرهیز از تکرارهای خسته‌کننده نوشته شوند.
                </div>
            </div>

            <!-- سوال ۲ -->
            <div class="faq-item rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm">
                <button type="button" class="faq-toggle w-full p-5 text-right flex items-center justify-between gap-4 font-black text-textMain dark:text-white hover:text-accent transition-colors cursor-pointer" aria-expanded="false">
                    <span class="text-sm sm:text-base flex items-center gap-3">
                        <i class="fas fa-coins text-accent dark:text-blue-400 shrink-0"></i>
                        هزینه نگهداری سرور و مصرف توکن‌های Gemini API چقدر است؟
                    </span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-300 shrink-0"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-gray-200 dark:border-slate-700 pt-4">
                    API گوگل جمنای دارای قیمت‌گذاری بسیار اقتصادی است. تولید یک مقاله ۲۰۰۰ کلمه‌ای جامع به همراه تحلیل و پرامپت تصویرسازی کمتر از <strong>۰.۰۰۵ دلار</strong> هزینه توکن دارد که در مقایسه با نویسنده انسانی بیش از ۹۵ درصد صرفه‌جویی مالی مستقیم به همراه دارد.
                </div>
            </div>

            <!-- سوال ۳ -->
            <div class="faq-item rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 overflow-hidden shadow-sm">
                <button type="button" class="faq-toggle w-full p-5 text-right flex items-center justify-between gap-4 font-black text-textMain dark:text-white hover:text-accent transition-colors cursor-pointer" aria-expanded="false">
                    <span class="text-sm sm:text-base flex items-center gap-3">
                        <i class="fas fa-lock text-accent dark:text-blue-400 shrink-0"></i>
                        امنیت اتصال ربات به دیتابیس و هاست وردپرس چگونه است؟
                    </span>
                    <i class="fas fa-chevron-down text-xs text-slate-400 transition-transform duration-300 shrink-0"></i>
                </button>
                <div class="faq-content hidden px-5 pb-5 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed border-t border-gray-200 dark:border-slate-700 pt-4">
                    اتصال از طریق WordPress REST API و با Application Passwords با دسترسی کنترل‌شده صورت می‌گیرد. ربات دسترسی مستقیم به رمز اصلی هاست یا دیتابیس ندارد و تمام درخواست‌ها با پروتکل امن SSL/TLS انجام می‌پذیرد.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۶: Footer CTA                                                        -->
<!-- ========================================================================= -->
<section class="pb-16">
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="rounded-3xl p-8 sm:p-12 bg-accent text-white border border-blue-900 text-center relative overflow-hidden shadow-xl">
            <div class="relative z-10 max-w-2xl mx-auto space-y-6">
                <h2 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                    آماده‌اید وب‌سایت خود را به یک ماشین خودکار و سودآور تبدیل کنید؟
                </h2>

                <p class="text-blue-100 text-sm sm:text-base max-w-2xl mx-auto leading-relaxed font-normal">
                    همین امروز پتانسیل اتوماسیون فرآیندهای سئو و محتوای سایت خود را ارزیابی کنید. برای بررسی فنی و پیاده‌سازی زیرساخت هوش مصنوعی، فرم شروع را تکمیل کنید.
                </p>

                <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="/start" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-white text-textMain font-bold text-sm sm:text-base shadow-md hover:bg-slate-100 active:scale-95 transition-all">
                        <span>رزرو جلسه مشاوره اختصاصی</span>
                        <svg class="w-4 h-4 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7 7l-7-7 7-7"/></svg>
                    </a>
                    <a href="/contact" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl border-2 border-white text-white font-bold text-sm hover:bg-white/10 transition-all">
                        <span>تکمیل بریف هوشمند</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- اسکریپت آکاردئون -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const toggles = document.querySelectorAll('#ai-faq-accordion .faq-toggle');
    
    toggles.forEach(toggle => {
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const icon = this.querySelector('.fa-chevron-down');
            const isExpanded = this.getAttribute('aria-expanded') === 'true';

            toggles.forEach(otherToggle => {
                if (otherToggle !== toggle) {
                    otherToggle.setAttribute('aria-expanded', 'false');
                    otherToggle.nextElementSibling.classList.add('hidden');
                    const otherIcon = otherToggle.querySelector('.fa-chevron-down');
                    if (otherIcon) otherIcon.classList.remove('rotate-180');
                }
            });

            if (isExpanded) {
                this.setAttribute('aria-expanded', 'false');
                content.classList.add('hidden');
                if (icon) icon.classList.remove('rotate-180');
            } else {
                this.setAttribute('aria-expanded', 'true');
                content.classList.remove('hidden');
                if (icon) icon.classList.add('rotate-180');
            }
        });
    });
});
</script>
