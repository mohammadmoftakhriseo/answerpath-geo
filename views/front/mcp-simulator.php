<?php
/**
 * View: front/mcp-simulator.php
 * شبیه‌ساز پروتکل MCP و اجرای هوشمند ابزارها
 * نگارش به زبان ساده، شفاف و قابل فهم برای کاربران و مدیران
 */
?>

<!-- مسیر راهنما (Breadcrumb) -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 pt-6">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خانه</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <a href="/services/mcp-automation" class="hover:text-accent dark:hover:text-blue-400 transition-colors">اتوماسیون سازمانی با MCP</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <span class="text-accent dark:text-blue-400 font-bold">کنسول شبیه‌ساز ایجنت‌های سازمانی (MCP)</span>
    </nav>
</div>

<!-- ========================================================================= -->
<!-- بلاک خلاصه به زبان ساده                                                    -->
<!-- ========================================================================= -->
<section id="sge-mcp-summary" class="max-w-6xl mx-auto px-4 sm:px-6 mt-4">
    <div class="p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 text-xs sm:text-sm text-slate-700 dark:text-slate-300 flex items-start gap-3.5 shadow-sm">
        <div class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center shrink-0 text-sm">
            <i class="fas fa-lightbulb"></i>
        </div>
        <p class="leading-relaxed">
            <strong>کنسول تست زنده پروتکل MCP:</strong> در این شبیه‌ساز تعاملی، دستورات سازمانی خود را به زبان فارسی مطرح کنید تا مشاهده فرمایید مدل هوش مصنوعی چگونه بستر داده را تحلیل نموده، ابزار مناسب MCP (خزش وب، کوئری MySQL یا دیسپچ تلگرام) را برمی‌گزیند و عملیات را بدون دخالت دستی به پایان می‌رساند.
        </p>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش Hero Section                                                          -->
<!-- ========================================================================= -->
<section class="relative pt-8 pb-12 overflow-hidden">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center relative z-10">
        
        <!-- بج هویت -->
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 text-textMain dark:text-slate-200 text-xs sm:text-sm font-bold shadow-sm border border-gray-200 dark:border-slate-700 mb-6">
            <span class="w-2.5 h-2.5 rounded-full bg-accent animate-pulse"></span>
            <span>ارکستراسیون ایجنت‌های سازمانی | <a href="/services/mcp-automation" class="underline hover:text-accent">مشاهده لندینگ اصلی MCP</a></span>
        </div>

        <!-- تیتر اصلی H1 -->
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[2.5rem] font-black text-textMain dark:text-white leading-[1.35] sm:leading-[1.3] mb-6 max-w-4xl mx-auto">
            کنسول شبیه‌ساز هوش مصنوعی سازمانی؛ <br class="hidden sm:inline">
            <span class="text-accent dark:text-blue-400">
                مشاهده فرآیند درک، تصمیم‌گیری و اجرای ابزارهای MCP
            </span>
        </h1>

        <!-- ساب‌تیتر توضیحی -->
        <p class="text-base sm:text-lg text-slate-600 dark:text-slate-300 max-w-3xl mx-auto leading-relaxed mb-8 font-normal text-justify sm:text-center">
            دستور سازمانی خود را وارد کنید تا هوش مصنوعی بر بستر پروتکل Model Context Protocol، ابزار تخصصی مورد نیاز را فراخوانی کرده و خروجی ساختاریافته تحویل دهد.
        </p>

        <!-- برچسب‌ها -->
        <div class="flex flex-wrap items-center justify-center gap-3 mb-10 text-xs text-slate-700 dark:text-slate-300">
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-brain text-accent dark:text-blue-400"></i> مدل پردازش: Google Gemini
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-bolt text-amber-500"></i> زمان اجرا: بلادرنگ و آنی
            </span>
            <span class="px-3.5 py-1.5 rounded-xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 flex items-center gap-1.5 shadow-sm font-bold">
                <i class="fas fa-shield-alt text-emerald-500"></i> محیط کاملاً ایمن و ایزوله
            </span>
        </div>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بخش آزمایشگاه تعاملی (Playground)                                         -->
