<div class="space-y-8">
    <!-- Top Greeting & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl">
        <div>
            <h1 class="text-xl font-black text-white">خوش آمدید، محمد مفتخری 👋</h1>
            <p class="text-xs text-slate-400 mt-1">مدیریت پروژه‌ها، مقالات تخصصی سئو و بررسی لیدها و بریف‌های دریافتی</p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <a href="/admin/ai-writer" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-robot"></i>
                ماشین محتوا با AI
            </a>
            <a href="/admin/pages" class="px-4 py-2 bg-cyan-600 hover:bg-cyan-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-layer-group"></i>
                مدیریت پیلارها و صفحات
            </a>
            <a href="/admin/projects/create" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-plus"></i>
                افزودن نمونه‌کار
            </a>
            <a href="/admin/articles/create" class="px-4 py-2 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-pen"></i>
                نوشتن مقاله سئو
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400">لیدها و بریف‌های دریافتی</span>
                <span class="p-2.5 rounded-xl bg-emerald-500/10 text-emerald-400 text-lg"><i class="fas fa-comments"></i></span>
            </div>
            <p class="text-3xl font-black text-white font-mono"><?= $leadCount ?? 0 ?></p>
        </div>
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400">نمونه‌کارها و پروژه‌ها</span>
                <span class="p-2.5 rounded-xl bg-blue-500/10 text-blue-400 text-lg"><i class="fas fa-briefcase"></i></span>
            </div>
            <p class="text-3xl font-black text-white font-mono"><?= $projectCount ?? 0 ?></p>
        </div>
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400">مقالات منتشرشده وبلاگ</span>
                <span class="p-2.5 rounded-xl bg-purple-500/10 text-purple-400 text-lg"><i class="fas fa-newspaper"></i></span>
            </div>
            <p class="text-3xl font-black text-white font-mono"><?= $articleCount ?? 0 ?></p>
        </div>
        <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold text-slate-400">پرسش و پاسخ‌ها (FAQ)</span>
                <span class="p-2.5 rounded-xl bg-amber-500/10 text-amber-400 text-lg"><i class="fas fa-circle-question"></i></span>
            </div>
            <p class="text-3xl font-black text-white font-mono"><?= $faqCount ?? 0 ?></p>
        </div>
    </div>

    <!-- Recent Leads Section -->
    <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-base font-black text-white flex items-center gap-2">
                <i class="fas fa-clock-rotate-left text-blue-400"></i>
                آخرین بریف‌ها و پیام‌های دریافتی از سایت
            </h2>
            <a href="/admin/leads" class="text-xs text-blue-400 hover:text-blue-300 font-bold">مشاهده همه</a>
        </div>

        <?php if (empty($recentLeads)): ?>
            <div class="p-8 text-center text-slate-400 text-xs">
                هنوز پیامی ثبت نشده است.
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
            <div class="overflow-x-auto">
                <table class="w-full text-right text-xs text-slate-300">
                    <thead class="text-[11px] text-slate-400 bg-slate-800/60 uppercase">
                        <tr>
                            <th class="p-3.5 rounded-r-xl">نام و مشخصات</th>
                            <th class="p-3.5">شماره تماس</th>
                            <th class="p-3.5">آدرس سایت</th>
                            <th class="p-3.5">نوع درخواست</th>
                            <th class="p-3.5">وضعیت</th>
                            <th class="p-3.5">تاریخ ثبت</th>
                            <th class="p-3.5 rounded-l-xl">عملیات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800">
                        <?php foreach ($recentLeads as $lead): 
                            $stKey = $lead['status'] ?? 'new';
                            $stData = $leadStatusMap[$stKey] ?? [$stKey, 'bg-slate-700/60 text-slate-300 border-slate-600/40'];
                        ?>
                            <tr class="hover:bg-slate-800/40 transition">
                                <td class="p-3.5 font-bold text-white"><?= e($lead['full_name'] ?? 'بی‌نام') ?></td>
                                <td class="p-3.5 font-mono text-blue-400" dir="ltr"><?= e($lead['phone']) ?></td>
                                <td class="p-3.5 text-slate-400 font-mono" dir="ltr"><?= e($lead['website_url'] ?? '-') ?></td>
                                <td class="p-3.5 text-slate-300"><?= e($lead['service_requested'] ?? 'مشاوره سئو') ?></td>
                                <td class="p-3.5">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $stData[1] ?>">
                                        <?= e($stData[0]) ?>
                                    </span>
                                </td>
                                <td class="p-3.5 text-slate-400"><?= e($lead['created_at']) ?></td>
                                <td class="p-3.5">
                                    <a href="/admin/leads/<?= e($lead['id']) ?>" class="px-2.5 py-1 rounded bg-slate-800 hover:bg-slate-700 text-blue-400 font-bold transition">
                                        جزییات
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
