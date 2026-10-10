<div class="py-12 md:py-16 space-y-12">
    <!-- Header -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/80 text-accent dark:text-blue-400 text-xs font-bold">
            <svg class="w-3.5 h-3.5 fill-none stroke-current" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            نمونه‌کارها و نتایج واقعی
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-textMain dark:text-white tracking-tight">
            نمونه‌کارها و نتایج پروژه‌های سئو
        </h1>
        <p class="text-gray-600 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
            بررسی استراتژی‌ها، اقدامات فنی، تولید محتوا و رشد واقعی آمار ورودی گوگل و فروش در پروژه‌های مختلف.
        </p>
    </div>

    <!-- Projects Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($projects as $project): ?>
            <?php 
                $metrics = json_decode($project['results_metrics'] ?? '{}', true) ?: [];
            ?>
            <div class="bg-white dark:bg-slate-800/90 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold px-3 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-accent dark:text-blue-400 border border-blue-100 dark:border-blue-800/80">
                            <?= e($project['category'] ?? 'سئو تخصصی') ?>
                        </span>
                        <span class="text-xs text-gray-600 dark:text-slate-400 font-medium">
                            <?= e($project['client_name']) ?>
                        </span>
                    </div>

                    <?php if (!empty($project['featured_image'])): ?>
                        <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-slate-700 bg-slate-900 aspect-video relative group-hover:shadow-md transition">
                            <img src="<?= e($project['featured_image']) ?>" 
                                 alt="نمودار رشد سرچ کنسول سئو <?= e($project['client_name']) ?> - محمد مفتخری" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                    <h2 class="text-xl font-bold text-textMain dark:text-white group-hover:text-accent dark:group-hover:text-blue-400 transition leading-snug">
                        <a href="/project/<?= e($project['slug']) ?>">
                            <?= e($project['title']) ?>
                        </a>
                    </h2>

                    <p class="text-gray-600 dark:text-slate-300 text-sm leading-relaxed line-clamp-3">
                        <?= e($project['short_summary']) ?>
                    </p>

                    <!-- Metrics Badges -->
                    <?php if (!empty($metrics)): ?>
                        <div class="grid grid-cols-2 gap-2 pt-2">
                            <?php foreach (array_slice($metrics, 0, 2) as $key => $val): ?>
                                <div class="bg-slate-50 dark:bg-slate-900/80 border border-slate-100 dark:border-slate-700/80 rounded-xl p-2.5 text-center">
                                    <span class="block text-base font-black text-accent dark:text-blue-400"><?= e($val) ?></span>
                                    <span class="block text-[11px] text-gray-500 dark:text-slate-400 font-medium mt-0.5">
                                        <?php
                                            $labels = [
                                                'traffic_growth' => 'رشد ترافیک',
                                                'lcp_speed' => 'سرعت لود (LCP)',
                                                'keyword_top3' => 'کلمات صفحه ۱',
                                                'conversion_rate' => 'افزایش نرخ تبدیل',
                                                'sales_growth' => 'رشد فروش',
                                                'call_rate' => 'افزایش تماس',
                                                'local_leads' => 'سرنخ‌های محلی',
                                                'rank_local_pack' => 'رتبه گوگل مپ',
                                                'top_keywords' => 'کلمات کلیدی برتر',
                                                'registered_students' => 'ثبت‌نام آنلاین',
                                                'roi_boost' => 'رشد ROI',
                                                'b2b_inquiries' => 'استعلام B2B',
                                                'core_vital_score' => 'نمره وب وایتال'
                                            ];
                                            echo $labels[$key] ?? $key;
                                        ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700/80 mt-6 flex items-center justify-between">
                    <a href="/project/<?= e($project['slug']) ?>" class="text-xs font-bold text-accent dark:text-blue-400 flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                        مشاهده کیس‌استادی کامل
                        <i class="fas fa-arrow-left text-[10px]"></i>
                    </a>
                    <span class="w-8 h-8 rounded-full bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xs group-hover:bg-accent dark:group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- CTA Section -->
    <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-accent text-white rounded-3xl p-8 md:p-12 shadow-xl flex flex-col md:flex-row items-center justify-between gap-8 border border-slate-700/60">
        <div class="space-y-3 max-w-xl">
            <span class="text-xs font-bold tracking-wider text-blue-300 uppercase">مشاوره و استراتژی رشد</span>
            <h2 class="text-2xl sm:text-3xl font-black">می‌خواهید نتایج مشابهی در سرچ گوگل رقم بزنید؟</h2>
            <p class="text-slate-300 text-sm leading-relaxed">
                با بررسی دقیق وضعیت سایت فعلی و تحلیل رقبای حوزه شما، نقشه راه اختصاصی رشد ترافیک و فروش را ترسیم می‌کنیم.
            </p>
        </div>
        <a href="/#smart-brief" class="bg-blue-500 hover:bg-blue-600 text-white font-black px-8 py-4 rounded-xl shadow-lg hover:shadow-blue-500/25 transition whitespace-nowrap text-sm flex items-center gap-2">
            <i class="fas fa-file-signature"></i>
            تکمیل بریف هوشمند سئو
        </a>
    </div>
</div>
