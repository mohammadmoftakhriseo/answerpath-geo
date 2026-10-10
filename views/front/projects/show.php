<?php
$metrics = json_decode($project['results_metrics'] ?? '{}', true) ?: [];
$labels = [
    'traffic_growth' => 'رشد ترافیک ارگانیک',
    'lcp_speed' => 'بهبود سرعت لود (LCP)',
    'keyword_top3' => 'کلمات کلیدی در Top 3',
    'conversion_rate' => 'افزایش نرخ تبدیل (CRO)',
    'sales_growth' => 'رشد مستقیم فروش',
    'call_rate' => 'افزایش نرخ تماس مستقیم',
    'local_leads' => 'سرنخ‌های سئو محلی',
    'rank_local_pack' => 'رتبه در لوکال پک گوگل',
    'top_keywords' => 'کلمات رتبه ۱ تا ۳',
    'registered_students' => 'افزایش ثبت‌نام آنلاین',
    'roi_boost' => 'بازگشت سرمایه (ROI)',
    'b2b_inquiries' => 'استعلام‌های تجاری B2B',
    'core_vital_score' => 'نمره Core Web Vitals',
    'rich_snippets' => 'پوشش ریچ اسنیپت'
];
?>

<div class="py-10 space-y-12 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-gray-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition">صفحه اصلی</a>
        <i class="fas fa-chevron-left text-[10px]"></i>
        <a href="/projects" class="hover:text-accent dark:hover:text-blue-400 transition">کیس‌استادی‌ها</a>
        <i class="fas fa-chevron-left text-[10px]"></i>
        <span class="text-textMain dark:text-white font-medium truncate max-w-xs"><?= e($project['title']) ?></span>
    </nav>

    <!-- Case Study Header -->
    <header class="space-y-6">
        <div class="flex flex-wrap items-center gap-3">
            <span class="px-3.5 py-1.5 rounded-full bg-blue-100 dark:bg-blue-950/60 text-accent dark:text-blue-400 font-bold text-xs border border-blue-200 dark:border-blue-800/80">
                <?= e($project['category']) ?>
            </span>
            <span class="px-3.5 py-1.5 rounded-full bg-gray-100 dark:bg-slate-800 text-gray-700 dark:text-slate-300 font-medium text-xs border border-transparent dark:border-slate-700">
                کارفرما / پروژه: <?= e($project['client_name']) ?>
            </span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-textMain dark:text-white leading-tight">
            <?= e($project['title']) ?>
        </h1>

        <p class="text-base sm:text-lg text-gray-700 dark:text-slate-200 leading-relaxed font-normal bg-blue-50/70 dark:bg-slate-800/90 border-r-4 border-accent dark:border-blue-500 p-4 rounded-xl shadow-sm">
            <?= e($project['short_summary']) ?>
        </p>
    </header>

    <!-- Metrics Cards (Data-Driven Highlights) -->
    <?php if (!empty($metrics)): ?>
        <section class="space-y-4">
            <h2 class="text-lg font-black text-textMain dark:text-white flex items-center gap-2">
                <i class="fas fa-chart-pie text-accent dark:text-blue-400"></i>
                شاخص‌های کلیدی عملکرد و نتایج ملموس (KPIs)
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php foreach ($metrics as $key => $val): ?>
                    <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-gray-200 dark:border-slate-700 p-5 shadow-sm text-center">
                        <span class="block text-2xl sm:text-3xl font-black text-accent dark:text-blue-400 mb-1"><?= e($val) ?></span>
                        <span class="block text-xs text-gray-600 dark:text-slate-300 font-medium">
                            <?= $labels[$key] ?? e($key) ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Deep Case Study Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <main class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-6 text-gray-700 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
                
                <?php if (!empty($project['featured_image'])): ?>
                    <!-- Search Console Performance Graph Image -->
                    <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 bg-slate-900 shadow-md">
                        <div class="p-3 bg-slate-900 border-b border-slate-800 flex items-center justify-between text-xs text-slate-300">
                            <span class="font-bold flex items-center gap-2">
                                <i class="fab fa-google text-blue-400"></i>
                                نمودار رشد سالانه سرچ کنسول گوگل (Search Console Performance)
                            </span>
                            <span class="px-2 py-0.5 rounded bg-blue-500/20 text-blue-300 text-[10px] font-mono">1-Year Comparison</span>
                        </div>
                        <img src="<?= e($project['featured_image']) ?>" 
                             alt="نمودار مقایسه یک‌ساله رشد سرچ کنسول سئو <?= e($project['client_name']) ?> - محمد مفتخری" 
                             class="w-full h-auto object-cover object-center hover:scale-[1.01] transition-transform duration-300 cursor-zoom-in"
                             loading="lazy">
                        <div class="p-3 bg-slate-950/80 text-[11px] text-slate-400 text-center">
                            گزارش مستند مقایسه سالانه رشد کلیک‌ها و ایمپرشن‌های ارگانیک در سرچ کنسول گوگل
                        </div>
                    </div>
                <?php endif; ?>

                <h2 class="text-xl font-black text-textMain dark:text-white border-b border-gray-100 dark:border-slate-800 pb-3 flex items-center gap-2">
                    <i class="fas fa-microscope text-accent dark:text-blue-400"></i>
                    شرح چالش‌ها و استراتژی‌های اجرایی
                </h2>
                <div class="prose prose-slate dark:prose-invert max-w-none space-y-4 text-gray-700 dark:text-slate-300 leading-relaxed text-sm sm:text-base prose-headings:font-black prose-headings:text-textMain dark:prose-headings:text-white prose-h2:text-xl sm:prose-h2:text-2xl prose-h3:text-lg sm:prose-h3:text-xl prose-h3:text-accent dark:prose-h3:text-blue-400 prose-p:mb-4 prose-p:dark:text-slate-300 prose-a:text-accent dark:prose-a:text-blue-400 prose-a:underline hover:prose-a:text-blue-700 prose-img:rounded-2xl prose-img:shadow-md prose-blockquote:border-r-4 prose-blockquote:border-accent prose-blockquote:bg-blue-50/50 dark:prose-blockquote:bg-slate-800/60 dark:prose-blockquote:text-slate-200 prose-blockquote:p-4 sm:prose-blockquote:p-6 prose-blockquote:rounded-r-2xl prose-blockquote:not-italic prose-ul:list-disc prose-ul:pr-6 prose-ol:list-decimal prose-ol:pr-6 prose-li:my-1.5 prose-table:w-full prose-table:border-collapse prose-th:bg-slate-100 dark:prose-th:bg-slate-800 dark:prose-th:text-white prose-th:p-3 prose-td:p-3 prose-td:border prose-td:border-gray-200 dark:prose-td:border-slate-700 dark:prose-td:text-slate-300">
                    <?php
                    $rawProjDesc = $project['description'] ?? '';
                    if (strip_tags($rawProjDesc) !== $rawProjDesc) {
                        echo $rawProjDesc;
                    } else {
                        echo nl2br(e($rawProjDesc));
                    }
                    ?>
                </div>

                <!-- Technical Actions Breakdown -->
                <div class="pt-6 border-t border-gray-100 dark:border-slate-800 space-y-4">
                    <h3 class="text-base font-bold text-textMain dark:text-white flex items-center gap-2">
                        <i class="fas fa-screwdriver-wrench text-blue-600 dark:text-blue-400"></i>
                        اقدامات تکنیکال و معماری پیاده‌سازی شده
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl space-y-1">
                            <span class="font-bold text-textMain dark:text-white block"><i class="fas fa-gauge-high text-accent dark:text-blue-400 ml-1"></i> بهینه‌سازی Core Web Vitals</span>
                            <span class="text-gray-500 dark:text-slate-400">کاهش زمان پاسخ سرور (TTFB)، لیزی‌لود استراتژیک تصاویر و بهینه‌سازی بارگذاری فونت‌ها.</span>
                        </div>
                        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl space-y-1">
                            <span class="font-bold text-textMain dark:text-white block"><i class="fas fa-sitemap text-accent dark:text-blue-400 ml-1"></i> اصلاح معماری سیلوی محتوایی</span>
                            <span class="text-gray-500 dark:text-slate-400">جلوگیری از کنیبالیزیشن (Keyword Cannibalization) و تقویت پیوندهای داخلی با انکر تکست‌های دقیق.</span>
                        </div>
                        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl space-y-1">
                            <span class="font-bold text-textMain dark:text-white block"><i class="fas fa-code text-accent dark:text-blue-400 ml-1"></i> اسکیماهای ساختاریافته (JSON-LD)</span>
                            <span class="text-gray-500 dark:text-slate-400">پیاده‌سازی متناسب اسکیماهای Organization، Product، Course و FAQPage جهت دریافت ریچ اسنیپت.</span>
                        </div>
                        <div class="p-3.5 bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 rounded-xl space-y-1">
                            <span class="font-bold text-textMain dark:text-white block"><i class="fas fa-brain text-accent dark:text-blue-400 ml-1"></i> آماده‌سازی برای GEO و AI Search</span>
                            <span class="text-gray-500 dark:text-slate-400">ساختاردهی پاسخ‌های شفاف برای قرارگیری در خلاصه‌های هوش مصنوعی گوگل و چت‌بات‌ها.</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Sidebar CTA & Contact -->
        <aside class="space-y-6">
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-2xl p-6 shadow-md space-y-4 border border-slate-700/60">
                <h3 class="text-lg font-bold">نیاز به تحلیل سئوی سایت خود دارید؟</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    می‌توانید برای دریافت ممیزی (Audit) اولیه تکنیکال و بررسی پتانسیل کلمات کلیدی کسب‌وکارتان، فرم بریف هوشمند را تکمیل نمایید.
                </p>
                <a href="/#smart-brief" class="block text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-xl transition text-xs shadow-md">
                    ثبت درخواست مشاوره و بررسی
                </a>
            </div>

            <!-- Quick Info Card -->
            <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm space-y-3 text-xs">
                <h4 class="font-bold text-textMain dark:text-white border-b border-gray-100 dark:border-slate-700 pb-2">اطلاعات پروژه</h4>
                <div class="flex justify-between py-1 text-gray-600 dark:text-slate-400">
                    <span>مشتری:</span>
                    <span class="font-bold text-textMain dark:text-slate-200"><?= e($project['client_name']) ?></span>
                </div>
                <div class="flex justify-between py-1 text-gray-600 dark:text-slate-400">
                    <span>دسته‌بندی:</span>
                    <span class="font-bold text-textMain dark:text-slate-200"><?= e($project['category']) ?></span>
                </div>
                <div class="flex justify-between py-1 text-gray-600 dark:text-slate-400">
                    <span>مدیریت و اجرا:</span>
                    <span class="font-bold text-accent dark:text-blue-400">محمد مفتخری</span>
                </div>
            </div>
        </aside>
    </div>
</div>
