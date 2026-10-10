<?php
/**
 * View: front/services/mcp-automation.php
 * لندینگ پیلار اختصاصی: خدمات یکپارچه‌سازی سازمانی هوش مصنوعی و پیاده‌سازی پروتکل MCP
 * نگارش با رویکرد B2B، تجاری، قاطع و متناسب با مدیران عامل و شرکت‌های بزرگ
 */
$badgeText = !empty($pageData['badge_text']) ? $pageData['badge_text'] : 'معماری ایجنت‌های سازمانی و پروتکل MCP | معمار سیستم: محمد مفتخری';
$h1Title   = 'یکپارچه‌سازی هوش مصنوعی با دیتای سازمان شما (بر بستر MCP)';
$subtitle  = 'هوش مصنوعی عمومی دیگر کافی نیست. ما با استفاده از معماری Model Context Protocol، دستیاران هوشمند (AI Agents) را مستقیماً به دیتابیس، CRM، و ابزارهای سازمانی شما متصل می‌کنیم. هوش مصنوعی حالا دقیقاً می‌داند در بیزینس شما چه می‌گذرد.';
$ctaTitle  = !empty($pageData['cta_title']) ? $pageData['cta_title'] : 'آماده‌اید هوش مصنوعی را به یک کارمند اجرایی و دقیق در سازمان تبدیل کنید؟';
$ctaButton = !empty($pageData['cta_button']) ? $pageData['cta_button'] : 'دریافت مشاوره معماری سازمانی MCP';
?>

<!-- مسیر راهنما (Breadcrumb) -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 pt-6">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خانه</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <a href="/#services" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خدمات تخصصی</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <span class="text-accent dark:text-blue-400 font-bold">یکپارچه‌سازی هوش مصنوعی سازمانی با MCP</span>
    </nav>
</div>

<!-- ========================================================================= -->
<!-- بخش ۱: Hero Section (قلاب اصلی B2B برای مدیران ارشد)                       -->
<!-- ========================================================================= -->
<section class="relative pt-8 pb-16 overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center relative z-10">
        
        <!-- بج هویت و تکنولوژی -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 text-textMain dark:text-slate-200 text-xs sm:text-sm font-bold shadow-sm border border-gray-200 dark:border-slate-700 mb-6">
            <span class="w-2.5 h-2.5 rounded-full bg-accent animate-pulse"></span>
            <span><?= e($badgeText) ?></span>
        </div>

        <!-- تیتر اصلی H1 (مطابق بریف) -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[2.65rem] font-black text-textMain dark:text-white leading-[1.35] sm:leading-[1.3] mb-6 max-w-4xl mx-auto">
            یکپارچه‌سازی هوش مصنوعی با دیتای سازمان شما <br class="hidden sm:inline">
            <span class="text-accent dark:text-blue-400">
                (بر بستر پروتکل MCP)
            </span>
        </h1>

        <!-- ساب‌تیتر توضیحی B2B (مطابق بریف) -->
        <p class="text-base sm:text-lg text-slate-700 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed mb-8 font-normal text-justify sm:text-center">
            هوش مصنوعی عمومی دیگر کافی نیست. ما با استفاده از معماری <strong class="text-accent dark:text-blue-400 font-bold" dir="ltr">Model Context Protocol</strong>، دستیاران هوشمند (AI Agents) را مستقیماً به دیتابیس، CRM، و ابزارهای سازمانی شما متصل می‌کنیم. هوش مصنوعی حالا دقیقاً می‌داند در بیزینس شما چه می‌گذرد.
        </p>

        <!-- ویژگی‌های کلیدی سازمانی -->
        <div class="flex flex-wrap items-center justify-center gap-3 mb-10 text-xs text-slate-700 dark:text-slate-300">
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-database text-blue-600 dark:text-blue-400"></i> اتصال مستقیم به MySQL / دیتابیس‌های ابری
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-user-shield text-emerald-600 dark:text-emerald-400"></i> حریم خصوصی داده و پردازش در محیط ایزوله
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-robot text-purple-600 dark:text-purple-400"></i> ارکستراسیون ایجنت‌های اجرایی خودکار
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-chart-line text-amber-600 dark:text-amber-400"></i> کاهش چشمگیر هزینه‌های عملیاتی سازمان
            </span>
        </div>

        <!-- دکمه‌های اقدام CTA -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 max-w-lg mx-auto">
            <a href="/start" class="w-full sm:w-auto inline-flex items-center justify-center gap-2.5 px-8 py-3.5 rounded-xl bg-accent text-white font-bold text-sm sm:text-base shadow-md hover:bg-opacity-90 active:scale-95 transition-all">
                <i class="fas fa-briefcase"></i>
                <span>درخواست مشاوره معماری سازمانی</span>
            </a>
            <a href="#playground" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl border-2 border-textMain dark:border-slate-600 text-textMain dark:text-slate-200 bg-transparent font-bold text-sm hover:bg-textMain hover:text-white transition-all">
                <i class="fas fa-terminal text-xs"></i>
                <span>تست زنده در شبیه‌ساز ایجنت</span>
            </a>
        </div>

        <!-- اطمینان و شفافیت -->
        <p class="mt-4 text-xs text-slate-500 dark:text-slate-400">
            <i class="fas fa-lock text-accent dark:text-blue-400 ml-1"></i> معماری بومی‌سازی‌شده، سبک و فوق‌العاده امن بدون نیاز به پلتفرم‌های واسط ناامن
        </p>

    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۲: باکس چالش و راه‌حل (ارزش‌افزوده MCP - ۳ کارت مدیران)                -->
