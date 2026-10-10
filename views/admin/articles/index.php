<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-white">مدیریت مقالات و تقویم محتوایی</h1>
            <p class="text-xs text-slate-400 mt-1">مدیریت مقالات سئو، تکنیک‌های اسکیما، متادیتاها و وضعیت انتشار یا پیش‌نویس</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="/admin/ai-writer" class="px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-robot"></i>
                تولید مقاله با هوش مصنوعی
            </a>
            <a href="/admin/articles/create" class="px-4 py-2.5 bg-purple-600 hover:bg-purple-500 text-white rounded-xl text-xs font-bold transition flex items-center gap-1.5 shadow-md">
                <i class="fas fa-plus"></i>
                نوشتن مقاله دستی
            </a>
        </div>
    </div>

    <div class="bg-slate-900 border border-slate-800 rounded-2xl overflow-hidden shadow-sm">
        <table class="w-full text-right text-xs text-slate-300">
            <thead class="text-[11px] text-slate-400 bg-slate-800/60 uppercase">
                <tr>
                    <th class="p-4">عنوان مقاله</th>
                    <th class="p-4">نوع اسکیما</th>
                    <th class="p-4">زمان مطالعه</th>
                    <th class="p-4">تاریخ انتشار / زمان‌بندی</th>
                    <th class="p-4">وضعیت</th>
                    <th class="p-4">عملیات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800">
                <?php 
                $statusMap = [
                    'published' => ['label' => 'منتشرشده', 'class' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20'],
                    'draft'     => ['label' => 'پیش‌نویس (زمان‌بندی)', 'class' => 'bg-amber-500/10 text-amber-400 border-amber-500/20'],
                ];
                $schemaMap = [
                    'TechArticle' => 'تکنیکال و تخصصی',
                    'Article'     => 'مقاله سئو',
                    'BlogPosting' => 'پست وبلاگ',
                ];
                foreach ($articles as $art): 
                    $st = $statusMap[$art['status'] ?? 'draft'] ?? ['label' => $art['status'], 'class' => 'bg-slate-800 text-slate-300 border-slate-700'];
                    $sc = $schemaMap[$art['schema_type'] ?? 'Article'] ?? ($art['schema_type'] ?? 'تخصصی');
                ?>
                    <tr class="hover:bg-slate-800/40 transition">
                        <td class="p-4">
                            <span class="font-bold text-white block mb-1"><?= e($art['title']) ?></span>
                            <span class="text-[11px] text-slate-500 font-mono" dir="ltr">/article/<?= e($art['slug']) ?></span>
                        </td>
                        <td class="p-4 text-purple-300"><?= e($sc) ?></td>
                        <td class="p-4 text-slate-400 font-mono"><?= e($art['reading_time'] ?? 5) ?> دقیقه</td>
                        <td class="p-4 text-slate-400 font-mono text-[11px]"><?= e($art['published_at'] ?? $art['created_at'] ?? '-') ?></td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border <?= $st['class'] ?>">
                                <?= e($st['label']) ?>
                            </span>
                        </td>
                        <td class="p-4 flex items-center gap-2">
                            <a href="/article/<?= e($art['slug']) ?>" target="_blank" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-blue-400 font-bold transition" title="مشاهده در سایت">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="/admin/articles/edit/<?= e($art['id']) ?>" class="p-2 rounded-lg bg-slate-800 hover:bg-slate-700 text-purple-400 font-bold transition" title="ویرایش مقاله">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="/admin/articles/delete/<?= e($art['id']) ?>" onsubmit="return confirm('آیا از حذف این مقاله مطمئن هستید؟');">
                                <?= csrf_field() ?>
                                <button type="submit" class="p-2 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 font-bold transition" title="حذف">
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
