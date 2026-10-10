<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-black text-white">مدیریت کیس‌استادی‌ها و پروژه‌ها</h1>
            <p class="text-xs text-slate-400 mt-1">لیست تمام کیس‌استادی‌های داده‌محور ثبت‌شده در وب‌سایت</p>
        </div>
        <a href="/admin/projects/create" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
            <i class="fas fa-plus"></i>
            افزودن کیس‌استادی جدید
        </a>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <?php
        $projectStatusMap = [
            'completed' => ['تکمیل شده', 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
            'in_progress' => ['در حال اجرا', 'bg-amber-500/10 text-amber-400 border-amber-500/20'],
            'published' => ['منتشر شده', 'bg-blue-500/10 text-blue-400 border-blue-500/20'],
            'draft' => ['پیش‌نویس', 'bg-slate-700/60 text-slate-300 border-slate-600/40'],
        ];
        ?>
        <table class="w-full text-right text-xs text-slate-300">
            <thead class="text-[11px] text-slate-400 bg-slate-800/60 uppercase">
                <tr>
                    <th class="p-4">عنوان پروژه</th>
                    <th class="p-4">کارفرما / برند</th>
                    <th class="p-4">دسته‌بندی</th>
                    <th class="p-4">وضعیت</th>
                    <th class="p-4">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                <?php foreach ($projects as $p): 
                    $stKey = $p['status'] ?? 'completed';
                    $stData = $projectStatusMap[$stKey] ?? [$stKey, 'bg-slate-700/60 text-slate-300 border-slate-600/40'];
                ?>
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="p-4 font-bold text-white"><?= e($p['title']) ?></td>
                        <td class="p-4 text-slate-300"><?= e($p['client_name']) ?></td>
                        <td class="p-4 text-slate-400"><?= e($p['category']) ?></td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $stData[1] ?>">
                                <?= e($stData[0]) ?>
                            </span>
                        </td>
                        <td class="p-4 flex items-center gap-2">
                            <a href="/admin/projects/edit/<?= e($p['id']) ?>" class="p-2 rounded bg-slate-800 hover:bg-slate-700 text-blue-400 font-bold transition" title="ویرایش پروژه">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="/admin/projects/delete/<?= e($p['id']) ?>" onsubmit="return confirm('آیا از حذف این پروژه مطمئن هستید؟');">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2 rounded bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold transition" title="حذف پروژه">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