<!-- ========================================================================= -->
<section class="py-14 bg-slate-100/70 dark:bg-slate-900/50 border-y border-gray-200 dark:border-slate-800">
    <div class="max-w-6xl mx-auto px-4 sm:px-6">
        
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-50 dark:bg-blue-950/50 border border-blue-200 dark:border-blue-800/60 text-accent dark:text-blue-300 text-xs font-bold mb-3 font-mono">
                <i class="fas fa-layer-group"></i> THE MCP VALUE PROPOSITION
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-textMain dark:text-white mb-3">
                چرا سازمان‌های پیشرو به معماری MCP مهاجرت می‌کنند؟
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-sm sm:text-base leading-relaxed">
                سه تفاوت بنیادی که هوش مصنوعی را از یک تفریح کارمندی به یک موتور ارزش‌آفرین و درآمدزا برای مدیران عامل تبدیل می‌کند:
            </p>
        </div>

        <!-- سه کارت ارزش‌افزوده MCP مطابق بریف -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-stretch">
            
            <!-- کارت ۱: اتصال مستقیم به منابع دیتای زنده -->
            <div class="p-7 rounded-3xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:border-accent dark:hover:border-blue-500 transition-all">
                <div class="absolute top-0 right-0 w-24 h-24 bg-blue-500/5 rounded-bl-full pointer-events-none"></div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xl mb-5 shadow-sm group-hover:scale-105 transition-transform">
                        <i class="fas fa-network-wired"></i>
                    </div>
                    <span class="text-[11px] font-bold text-accent dark:text-blue-400 uppercase tracking-wider block mb-1">کارت ۱ • Data Integration</span>
                    <h3 class="text-lg font-black text-textMain dark:text-white mb-3">
                        اتصال مستقیم به منابع دیتای زنده
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        <strong>خداحافظی با کپی-پیست دستی.</strong> متصل کردن امنِ هوش مصنوعی به گیت‌هاب، دیتابیس‌های ابری (MySQL/PostgreSQL) و شبکه‌های اجتماعی برای تحلیل و پردازش داده‌ها در لحظه، بدون اتلاف وقت نیروی انسانی.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700/80 flex items-center justify-between text-xs font-bold text-slate-500 dark:text-slate-400">
                    <span>دسترسی هم‌زمان به داده‌های واقعی</span>
                    <i class="fas fa-arrow-left text-accent dark:text-blue-400"></i>
                </div>
            </div>

            <!-- کارت ۲: اتوماسیون فرآیندهای پیچیده اجرایی -->
            <div class="p-7 rounded-3xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:border-accent dark:hover:border-blue-500 transition-all">
                <div class="absolute top-0 right-0 w-24 h-24 bg-purple-500/5 rounded-bl-full pointer-events-none"></div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-slate-700 text-purple-600 dark:text-purple-400 flex items-center justify-center text-xl mb-5 shadow-sm group-hover:scale-105 transition-transform">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <span class="text-[11px] font-bold text-purple-600 dark:text-purple-400 uppercase tracking-wider block mb-1">کارت ۲ • Executive Workflows</span>
                    <h3 class="text-lg font-black text-textMain dark:text-white mb-3">
                        اتوماسیون فرآیندهای پیچیده سازمانی
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        تبدیل هوش مصنوعی از یک <strong>"چت‌بات ساده"</strong> به یک <strong>"کارمند اجرایی ۲۴ ساعته"</strong> که می‌تواند اسناد و فایل‌ها را بخواند، مغایرت‌ها را پیدا کند و گزارش‌های مالی، فنی و مدیریتی صادر نماید.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700/80 flex items-center justify-between text-xs font-bold text-slate-500 dark:text-slate-400">
                    <span>اجرای هوشمند تسک‌ها بدون خطای انسانی</span>
                    <i class="fas fa-arrow-left text-purple-600 dark:text-purple-400"></i>
                </div>
            </div>

            <!-- کارت ۳: حریم خصوصی و امنیت فوق‌العاده داده‌ها -->
            <div class="p-7 rounded-3xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:border-accent dark:hover:border-blue-500 transition-all">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-500/5 rounded-bl-full pointer-events-none"></div>
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-slate-700 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl mb-5 shadow-sm group-hover:scale-105 transition-transform">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider block mb-1">کارت ۳ • Security & Privacy</span>
                    <h3 class="text-lg font-black text-textMain dark:text-white mb-3">
                        حریم خصوصی، ایزولاسیون و امنیت
                    </h3>
                    <p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                        <strong>دیتای شما هرگز از سازمان خارج نمی‌شود.</strong> معماری MCP اجازه می‌دهد هوش مصنوعی فقط در محیط ایزوله و امن سرور اختصاصی شما اطلاعات را پردازش کند، بدون اینکه داده‌های حساس فاش گردند.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-slate-700/80 flex items-center justify-between text-xs font-bold text-slate-500 dark:text-slate-400">
                    <span>انطباق کامل با پروتکل‌های امنیتی B2B</span>
                    <i class="fas fa-arrow-left text-emerald-600 dark:text-emerald-400"></i>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۳: کاربردهای عملی برای کارفرما (Enterprise Use Cases)                 -->
