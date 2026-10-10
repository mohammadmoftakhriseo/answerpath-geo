<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-white">مدیریت لیدها، درخواست‌ها و بریف‌های سئو</h1>
            <p class="text-xs text-slate-400 mt-1">لیست تمام پیام‌های ثبت شده از طریق فرم بریف هوشمند و تماس مستقیم</p>
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <?php if (empty($leads)): ?>
            <div class="p-12 text-center text-slate-400 text-xs">
                هنوز درخواستی ثبت نشده است.
            </div>
        <?php else: ?>
            <?php
            $leadStatusMap = [
                'new' => ['جدید', 'bg-blue-500/10 text-blue-400 border-blue-500/20'],
                'contacted' => ['تماس گرفته شد', 'bg-amber-500/10 text-amber-400 border-amber-500/20'],
                'qualified' => ['مشتری بالقوه', 'bg-purple-500/10 text-purple-400 border-purple-500/20'],
                'closed' => ['بسته شده / قرارداد', 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
                'spam' => ['اسپم', 'bg-rose-500/10 text-rose-400 border-rose-500/20'],
            ];
            ?>
            <table class="w-full text-right text-xs text-slate-300">
                <thead class="text-[11px] text-slate-400 bg-slate-800/60 uppercase">
                    <tr>
                        <th class="p-4">نام و شماره تماس</th>
                        <th class="p-4">آدرس وب‌سایت</th>
                        <th class="p-4">نوع درخواست</th>
                        <th class="p-4">صفحه ثبت فرم</th>
                        <th class="p-4">منبع و UTM</th>
                        <th class="p-4">وضعیت</th>
                        <th class="p-4">تاریخ ثبت</th>
                        <th class="p-4">عملیات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php foreach ($leads as $lead): 
                        $page = $lead['current_page'] ?? '/';
                        $fullPageUrl = str_starts_with($page, 'http') ? $page : 'https://maaadmr.ir' . (str_starts_with($page, '/') ? $page : '/' . $page);
                        $stKey = $lead['status'] ?? 'new';
                        $stData = $leadStatusMap[$stKey] ?? [$stKey, 'bg-slate-700/60 text-slate-300 border-slate-600/40'];
                    ?>
                        <tr class="hover:bg-slate-800/40 transition">
                            <td class="p-4">
                                <span class="font-bold text-white block mb-0.5"><?= e($lead['full_name']) ?></span>
                                <a href="tel:<?= e($lead['phone']) ?>" class="font-mono text-blue-400 hover:underline inline-flex items-center gap-1" dir="ltr">
                                    <i class="fas fa-phone-alt text-[10px]"></i>
                                    <?= e($lead['phone']) ?>
                                </a>
                            </td>
                            <td class="p-4 font-mono text-slate-400" dir="ltr">
                                <?php if (!empty($lead['website_url']) && $lead['website_url'] !== '-'): 
                                    $webUrl = str_starts_with($lead['website_url'], 'http') ? $lead['website_url'] : 'https://' . $lead['website_url'];
                                ?>
                                    <a href="<?= e($webUrl) ?>" target="_blank" rel="noopener" class="text-blue-400 hover:text-blue-300 hover:underline flex items-center gap-1">
                                        <span><?= e($lead['website_url']) ?></span>
                                        <i class="fas fa-external-link-alt text-[9px]"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-500">-</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 text-slate-300">
                                <?php if (str_contains((string)$lead['service_requested'], 'ارزیابی')): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-500/10 text-amber-400 border border-amber-500/20 font-bold">
                                        <i class="fas fa-gauge-high text-xs"></i>
                                        <?= e($lead['service_requested']) ?>
                                    </span>
                                <?php elseif (str_contains((string)$lead['service_requested'], 'نقشه راه') || ($lead['source_cta'] ?? '') === 'seo_roadmap_ai'): ?>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-purple-500/10 text-purple-400 border border-purple-500/20 font-bold">
                                        <i class="fas fa-route text-xs"></i>
                                        <?= e($lead['service_requested']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="font-medium text-slate-200"><?= e($lead['service_requested']) ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4 font-mono text-[11px]">
                                <a href="<?= e($fullPageUrl) ?>" target="_blank" rel="noopener" class="text-blue-400 hover:text-blue-300 hover:underline inline-flex items-center gap-1 bg-slate-800/80 px-2.5 py-1 rounded-lg border border-slate-700/60" title="مشاهده صفحه">
                                    <i class="fas fa-link text-[10px]"></i>
                                    <span><?= e($page) ?></span>
                                </a>
                            </td>
                            <td class="p-4 text-[11px]">
                                <?php if (!empty($lead['utm_source']) || !empty($lead['utm_campaign'])): ?>
                                    <div class="space-y-0.5">
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-bold font-mono">
                                            <i class="fas fa-bullseye text-[9px]"></i>
                                            <?= e($lead['utm_source'] ?? 'custom') ?><?= !empty($lead['utm_medium']) ? ' / ' . e($lead['utm_medium']) : '' ?>
                                        </span>
                                        <?php if (!empty($lead['utm_campaign'])): ?>
                                            <span class="block text-[10px] text-slate-400 font-mono">
                                                کمپین: <?= e($lead['utm_campaign']) ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php elseif (!empty($lead['referrer'])): ?>
                                    <a href="<?= e($lead['referrer']) ?>" target="_blank" rel="noopener" class="text-sky-400 hover:underline font-mono text-[10px] flex items-center gap-1">
                                        <i class="fas fa-globe text-[9px]"></i>
                                        <?= e(parse_url($lead['referrer'], PHP_URL_HOST) ?: $lead['referrer']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-slate-400 text-[10px] bg-slate-800/60 px-2 py-0.5 rounded border border-slate-700/50">ورود مستقیم / ارگانیک</span>
                                <?php endif; ?>
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $stData[1] ?>">
                                    <?= e($stData[0]) ?>
                                </span>
                            </td>
                            <td class="p-4 text-slate-400 font-mono text-[11px]"><?= e($lead['created_at']) ?></td>
                            <td class="p-4 flex items-center gap-2">
                                <a href="/admin/leads/<?= e($lead['id']) ?>" class="p-2 rounded bg-slate-800 hover:bg-slate-700 text-blue-400 font-bold transition" title="مشاهده جزئیات کامل و ردیابی">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="/admin/leads/delete/<?= e($lead['id']) ?>" onsubmit="return confirm('آیا از حذف این لید مطمئن هستید؟');">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="p-2 rounded bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold transition" title="حذف لید">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>
