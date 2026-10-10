<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl">
        <div>
            <h1 class="text-xl font-black text-white flex items-center gap-2">
                <i class="fas fa-layer-group text-blue-400"></i>
                مدیریت پیلارها و صفحات سایت
            </h1>
            <p class="text-xs text-slate-400 mt-1">ویرایش داینامیک متادیتا، محتوا، تیترها و سوالات متداول ۵ پیلار تخصصی سئو و صفحات اصلی</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/admin/settings" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-700">
                <i class="fas fa-sliders text-blue-400"></i>
                تنظیمات عمومی سایت
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

    <!-- Pages & Pillars Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($pages as $slug => $page): ?>
            <div class="bg-slate-900 border border-slate-800 hover:border-slate-700 rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 group shadow-sm">
                <div>
                    <!-- Top Badge & Icon -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <span class="w-10 h-10 rounded-xl bg-slate-800 group-hover:bg-blue-600/20 text-blue-400 flex items-center justify-center text-base transition-colors">
                            <i class="fas <?= e($page['icon'] ?? 'fa-file-lines') ?>"></i>
                        </span>
                        <span class="px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-[11px] font-mono font-bold text-slate-300">
                            <?= e($page['badge'] ?? 'Page') ?>
                        </span>
                    </div>

                    <!-- Title -->
                    <h3 class="text-base font-black text-white group-hover:text-blue-400 transition-colors mb-2">
                        <?= e($page['name']) ?>
                    </h3>

                    <!-- Subtitle / Meta -->
                    <p class="text-xs text-slate-400 leading-relaxed mb-4 line-clamp-2">
                        <?= e($page['subtitle'] ?: $page['meta_description'] ?: 'بدون توضیحات مقدماتی') ?>
                    </p>

                    <!-- Slug Route -->
                    <div class="text-[11px] text-slate-500 font-mono mb-4 flex items-center gap-1.5" dir="ltr">
                        <i class="fas fa-link text-slate-600"></i>
                        <span><?= e($page['url']) ?></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-2">
                    <a href="/admin/pages/edit/<?= e($slug) ?>" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow-md">
                        <i class="fas fa-pen-to-square text-[11px]"></i>
                        <span>ویرایش محتوا و سئو</span>
                    </a>
                    <a href="<?= e($page['url']) ?>" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition">
                        <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                        <span>مشاهده زنده</span>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