<!-- ========================================================================= -->
<section class="py-16 max-w-6xl mx-auto px-4 sm:px-6">
    <div class="p-8 sm:p-12 rounded-3xl bg-slate-900 text-white shadow-2xl relative overflow-hidden">
        <!-- Glowing Orbs -->
        <div class="absolute -top-20 -right-20 w-72 h-72 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-72 h-72 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold mb-3">
                <i class="fas fa-briefcase"></i> کاربردهای تجاری و سازمانی (B2B Use Cases)
            </div>
            <h2 class="text-2xl sm:text-4xl font-black mb-3 text-white">
                هوش مصنوعی در کسب‌وکار شما چه کارهایی را اتوماتیک می‌کند؟
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                سناریوهای عملیاتی پیاده‌سازی‌شده که ده‌ها ساعت زمان مدیران و کارشناسان را در هفته آزاد کرده‌اند:
            </p>
        </div>

        <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- یوزکیس ۱ -->
            <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700 hover:border-blue-500 transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-xl font-bold mb-4">
                        <i class="fas fa-chart-pie"></i>
                    </div>
                    <h3 class="text-base font-bold mb-2 text-white">
                        ۱. تحلیل خودکار رفتار کاربران سایت با اتصال به MySQL
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        اتصال هوش مصنوعی به جداول لیدها، سفارش‌ها و رخدادها؛ شناسایی خودکار صفحات با ریزش بالا، تحلیل سبدهای خرید رهاشده و صدور گزارش‌های هفتگی برای هیئت مدیره.
                    </p>
                </div>
                <div class="text-[11px] font-mono text-blue-300 bg-blue-950/60 p-2.5 rounded-xl border border-blue-900/50">
                    <i class="fas fa-check text-emerald-400 ml-1"></i> کوئری‌های Real-time بدون نیاز به باز کردن دیتابیس
                </div>
            </div>

            <!-- یوزکیس ۲ -->
            <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700 hover:border-purple-500 transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-xl font-bold mb-4">
                        <i class="fas fa-comments-dollar"></i>
                    </div>
                    <h3 class="text-base font-bold mb-2 text-white">
                        ۲. ساخت ربات‌های پاسخگوی سازمانی با دسترسی به کل اسناد
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        پاسخ‌دهی دقیق، حرفه‌ای و ۲۴ ساعته به سوالات مشتریان و کارکنان با دسترسی ایمن به فایل‌های قراردادها، کاتالوگ‌های فنی و مقررات سازمانی در محیط سرور شما.
                    </p>
                </div>
                <div class="text-[11px] font-mono text-purple-300 bg-purple-950/60 p-2.5 rounded-xl border border-purple-900/50">
                    <i class="fas fa-check text-emerald-400 ml-1"></i> کاهش ۸۰ درصدی بار پشتیبانی و تیکت‌ها
                </div>
            </div>

            <!-- یوزکیس ۳ -->
            <div class="p-6 rounded-2xl bg-slate-800/80 border border-slate-700 hover:border-cyan-500 transition-all flex flex-col justify-between">
                <div>
                    <div class="w-12 h-12 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center text-xl font-bold mb-4">
                        <i class="fab fa-linkedin"></i>
                    </div>
                    <h3 class="text-base font-bold mb-2 text-white">
                        ۳. اتوماسیون لینکدین و شبکه‌های اجتماعی بر اساس دیتای زنده
                    </h3>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        پایش مداوم اخبار، تغییرات بازار و دیتای داخلی کسب‌وکار؛ تدوین پیش‌نویس پست‌های تحلیلی B2B و انتشار منظم در لینکدین با تأیید نهایی مدیر مارکتینگ.
                    </p>
                </div>
                <div class="text-[11px] font-mono text-cyan-300 bg-cyan-950/60 p-2.5 rounded-xl border border-cyan-900/50">
                    <i class="fas fa-check text-emerald-400 ml-1"></i> پرسونال برندینگ مداوم و لیدجنریشن B2B
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۳.۵: شبیه‌ساز سناریوهای ملموس MCP (The Executive MCP Scenario Demo)    -->
<!-- ========================================================================= -->
<section id="mcp-executive-simulator" class="py-14 bg-slate-950 text-white border-y border-slate-800 relative overflow-hidden">
    <!-- پس‌زمینه نوری شیک و مدرن -->
    <div class="absolute -top-32 right-1/4 w-96 h-96 bg-blue-600/15 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute -bottom-32 left-1/4 w-96 h-96 bg-indigo-600/15 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10">
        
        <!-- ۱. تیتر و ساب‌تیتر سکشن (مطابق بریف) -->
        <div class="text-center max-w-3xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-blue-500/10 border border-blue-400/20 text-blue-400 text-xs font-bold font-mono mb-3">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>INTERACTIVE SCENARIO SIMULATOR</span>
            </div>
            <h2 class="text-2xl sm:text-4xl font-black text-white mb-3 tracking-tight">
                MCP در عمل؛ دستیار هوشمند شما در سازمان چه می‌کند؟
            </h2>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto font-light">
                هوش مصنوعی عمومی را فراموش کنید. ببینید وقتی AI به دیتابیس‌های شما متصل می‌شود، روز کاری یک مدیرعامل چطور تغییر می‌کند.
            </p>
        </div>

        <!-- ۲. رابط کاربری شبیه‌ساز (پنجره چت و ترمینال مدرن با استایل macOS) -->
        <div class="rounded-3xl bg-slate-900/90 border border-slate-700/80 shadow-2xl backdrop-blur-xl overflow-hidden mb-8">
            
            <!-- هدر پنجره شبیه‌ساز (تب‌ها و کنترل‌ها) -->
            <div class="px-5 py-3.5 bg-slate-950 border-b border-slate-800 flex flex-wrap items-center justify-between gap-3">
                
                <!-- دکمه‌های پنجره سیستم -->
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-rose-500/80"></span>
                    <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                    <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                    <span class="text-xs font-mono text-slate-400 font-bold mr-2 hidden sm:inline">MCP Core Orchestrator v2.4</span>
                </div>

                <!-- تب‌های سناریو (دستیار گزارش‌گیری صبحگاهی) -->
                <div class="flex items-center gap-2">
                    <button type="button" id="tab-morning-brief" onclick="switchMcpScenario('morning')" class="px-3.5 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                        <span>📊 دستیار گزارش‌گیری صبحگاهی</span>
                    </button>
                    <button type="button" id="tab-incident-alert" onclick="switchMcpScenario('incident')" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all flex items-center gap-1.5">
                        <span>🚨 هشدار بحرانی زیرساخت</span>
                    </button>
                    <button type="button" id="tab-inventory-check" onclick="switchMcpScenario('sales')" class="px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all hidden md:flex items-center gap-1.5">
                        <span>🎯 سئو و ریزش سبد خرید</span>
                    </button>
                </div>

                <!-- دکمه اجرای مجدد انیمیشن -->
                <button type="button" onclick="replayCurrentScenario()" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1.5 p-1.5 rounded-lg hover:bg-slate-800" title="اجرای مجدد انیمیشن">
                    <i class="fas fa-rotate-right text-xs"></i>
                    <span class="hidden sm:inline">تکرار شبیه‌سازی</span>
                </button>
            </div>

            <!-- بدنه چت و شبیه‌سازی تعاملی -->
            <div class="p-6 sm:p-8 space-y-6">
                
                <!-- ۱. باکس ورودی کاربر (پرامپت مدیرعامل) -->
                <div class="flex items-start gap-3.5 sm:gap-4">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-slate-700 to-slate-600 text-white flex items-center justify-center shrink-0 shadow-md border border-slate-600 text-base">
                        <i class="fas fa-user-tie"></i>
                    </div>
                    <div class="flex-1 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-300">مدیرعامل / کارفرما</span>
                            <span class="text-[11px] font-mono text-slate-400">08:30 AM • دستور صوتی/متنی</span>
                        </div>
                        <div class="p-4 sm:p-5 rounded-2xl rounded-tr-none bg-blue-950/60 border border-blue-800/60 text-white text-xs sm:text-sm leading-relaxed shadow-sm font-medium" id="scenario-user-prompt">
                            «گزارش صبحگاهی من رو آماده کن: مجموع واریزی‌های دیروز رو از نرم‌افزار حسابداری بخون، پربازدیدترین مقاله سایت رو برام لیست کن و از تو CRM بگو امروز کدوم مشتری‌ها منتظر تماس من هستن.»
                        </div>
                    </div>
                </div>

                <!-- خط پایپ‌لاین اتصال ابزارهای MCP (MCP Bridge Status) -->
                <div class="py-2 px-4 rounded-xl bg-slate-950/80 border border-slate-800/80 flex flex-wrap items-center justify-between gap-3 text-[11px] font-mono" id="scenario-tools-bridge">
                    <div class="flex items-center gap-2 text-slate-400">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span class="text-emerald-400 font-bold">MCP BRIDGE ACTIVATED:</span>
                        <span class="text-slate-300 hidden sm:inline">اتصال و واکشی هم‌زمان از ۳ دیتابیس ایزوله</span>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="px-2 py-0.5 rounded-md bg-blue-900/50 text-blue-300 border border-blue-800">💳 نرم‌افزار مالی (SQL)</span>
                        <span class="px-2 py-0.5 rounded-md bg-purple-900/50 text-purple-300 border border-purple-800">🌐 پایگاه وب‌سایت</span>
                        <span class="px-2 py-0.5 rounded-md bg-amber-900/50 text-amber-300 border border-amber-800">👥 سامانه CRM</span>
                    </div>
                </div>

                <!-- ۲. باکس خروجی سیستم (AI Response با انیمیشن تایپینگ لایو) -->
                <div class="flex items-start gap-3.5 sm:gap-4">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-gradient-to-tr from-blue-600 to-accent text-white flex items-center justify-center shrink-0 shadow-lg border border-blue-400/40 text-base">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="flex-1 space-y-1.5">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-blue-400">دستیار یکپارچه سازمانی (CeliauP MCP Agent)</span>
                                <span class="px-2 py-0.5 rounded-md text-[10px] bg-emerald-950 text-emerald-400 border border-emerald-800/60 font-mono">Response: 320ms</span>
                            </div>
                            <span class="text-[11px] font-mono text-slate-400">08:30:01 AM</span>
                        </div>
                        
                        <!-- ظرف متن خروجی تایپ‌شونده -->
                        <div class="p-5 sm:p-6 rounded-2xl rounded-tl-none bg-slate-950 border border-slate-700/80 text-slate-100 text-xs sm:text-sm leading-loose font-normal shadow-inner relative">
                            <div id="mcp-typed-output" class="whitespace-pre-line min-h-[90px]"></div>
                            <span id="mcp-typing-cursor" class="inline-block w-2 h-4 bg-blue-400 ml-1 animate-pulse align-middle"></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- ۳. باکس ارزش‌افزوده تجاری (چرا این MCP است؟ - مطابق بریف) -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-blue-950/80 via-slate-900 to-slate-900 border-2 border-blue-500/30 shadow-xl relative overflow-hidden">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shrink-0 text-2xl shadow-lg">
                    <i class="fas fa-wand-magic-sparkles"></i>
                </div>
                <div class="space-y-2">
                    <h3 class="text-lg sm:text-xl font-black text-white flex items-center gap-2">
                        <span>جادوی MCP در چیست؟</span>
                        <span class="text-xs font-mono font-normal text-cyan-400 bg-blue-950 px-2.5 py-0.5 rounded-full border border-blue-800">Zero Copy-Paste</span>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-light text-justify sm:text-right">
                        این سیستم مانند یک پل نامرئی، جزیره‌های اطلاعاتی سازمان شما (نرم‌افزار مالی، سایت، CRM) را به هم وصل می‌کند. به جای گرفتن ۳ گزارش از ۳ مدیر مختلف در ۲ ساعت، مدیرعامل کلیدی‌ترین داده‌های سازمان را در ۳ ثانیه و با یک دستور ساده دریافت می‌کند. ما این معماری یکپارچه را روی سرور اختصاصی شما پیاده می‌کنیم.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- اسکریپت سبک جاوااسکریپت خام جهت اجرای سناریوها و انیمیشن تایپینگ بدون کتابخانه خارجی -->