<!-- ========================================================================= -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pb-16">
    
    <!-- کارت فرم درخواست -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-xl p-6 sm:p-8 mb-8 transition-all">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-slate-700/80 pb-4 mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center font-black text-lg">
                    <i class="fas fa-flask"></i>
                </div>
                <div>
                    <h2 class="text-lg sm:text-xl font-black text-textMain dark:text-white">کادر نوشتن دستور شما</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">هر خواسته‌ای دارید به فارسی ساده بنویسید</p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                آماده پردازش
            </span>
        </div>

        <?php if (!empty($errorMessage)): ?>
            <div class="mb-6 p-4 rounded-2xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm flex items-center gap-3">
                <i class="fas fa-exclamation-triangle text-base"></i>
                <span><?= e($errorMessage) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/services/mcp-simulator#results" class="space-y-5">
            <div>
                <label for="user_command" class="block text-sm font-bold text-textMain dark:text-slate-200 mb-2">
                    دستور یا خواسته شما:
                </label>
                <div class="relative">
                    <textarea 
                        id="user_command" 
                        name="user_command" 
                        rows="3" 
                        required
                        placeholder="مثال: وضعیت سئو، سرعت و متاتگ‌های سایت maaadmr.ir رو بررسی کن..."
                        class="w-full px-4 py-3.5 rounded-2xl bg-slate-50 dark:bg-slate-900/80 border border-gray-200 dark:border-slate-700 text-textMain dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-sm leading-relaxed transition-all resize-y font-medium"
                    ><?= e($userCommand ?? '') ?></textarea>
                </div>
            </div>

            <!-- نمونه‌های آماده -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">نمونه‌های آماده برای تست سریع (روی یکی کلیک کنید):</span>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="setCommand('وضعیت ریدایرکت‌ها، سرعت و تگ‌های H1 سایت https://digikala.com را خزش کن')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-300 text-xs font-medium border border-gray-200 dark:border-slate-600 transition-all text-right flex items-center gap-2">
                        <i class="fas fa-globe text-blue-500 text-xs"></i>
                        <span>بررسی و آنالیز سئوی سایت</span>
                    </button>
                    <button type="button" onclick="setCommand('کوئری دیتابیس برای بازیابی ۵ لید اخیر و پروژه‌های ثبت‌شده در جدول leads اجرا کن')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-300 text-xs font-medium border border-gray-200 dark:border-slate-600 transition-all text-right flex items-center gap-2">
                        <i class="fas fa-database text-amber-500 text-xs"></i>
                        <span>جستجو در اطلاعات دیتابیس</span>
                    </button>
                    <button type="button" onclick="setCommand('فورا یک پیام هشدار با فوریت بحرانی در مورد قطعی درگاه پرداخت به تلگرام ادمین بفرست')" class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700/60 hover:bg-blue-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-300 text-xs font-medium border border-gray-200 dark:border-slate-600 transition-all text-right flex items-center gap-2">
                        <i class="fab fa-telegram text-sky-500 text-xs"></i>
                        <span>ارسال پیام هشدار به تلگرام</span>
                    </button>
                </div>
            </div>

            <!-- دکمه ارسال -->
            <div class="pt-2 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                <div class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                    <i class="fas fa-info-circle text-accent dark:text-blue-400"></i>
                    <span>پاسخ مستقیم از طریق سرور بدون اتلاف وقت</span>
                </div>
                <button 
                    type="submit" 
                    id="submitBtn"
                    class="px-8 py-3.5 rounded-2xl bg-accent hover:bg-accentHover text-white font-bold text-sm sm:text-base shadow-lg hover:shadow-xl transition-all flex items-center justify-center gap-2"
                >
                    <i class="fas fa-paper-plane"></i>
                    <span>اجرا و مشاهده نتیجه</span>
                </button>
            </div>
        </form>
    </div>

    <!-- نتایج (Results Section) -->
    <?php if ($toolDecided !== null || !empty($executionLogs)): ?>
        <div id="results" class="scroll-mt-20 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-xl p-6 sm:p-8">
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-100 dark:border-slate-700/80 pb-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg font-bold">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-textMain dark:text-white">نتیجه بررسی و اجرای دستور</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">تحلیل درخواست شما در <?= number_format($latencyMs) ?> میلی‌ثانیه</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- ابزار انتخاب شده -->
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-2">ابزاری که فعال شد:</span>
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="font-bold text-base text-accent dark:text-blue-400">
                                <?php if ($toolDecided === 'web_scraper_tool'): ?>
                                    🔍 ابزار بررسی و اسکن وب‌سایت
                                <?php elseif ($toolDecided === 'database_query_tool'): ?>
                                    🗄️ ابزار جستجو در دیتابیس
                                <?php elseif ($toolDecided === 'telegram_notifier_tool'): ?>
                                    📢 ابزار ارسال پیام به تلگرام
                                <?php else: ?>
                                    <?= e($toolDecided) ?>
                                <?php endif; ?>
                            </span>
                        </div>
                        <p class="text-xs text-slate-600 dark:text-slate-400 mt-2">
                            <?php if ($toolDecided === 'web_scraper_tool'): ?>
                                صفحه وب مورد نظر باز شد و وضعیت کدهای فنی و سئو تحلیل گردید.
                            <?php elseif ($toolDecided === 'database_query_tool'): ?>
                                کوئری لازم در دیتابیس به صورت خودکار اجرا و اطلاعات مورد نظر خوانده شد.
                            <?php elseif ($toolDecided === 'telegram_notifier_tool'): ?>
                                پیام با موفقیت به ربات تلگرام تحویل داده شد.
                            <?php else: ?>
                                عملیات با موفقیت پایان یافت.
                            <?php endif; ?>
                        </p>
                    </div>

                    <!-- نتیجه نهایی -->
                    <div class="p-5 rounded-2xl bg-slate-50 dark:bg-slate-900/60 border border-gray-200 dark:border-slate-700">
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-2">گزارش کار:</span>
                        <p class="text-xs sm:text-sm font-medium text-textMain dark:text-slate-200 leading-relaxed">
                            <?= e($toolOutput ?? 'دستور با موفقیت اجرا شد.') ?>
                        </p>
                    </div>
                </div>

                <!-- مراحل اجرای فنی -->
                <div>
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300 block mb-2 flex items-center gap-2">
                        <i class="fas fa-list-check text-accent dark:text-blue-400"></i>
                        <span>مراحل گام‌به‌گام انجام کار:</span>
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

