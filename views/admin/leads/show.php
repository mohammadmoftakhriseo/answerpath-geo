<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-black text-white">مشاهده جزییات لید و بریف</h1>
        <a href="/admin/leads" class="text-xs text-slate-400 hover:text-white flex items-center gap-1">
            <i class="fas fa-arrow-right"></i>
            بازگشت به لیست
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 text-xs text-slate-300">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-6 border-b border-slate-800">
            <div>
                <span class="text-slate-500 block mb-1">نام و نام خانوادگی:</span>
                <span class="text-base font-bold text-white"><?= e($lead['full_name']) ?></span>
            </div>
            <div>
                <span class="text-slate-500 block mb-1">شماره تماس:</span>
                <a href="tel:<?= e($lead['phone']) ?>" class="text-base font-bold text-blue-400 font-mono" dir="ltr"><?= e($lead['phone']) ?></a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-6 border-b border-slate-800">
            <div>
                <span class="text-slate-500 block mb-1">آدرس وب‌سایت:</span>
                <?php if (!empty($lead['website_url']) && $lead['website_url'] !== 'ثبت نشده'): 
                    $webUrl = str_starts_with($lead['website_url'], 'http') ? $lead['website_url'] : 'https://' . $lead['website_url'];
                ?>
                    <a href="<?= e($webUrl) ?>" target="_blank" rel="noopener" class="text-sm font-bold text-blue-400 font-mono hover:underline inline-flex items-center gap-1.5" dir="ltr">
                        <span><?= e($lead['website_url']) ?></span>
                        <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                <?php else: ?>
                    <span class="text-sm font-bold text-slate-400">ثبت نشده</span>
                <?php endif; ?>
            </div>
            <div>
                <span class="text-slate-500 block mb-1">نوع بیزینس / سرویس:</span>
                <span class="text-sm font-bold text-slate-200"><?= e($lead['service_requested']) ?></span>
                <?php if (($lead['source_cta'] ?? '') === 'seo_assessment_tool'): ?>
                    <span class="mt-1 inline-block px-2 py-0.5 rounded bg-amber-500/20 text-amber-300 text-[11px] font-bold">
                        <i class="fas fa-calculator ml-1"></i> ورودی از ابزار ماشین‌حساب و ارزیاب هوشمند سئو
                    </span>
                <?php elseif (($lead['source_cta'] ?? '') === 'seo_roadmap_ai'): ?>
                    <span class="mt-1 inline-block px-2.5 py-0.5 rounded bg-purple-500/20 text-purple-300 text-[11px] font-bold">
                        <i class="fas fa-sparkles ml-1"></i> ورودی از ابزار هوشمند تولید نقشه راه اختصاصی سئو (Gemini AI)
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- User Journey & UTM Tracker Card (ردیابی کاربر و منبع ورودی) -->
        <div class="p-5 rounded-2xl bg-slate-950/80 border border-slate-800 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800/80 pb-3">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="font-bold text-white text-xs">اطلاعات ردیابی کاربر، مسیر پیمایش و کمپین (User Tracker)</span>
                </div>
                <span class="text-[10px] text-slate-400 font-mono">Native PHP Session Tracker</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Current Page -->
                <div>
                    <span class="text-slate-500 block mb-1">📍 ثبت شده در صفحه (Target Page):</span>
                    <?php 
                        $curPage = $lead['current_page'] ?? '/';
                        $fullCurUrl = str_starts_with($curPage, 'http') ? $curPage : 'https://maaadmr.ir' . (str_starts_with($curPage, '/') ? $curPage : '/' . $curPage);
                    ?>
                    <a href="<?= e($fullCurUrl) ?>" target="_blank" rel="noopener" class="text-blue-400 hover:text-blue-300 hover:underline font-mono text-xs font-bold inline-flex items-center gap-1.5 bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-800">
                        <i class="fas fa-arrow-up-right-from-square text-[10px]"></i>
                        <span><?= e($curPage) ?></span>
                    </a>
                </div>

                <!-- Referrer -->
                <div>
                    <span class="text-slate-500 block mb-1">🔗 منبع ارجاع (Referrer URL):</span>
                    <?php if (!empty($lead['referrer'])): ?>
                        <a href="<?= e($lead['referrer']) ?>" target="_blank" rel="noopener" class="text-sky-400 hover:underline font-mono text-xs font-bold inline-flex items-center gap-1.5 bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-800 truncate max-w-full">
                            <i class="fas fa-globe text-[10px]"></i>
                            <span class="truncate"><?= e($lead['referrer']) ?></span>
                        </a>
                    <?php else: ?>
                        <span class="text-slate-400 font-mono text-xs bg-slate-900 px-3 py-1.5 rounded-xl border border-slate-800 inline-block">Direct / Organic</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- User Journey 3 Steps -->
            <div>
                <span class="text-slate-500 block mb-1.5">👣 مسیر کاربر در سایت (۳ قدم آخر - User Journey):</span>
                <?php 
                    $steps = !empty($lead['user_journey']) ? array_map('trim', explode('➔', (string)$lead['user_journey'])) : [$curPage];
                ?>
                <div class="flex flex-wrap items-center gap-2 pt-1 font-mono text-xs">
                    <?php foreach ($steps as $idx => $step): 
                        $stepUrl = str_starts_with($step, 'http') ? $step : 'https://maaadmr.ir' . (str_starts_with($step, '/') ? $step : '/' . $step);
                    ?>
                        <a href="<?= e($stepUrl) ?>" target="_blank" rel="noopener" class="px-3 py-1.5 rounded-xl bg-blue-950/60 text-blue-300 border border-blue-800/60 hover:bg-blue-900/60 hover:text-white transition flex items-center gap-1.5">
                            <span class="w-4 h-4 rounded-full bg-blue-600 text-white flex items-center justify-center text-[10px] font-bold"><?= $idx + 1 ?></span>
                            <span><?= e($step) ?></span>
                            <i class="fas fa-external-link-alt text-[9px] opacity-70"></i>
                        </a>
                        <?php if ($idx < count($steps) - 1): ?>
                            <span class="text-slate-600 font-bold">➔</span>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- UTM Parameters Grid -->
            <div class="pt-2 border-t border-slate-800/80">
                <span class="text-slate-500 block mb-2">🎯 پارامترهای کمپین ورودی (UTM Parameters):</span>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 font-mono text-xs">
                    <div class="bg-slate-900 p-2.5 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-500 block">utm_source</span>
                        <span class="font-bold <?= !empty($lead['utm_source']) ? 'text-emerald-400' : 'text-slate-500' ?>"><?= e($lead['utm_source'] ?? '(none)') ?></span>
                    </div>
                    <div class="bg-slate-900 p-2.5 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-500 block">utm_medium</span>
                        <span class="font-bold <?= !empty($lead['utm_medium']) ? 'text-emerald-400' : 'text-slate-500' ?>"><?= e($lead['utm_medium'] ?? '(none)') ?></span>
                    </div>
                    <div class="bg-slate-900 p-2.5 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-500 block">utm_campaign</span>
                        <span class="font-bold <?= !empty($lead['utm_campaign']) ? 'text-emerald-400' : 'text-slate-500' ?>"><?= e($lead['utm_campaign'] ?? '(none)') ?></span>
                    </div>
                    <div class="bg-slate-900 p-2.5 rounded-xl border border-slate-800">
                        <span class="text-[10px] text-slate-500 block">utm_term / content</span>
                        <span class="font-bold <?= (!empty($lead['utm_term']) || !empty($lead['utm_content'])) ? 'text-emerald-400' : 'text-slate-500' ?>"><?= e($lead['utm_term'] ?? ($lead['utm_content'] ?? '(none)')) ?></span>
                    </div>
                </div>
            </div>

            <!-- IP & User Agent -->
            <div class="pt-2 border-t border-slate-800/80 flex flex-wrap items-center justify-between text-[11px] text-slate-500 font-mono">
                <span>IP: <strong class="text-slate-400"><?= e($lead['ip_address'] ?? 'نامشخص') ?></strong></span>
                <span class="truncate max-w-sm" title="<?= e($lead['user_agent'] ?? '') ?>">Agent: <?= e(mb_substr((string)($lead['user_agent'] ?? ''), 0, 45)) ?>...</span>
            </div>
        </div>

        <?php if (!empty($lead['message'])): ?>
            <div class="pb-6 border-b border-slate-800 space-y-1">
                <span class="text-slate-500 block">
                    <?php if (($lead['source_cta'] ?? '') === 'seo_assessment_tool'): ?>
                        نتایج و تحلیل ارزیابی سئو کاربر:
                    <?php elseif (($lead['source_cta'] ?? '') === 'seo_roadmap_ai'): ?>
                        چالش مطرح‌شده و تحلیل نقشه راه هوش مصنوعی (Gemini):
                    <?php else: ?>
                        چالش یا هدف مطرح شده در بریف / پیام:
                    <?php endif; ?>
                </span>
                <div class="text-sm text-slate-200 bg-slate-800/90 border border-slate-700/60 p-4 rounded-xl leading-relaxed whitespace-pre-line font-mono text-xs">
                    <?= e($lead['message']) ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Status update form -->
        <form method="POST" action="/admin/leads/<?= e($lead['id']) ?>" class="space-y-4 pt-2">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="font-bold text-white block">تغییر وضعیت:</label>
                    <select name="status" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500">
                        <option value="new" <?= ($lead['status'] ?? '') === 'new' ? 'selected' : '' ?>>جدید (New)</option>
                        <option value="contacted" <?= ($lead['status'] ?? '') === 'contacted' ? 'selected' : '' ?>>تماس گرفته شد (Contacted)</option>
                        <option value="qualified" <?= ($lead['status'] ?? '') === 'qualified' ? 'selected' : '' ?>>مشتری بالقوه و تایید شده (Qualified)</option>
                        <option value="closed" <?= ($lead['status'] ?? '') === 'closed' ? 'selected' : '' ?>>بسته شده / قرارداد (Closed)</option>
                        <option value="spam" <?= ($lead['status'] ?? '') === 'spam' ? 'selected' : '' ?>>اسپم (Spam)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="font-bold text-white block">یادداشت ادمین (محرمانه):</label>
                    <input type="text" name="admin_notes" value="<?= e($lead['admin_notes'] ?? '') ?>" placeholder="مثال: توافق برای ارسال پروپوزال ممیزی سئو در روز یکشنبه" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow-md">
                    بروزرسانی وضعیت لید
                </button>
            </div>
        </form>
    </div>
</div>