<script>
(function() {
    const scenarios = {
        morning: {
            user: '«گزارش صبحگاهی من رو آماده کن: مجموع واریزی‌های دیروز رو از نرم‌افزار حسابداری بخون، پربازدیدترین مقاله سایت رو برام لیست کن و از تو CRM بگو امروز کدوم مشتری‌ها منتظر تماس من هستن.»',
            bridge: [
                '💳 نرم‌افزار مالی (SQL)',
                '🌐 پایگاه وب‌سایت',
                '👥 سامانه CRM'
            ],
            response: `✅ گزارش آماده شد:
💰 حسابداری: واریزی دیروز ۱۲۵ میلیون تومان (رشد ۵٪).
📈 سایت: مقاله "کاهش هزینه‌های سئو" با ۸۰۰ بازدید در صدر است.
📞 فروش (CRM): آقای رضایی (پروژه طراحی اختصاصی) و خانم تهرانی ساعت ۱۱ منتظر تماس شما هستند.`
        },
        incident: {
            user: '«وضعیت درگاه‌های پرداخت، سلامت سرور و تراکنش‌های ناموفق ۱۵ دقیقه اخیر رو فورا بررسی کن.»',
            bridge: [
                '🛡️ لاگ‌های وب‌سرور LiteSpeed',
                '💳 درگاه بانکی سامان و ملت',
                '📱 ربات هشدار تلگرام'
            ],
            response: `✅ ممیزی بلادرنگ زیرساخت:
🟢 درگاه‌های پرداخت: ۱۰۰٪ متصل و نرخ تراکنش موفق ۹۸.۴٪.
⚡ سرور: مصرف CPU زیر ۱۸٪ و پاسخ‌دهی TTFB روی ۹۵ میلی‌ثانیه.
🔔 تراکنش ناموفق: صفر مورد در ۱۵ دقیقه گذشته ثبت گردیده است.`
        },
        sales: {
            user: '«لیست ۵ مشتری که بیش از ۳ بار سبد خرید را رها کرده‌اند به همراه شماره تماس استخراج کن تا به مدیر فروش ارسال شود.»',
            bridge: [
                '🛒 جداول ووکامرس/سفارشات',
                '📊 سیستم ردیابی لیدها',
                '💬 نوتیفایر اختصاصی بله/تلگرام'
            ],
            response: `✅ ۵ فرصت داغ فروش استخراج شد:
👥 لیست به همراه سبد خرید پیشنهادی و شماره تماس تفکیک گردید.
📲 پیام خودکار هماهنگی جلسه به تلگرام مدیر فروش دیسپچ شد.
🎯 پیش‌بینی بازیابی فروش: تا ۴۵ میلیون تومان با پیگیری تلفنی امروز.`
        }
    };

    let currentScenarioKey = 'morning';
    let typingTimer = null;

    window.switchMcpScenario = function(key) {
        if (!scenarios[key]) return;
        currentScenarioKey = key;

        // به‌روزرسانی استایل تب‌ها
        const tabs = {
            morning: document.getElementById('tab-morning-brief'),
            incident: document.getElementById('tab-incident-alert'),
            sales: document.getElementById('tab-inventory-check')
        };
        Object.keys(tabs).forEach(k => {
            if (tabs[k]) {
                if (k === key) {
                    tabs[k].className = 'px-3.5 py-1.5 rounded-xl bg-blue-600 text-white text-xs font-bold transition-all shadow-sm flex items-center gap-1.5';
                } else {
                    tabs[k].className = 'px-3.5 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition-all flex items-center gap-1.5';
                }
            }
        });

        // به‌روزرسانی پرامپت کاربر
        const userPromptEl = document.getElementById('scenario-user-prompt');
        if (userPromptEl) {
            userPromptEl.textContent = scenarios[key].user;
        }

        // اجرای انیمیشن تایپینگ
        runTypingAnimation(scenarios[key].response);
    };

    window.replayCurrentScenario = function() {
        if (scenarios[currentScenarioKey]) {
            runTypingAnimation(scenarios[currentScenarioKey].response);
        }
    };

    function runTypingAnimation(fullText) {
        if (typingTimer) {
            clearInterval(typingTimer);
        }

        const outputEl = document.getElementById('mcp-typed-output');
        const cursorEl = document.getElementById('mcp-typing-cursor');
        if (!outputEl) return;

        outputEl.textContent = '';
        if (cursorEl) cursorEl.style.display = 'inline-block';

        let idx = 0;
        const speed = 18; // میلی‌ثانیه برای هر کاراکتر

        typingTimer = setInterval(() => {
            if (idx < fullText.length) {
                outputEl.textContent += fullText.charAt(idx);
                idx++;
            } else {
                clearInterval(typingTimer);
                typingTimer = null;
                if (cursorEl) {
                    setTimeout(() => {
                        cursorEl.style.display = 'none';
                    }, 2500);
                }
            }
        }, speed);
    }

    // اجرای خودکار در زمان لود صفحه یا مشاهده سکشن
    document.addEventListener('DOMContentLoaded', function() {
        const targetSection = document.getElementById('mcp-executive-simulator');
        let hasTriggered = false;

        if ('IntersectionObserver' in window && targetSection) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !hasTriggered) {
                        hasTriggered = true;
                        runTypingAnimation(scenarios.morning.response);
                        observer.disconnect();
                    }
                });
            }, { threshold: 0.25 });
            observer.observe(targetSection);
        } else {
            // Fallback
            setTimeout(() => {
                runTypingAnimation(scenarios.morning.response);
            }, 800);
        }
    });
})();
</script>