<!-- ========================================================================= -->
<!-- بخش معرفی ۳ ابزار آماده                                                  -->
<!-- ========================================================================= -->
<section class="max-w-6xl mx-auto px-4 sm:px-6 pb-16">
    <div class="text-center max-w-2xl mx-auto mb-10">
        <h2 class="text-2xl sm:text-3xl font-black text-textMain dark:text-white mb-3">
            ابزارهای متصل در این شبیه‌ساز
        </h2>
        <p class="text-sm text-slate-600 dark:text-slate-400">
            این ۳ ابزار نمونه‌هایی از امکاناتی هستند که می‌توان به هوش مصنوعی سازمان شما متصل کرد:
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Tool 1 -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-slate-700 text-blue-600 dark:text-blue-400 flex items-center justify-center text-xl font-bold mb-4">
                <i class="fas fa-globe"></i>
            </div>
            <h3 class="text-base font-black text-textMain dark:text-white mb-1">۱. ابزار بررسی سایت (Web Scraper)</h3>
            <span class="text-xs font-bold text-accent dark:text-blue-400 block mb-2">آنالیز سئو و خطاهای فنی</span>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                آدرس هر صفحه‌ای از وب‌سایت را که به آن بدهید، کدهای صفحه، تگ‌های سئو و سرعت لود را به صورت زنده استخراج و بررسی می‌کند.
            </p>
        </div>

        <!-- Tool 2 -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-slate-700 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl font-bold mb-4">
                <i class="fas fa-database"></i>
            </div>
            <h3 class="text-base font-black text-textMain dark:text-white mb-1">۲. ابزار دیتابیس (Database Tool)</h3>
            <span class="text-xs font-bold text-amber-600 dark:text-amber-400 block mb-2">جستجو در آمار و اطلاعات</span>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                بدون نیاز به کدنویسی SQL، اطلاعات پروژه‌ها، لیست مشتریان یا فروش‌ها را از دیتابیس می‌خواند و به صورت خلاصه به شما تحویل می‌دهد.
            </p>
        </div>

        <!-- Tool 3 -->
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 shadow-sm hover:shadow-md transition-all">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 dark:bg-slate-700 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xl font-bold mb-4">
                <i class="fab fa-telegram-plane"></i>
            </div>
            <h3 class="text-base font-black text-textMain dark:text-white mb-1">۳. ابزار تلگرام (Telegram Bot)</h3>
            <span class="text-xs font-bold text-sky-600 dark:text-sky-400 block mb-2">ارسال پیام و هشدارهای آنی</span>
            <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                در صورت وقوع اتفاقات مهم در سایت (مثل خطای سرور یا ثبت سفارش جدید)، پیام فوری به تلگرام شما ارسال می‌کند.
            </p>
        </div>

    </div>