<!-- ========================================================================= -->
<!-- بخش ۴: سیگنال E-E-A-T (نقل‌قول و تجربه معمار سیستم: محمد مفتخری)            -->
<!-- ========================================================================= -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 pb-16">
    <div class="p-8 sm:p-10 rounded-3xl bg-white dark:bg-slate-800 border-2 border-accent/20 dark:border-blue-500/30 shadow-xl relative overflow-hidden">
        <div class="flex items-center gap-2 text-xs font-bold text-accent dark:text-blue-400 uppercase tracking-wider mb-4">
            <i class="fas fa-quote-right text-lg"></i>
            <span>دیدگاه تجاری و استراتژیک معمار سیستم (E-E-A-T Signal)</span>
        </div>

        <!-- متن نقل‌قول مطابق بریف -->
        <blockquote class="text-base sm:text-xl font-black text-textMain dark:text-white leading-relaxed mb-6">
            "توسعه سرورهای MCP، مرز بین سایت‌های معمولی و نرم‌افزارهای هوشمند است. من در معماری‌های اختصاصی خود (با PHP خالص)، هوش مصنوعی را تبدیل به یک ابزار عملیاتی برای کاهش هزینه‌های سازمان شما می‌کنم."
        </blockquote>

        <div class="flex items-center justify-between flex-wrap gap-4 pt-4 border-t border-gray-100 dark:border-slate-700">
            <div class="flex items-center gap-3">
                <img src="/assets/images/mohammadmoftakhari.jpg" alt="محمد مفتخری" class="w-12 h-12 rounded-2xl object-cover shadow-sm border border-gray-200 dark:border-slate-600">
                <div>
                    <h4 class="text-sm font-black text-textMain dark:text-white">محمد مفتخری</h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">استراتژیست ارشد سئو و معمار سیستم‌های اتوماسیون داده و MCP</p>
                </div>
            </div>
            <a href="/about" class="text-xs font-bold text-accent dark:text-blue-400 hover:underline flex items-center gap-1.5">
                <span>مشاهده سوابق و تجربیات</span>
                <i class="fas fa-arrow-left text-[10px]"></i>
            </a>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۵: آزمایشگاه زنده و شبیه‌ساز تعاملی ارکستراسیون ایجنت‌ها                 -->
<!-- ========================================================================= -->
<section id="playground" class="max-w-5xl mx-auto px-4 sm:px-6 pb-16 scroll-mt-24">
    
    <!-- کارت فرم درخواست -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-xl p-6 sm:p-8 mb-8 transition-all">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-slate-700/80 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center font-black text-lg">
                    <i class="fas fa-terminal"></i>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-textMain dark:text-white">کنسول شبیه‌ساز زنده: ارکستراسیون ایجنت و ابزارهای MCP</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">یک دستور سازمانی به زبان فارسی بنویسید تا نحوه تصمیم‌گیری و اجرای ابزار توسط هوش مصنوعی را ببینید.</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                سرور MCP فعال
            </span>
        </div>

        <?php if (!empty($errorMessage)): ?>
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-base"></i>
                <span><?= e($errorMessage) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/services/mcp-automation#results" class="space-y-5">
            <div>
                <label for="user_command" class="block text-sm font-bold text-textMain dark:text-slate-200 mb-2">
                    دستور یا خواسته شما از ایجنت سازمانی:
                </label>
                <div class="relative">
                    <textarea 
                        id="user_command" 
                        name="user_command" 
                        rows="3" 
                        required
                        placeholder="مثال: وضعیت سئو و سلامت ساختار سایت maaadmr.ir را با ابزار خزش بررسی کن..."
                        class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/80 border border-gray-200 dark:border-slate-700 text-textMain dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-sm leading-relaxed transition-all resize-y font-medium"
                    ><?= e($userCommand ?? '') ?></textarea>
                </div>
            </div>

            <!-- نمونه‌های آماده برای تست سریع مدیران -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">نمونه دستورات اجرایی آماده:</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="setCommand('وضعیت سرعت، عنوان‌ها و ریدایرکت‌های سایت https://digikala.com را خزش کن')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-300 text-xs font-medium border border-gray-200 dark:border-slate-600 transition-all text-right flex items-center gap-2">
                        <i class="fas fa-globe text-blue-500 text-xs"></i>
                        <span>آنالیز زنده وب‌سایت (Web Scraper)</span>
                    </button>
                    <button type="button" onclick="setCommand('دیتابیس را برای بازیابی ۵ لید اخیر و پروژه‌های ثبت‌شده بررسی کن')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-300 text-xs font-medium border border-gray-200 dark:border-slate-600 transition-all text-right flex items-center gap-2">
                        <i class="fas fa-database text-amber-500 text-xs"></i>
                        <span>کوئری مستقیم به MySQL</span>
                    </button>
                    <button type="button" onclick="setCommand('یک پیام هشدار فوری در مورد قطعی درگاه پرداخت به تلگرام مدیریت بفرست')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-300 text-xs font-medium border border-gray-200 dark:border-slate-600 transition-all text-right flex items-center gap-2">
                        <i class="fab fa-telegram text-sky-500 text-xs"></i>
                        <span>ارسال الرت لحظه‌ای به تلگرام</span>
                    </button>
                </div>
            </div>

            <!-- دکمه ارسال -->
            <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                    <i class="fas fa-microchip text-accent dark:text-blue-400"></i>
                    <span>مبتنی بر پروتکل رسمی Model Context Protocol و موتور هوشمند Gemini</span>
                </div>
                <button 
                    type="submit" 
                    id="submitBtn"
                    class="px-8 py-3.5 rounded-2xl bg-accent hover:bg-accentHover text-white font-bold text-sm sm:text-base shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
                >
                    <i class="fas fa-play"></i>
                    <span>اجرای ابزار MCP و پردازش زنده</span>
                </button>
            </div>
        </form>
    </div>

    <!-- نتایج و لاگ اجرای ابزار -->
    <?php if ($toolDecided !== null || !empty($executionLogs)): ?>
        <div id="results" class="scroll-mt-20 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-xl p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-700/80 pb-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg font-bold">
                            <i class="fas fa-check-double"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-textMain dark:text-white">گزارش ارکستراسیون هوش مصنوعی و اجرای ابزار</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">ایجنت با تحلیل بستر، ابزار مناسب MCP را بدون خطا فراخوانی کرد</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="px-3 py-1 rounded-xl text-xs font-bold bg-blue-50 text-accent dark:bg-slate-700 dark:text-blue-300 border border-blue-200 dark:border-slate-600">
                            زمان پاسخ: <?= number_format($latencyMs) ?> میلی‌ثانیه
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-2">ابزار فعال‌شده روی سرور MCP:</span>
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-accent"></span>
                            <span class="font-bold text-base text-accent dark:text-blue-400">
                                <?php if ($toolDecided === 'web_scraper_tool'): ?>
                                    🔍 ابزار خزش و پایش وب (Web Scraper)
                                <?php elseif ($toolDecided === 'database_query_tool'): ?>
                                    🗄️ ابزار کوئری امن دیتابیس (SQL Engine)
                                <?php elseif ($toolDecided === 'telegram_notifier_tool'): ?>
                                    📢 ابزار دیسپچ نوتیفیکیشن تلگرام
                                <?php else: ?>
                                    <?= e($toolDecided) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">
                            <?php if ($toolDecided === 'web_scraper_tool'): ?>
                                ایجنت صفحه را خزش کرده و هدینگ‌ها، متاها و وضعیت فنی را استخراج نمود.
                            <?php elseif ($toolDecided === 'database_query_tool'): ?>
                                کوئری استاندارد با سطح دسترسی محدود به دیتابیس ارسال و رکوردها استخراج شدند.
                            <?php elseif ($toolDecided === 'telegram_notifier_tool'): ?>
                                پیام ساختاریافته به بات تلگرام تحویل و برای ادمین ارسال شد.
                            <?php else: ?>
                                فراخوانی ابزار بر بستر پروتکل استاندارد با موفقیت انجام شد.
                            <?php endif; ?>
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-2">خروجی و پاسخ تجمیعی ایجنت:</span>
                        <p class="text-xs sm:text-sm font-medium text-textMain dark:text-slate-200 leading-relaxed">
                            <?= e($toolOutput ?? 'عملیات با موفقیت انجام شد.') ?>
                        </p>
                    </div>
                </div>

                <!-- لاگ سرور -->
                <div>
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-2 flex items-center gap-2">
                        <i class="fas fa-terminal text-accent dark:text-blue-400"></i>
                        <span>لاگ تعاملات سرور MCP (Execution Flow):</span>
                    </span>
                    <div class="p-4 rounded-2xl bg-[#0B1120] border border-slate-800 font-mono text-xs text-slate-300 space-y-1.5 shadow-inner" dir="ltr">
                        <?php foreach ($executionLogs as $idx => $log): ?>
                            <div class="flex items-start gap-2">
                                <span class="text-slate-600 select-none">[<?= sprintf('%02d', $idx + 1) ?>]</span>
                                <span class="text-slate-300"><?= htmlspecialchars(strip_tags($log)) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

        </div>
    <?php endif; ?>