</section>

<!-- ========================================================================= -->
<!-- بنر سناریوهای مدیریتی MCP                                                  -->
<!-- ========================================================================= -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pb-12">
    <div class="p-6 sm:p-8 rounded-3xl bg-slate-900 border border-slate-700/80 text-white shadow-xl flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-right">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 text-xs font-bold font-mono">
                <i class="fas fa-chart-line"></i> EXECUTIVE MCP SCENARIOS
            </div>
            <h3 class="text-lg sm:text-xl font-black">مشاهده شبیه‌ساز سناریوهای واقعی روز کاری مدیرعامل</h3>
            <p class="text-xs text-slate-300 max-w-xl">
                ببینید چطور با یک دستور ساده، گزارش حسابداری، آمار سئو و لیست تماس‌های CRM در ۳ ثانیه آماده می‌شود.
            </p>
        </div>
        <a href="/services/mcp-automation#mcp-executive-simulator" class="shrink-0 px-6 py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs sm:text-sm transition-all shadow-md flex items-center gap-2">
            <span>مشاهده شبیه‌ساز مدیرعامل</span>
            <i class="fas fa-arrow-left text-xs"></i>
        </a>
    </div>
</section>

<!-- ========================================================================= -->
<!-- بنر شروع همکاری                                                            -->
<!-- ========================================================================= -->
<section class="max-w-5xl mx-auto px-4 sm:px-6 pb-20">
    <div class="p-8 sm:p-10 rounded-3xl bg-gradient-to-r from-accent to-[#172554] text-white shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-center justify-between gap-6">
        <div class="space-y-2 text-center sm:text-right relative z-10">
            <h3 class="text-xl sm:text-2xl font-black">می‌خواهید چنین سیستمی را برای کسب‌وکارتان داشته باشید؟</h3>
            <p class="text-xs sm:text-sm text-blue-100 font-light max-w-xl">
                برای راه‌اندازی اتوماسیون سئو، اتصال هوش مصنوعی به سایت یا فروشگاه اینترنتی با من در ارتباط باشید.
            </p>
        </div>
        <div class="shrink-0 relative z-10">
            <a href="/contact" class="px-6 py-3.5 rounded-2xl bg-white text-accent hover:bg-slate-100 font-bold text-sm shadow-md transition-all inline-flex items-center gap-2">
                <i class="fas fa-comments"></i>
                <span>مشاوره و راه‌اندازی</span>
            </a>
        </div>
    </div>
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