</section>

<script>
function setCommand(text) {
    const el = document.getElementById('user_command');
    if (el) {
        el.value = text;
        el.focus();
    }
}
</script>

<!-- ========================================================================= -->
<!-- بخش ۶: سوالات متداول مدیران B2B (FAQ)                                      -->
<!-- ========================================================================= -->
<section class="max-w-4xl mx-auto px-4 sm:px-6 pb-16">
    <div class="text-center mb-10">
        <h2 class="text-2xl sm:text-3xl font-black text-textMain dark:text-white mb-2">
            سوالات متداول مدیران ارشد درباره پروتکل MCP
        </h2>
        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
            پاسخ‌های شفاف و فنی به دغدغه‌های امنیتی، معماری و اقتصادی سازمان‌ها
        </p>
    </div>

    <div class="space-y-4">
        <details class="group p-5 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm" open>
            <summary class="flex items-center justify-between cursor-pointer font-bold text-sm sm:text-base text-textMain dark:text-white">
                <span>تفاوت بنیادی MCP با چت‌بات‌های عمومی و API سنتی چیست؟</span>
                <i class="fas fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                چت‌بات‌های سنتی فقط متن دریافت و متن تولید می‌کنند و برای کار با دیتای سازمانی نیازمند کپی-پیست دستی هستند. پروتکل MCP (Model Context Protocol) یک استاندارد معماری باز است که به مدل‌های هوش مصنوعی اجازه می‌دهد با ابزارها (Tools)، منابع داده (Resources) و دستورالعمل‌های اختصاصی سازمان به‌صورت بلادرنگ، امن و دوطرفه تعامل داشته باشند و مستقیماً اقدامات اجرایی را رقم بزنند.
            </p>
        </details>

        <details class="group p-5 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm">
            <summary class="flex items-center justify-between cursor-pointer font-bold text-sm sm:text-base text-textMain dark:text-white">
                <span>امنیت و محرمانگی داده‌های دیتابیس در سازمان چگونه حفظ می‌شود؟</span>
                <i class="fas fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                در معماری پیاده‌سازی‌شده توسط ما، سرور MCP در محیط ایزوله سازمان شما مستقر می‌شود. مدل‌های هوش مصنوعی دسترسی مستقیم به جداول دیتابیس یا رمزهای اصلی ندارند؛ بلکه از طریق Function Calling و کدهای اعتبارسنجی‌شده PHP با حداقل دسترسی لازم (Least Privilege) فقط داده‌های تعریف‌شده را پردازش می‌کنند و هیچ اطلاعات محرمانه‌ای در آموزش عمومی مدل‌ها به کار نمی‌رود.
            </p>
        </details>

        <details class="group p-5 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm">
            <summary class="flex items-center justify-between cursor-pointer font-bold text-sm sm:text-base text-textMain dark:text-white">
                <span>فرآیند استقرار و اتصال MCP چقدر زمان می‌برد و به چه زیرساختی نیاز دارد؟</span>
                <i class="fas fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                با توجه به اینکه معماری ما با PHP خالص، فوق‌سبک و بدون وابستگی به فریم‌ورک‌های سنگین طراحی شده است، بر روی سرورهای استاندارد لینوکسی، هاست‌های اشتراکی قدرتمند یا VPSهای سازمانی بدون نیاز به GPUهای گران‌قیمت در کمتر از ۳ تا ۷ روز کاری مستقر و تحویل داده می‌شود.
            </p>
        </details>

        <details class="group p-5 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm">
            <summary class="flex items-center justify-between cursor-pointer font-bold text-sm sm:text-base text-textMain dark:text-white">
                <span>چگونه هزینه‌های توکن و پردازش را در مقیاس سازمانی مدیریت می‌کنید؟</span>
                <i class="fas fa-chevron-down text-xs text-slate-400 group-open:rotate-180 transition-transform"></i>
            </summary>
            <p class="mt-3 text-xs sm:text-sm text-slate-600 dark:text-slate-300 leading-relaxed">
                ما از الگوهای کشینگ هوشمند (Smart Context Caching)، فیلترسازی ورودی‌ها قبل از ارسال به مدل، و مدل‌های مقرون‌به‌صرفه و سریع نظیر Gemini 1.5 Flash استفاده می‌کنیم. این معماری هزینه پردازش هر تسک پیچیده را به چند ریال تقلیل داده و بازگشت سرمایه (ROI) بیش از ۹۵ درصدی را تضمین می‌کند.
            </p>
        </details>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش ۷: بنر اقدام فوری مدیران (Enterprise CTA Banner)                       -->
<!-- ========================================================================= -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pb-20">
    <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-r from-accent to-[#172554] text-white shadow-2xl relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-8">
        <div class="space-y-3 text-center sm:text-right relative z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-cyan-300 text-xs font-bold">
                <i class="fas fa-sparkles"></i> گام بعدی برای کسب‌وکار شما
            </span>
            <h3 class="text-xl sm:text-3xl font-black"><?= e($ctaTitle) ?></h3>
            <p class="text-xs sm:text-sm text-blue-100 font-light max-w-xl leading-relaxed">
                جلسه تخصصی ارزیابی نیازمندی‌ها، طراحی نقشه راه ادغام MCP و بررسی امنیتی دیتای سازمان را با محمد مفتخری هماهنگ کنید.
            </p>
        </div>
        <div class="shrink-0 relative z-10 flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <a href="/start" class="w-full sm:w-auto px-7 py-4 rounded-2xl bg-white text-accent hover:bg-slate-100 font-black text-sm sm:text-base shadow-lg transition-all inline-flex items-center justify-center gap-2">
                <i class="fas fa-calendar-check"></i>
                <span>رزرو جلسه مشاوره اختصاصی</span>
            </a>
            <a href="/contact" class="w-full sm:w-auto px-6 py-4 rounded-2xl bg-blue-700/80 hover:bg-blue-700 text-white font-bold text-sm transition-all inline-flex items-center justify-center gap-2">
                <i class="fas fa-phone-volume"></i>
                <span>تماس مستقیم</span>
            </a>
        </div>
    </div>
</section>
