<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-black text-white">افزودن کیس‌استادی جدید</h1>
        <a href="/admin/projects" class="text-xs text-slate-400 hover:text-white flex items-center gap-1">
            <i class="fas fa-arrow-right"></i>
            بازگشت به لیست
        </a>
    </div>

    <form method="POST" action="/admin/projects/create" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 text-xs text-slate-300">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="font-bold text-white block">عنوان پروژه *</label>
                <input type="text" name="title" required placeholder="مثال: رشد ۳۲۰ درصدی ترافیک ارگانیک" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500">
            </div>
            <div class="space-y-1.5">
                <label class="font-bold text-white block">نامک یکتا (Slug) *</label>
                <input type="text" name="slug" required placeholder="example-seo-case-study" dir="ltr" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500 font-mono text-left">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="font-bold text-white block">نام مشتری / برند *</label>
                <input type="text" name="client_name" required placeholder="مثال: آژانس دیجیتال مارکتینگ اینتن" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500">
            </div>
            <div class="space-y-1.5">
                <label class="font-bold text-white block">دسته‌بندی تخصصی</label>
                <input type="text" name="category" value="سئو تکنیکال و معماری محتوا" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500">
            </div>
        </div>

        <!-- Metrics JSON fields -->
        <div class="p-4 bg-slate-800/60 border border-slate-700/60 rounded-xl space-y-3">
            <label class="font-bold text-blue-400 block text-xs">شاخص‌ها و اعداد کلیدی دستاوردها (KPIs)</label>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div>
                    <span class="text-[11px] text-slate-400 block mb-1">درصد رشد ترافیک</span>
                    <input type="text" name="metric_traffic" value="+280%" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white text-center font-mono">
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 block mb-1">سرعت لود (LCP)</span>
                    <input type="text" name="metric_lcp" value="1.2s" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white text-center font-mono">
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 block mb-1">کلمات صفحه اول</span>
                    <input type="text" name="metric_keywords" value="35+" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white text-center font-mono">
                </div>
                <div>
                    <span class="text-[11px] text-slate-400 block mb-1">افزایش نرخ تبدیل</span>
                    <input type="text" name="metric_conversion" value="+40%" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-2 text-white text-center font-mono">
                </div>
            </div>
        </div>

        <div class="space-y-1.5">
            <label class="font-bold text-white block">خلاصه مستقیم (برای هوش مصنوعی و اسنیپت) *</label>
            <textarea name="short_summary" rows="2" required placeholder="توضیح دو خطی از چالش و دستاورد کلیدی پروژه..." class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500"></textarea>
        </div>

        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label class="font-bold text-white block flex items-center gap-2">
                    <i class="fas fa-pen-nib text-blue-400"></i>
                    <span>شرح کامل کیس‌استادی و اقدامات فنی *</span>
                </label>
                <div class="flex items-center gap-2 text-[11px] text-slate-400">
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-950/60 border border-blue-800/50 text-blue-300 font-medium">
                        <i class="fab fa-wordpress ml-1"></i> ویرایشگر کلاسیک و هوشمند
                    </span>
                </div>
            </div>
            <textarea name="description" id="project_description" rows="12" class="tinymce-editor w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-blue-500" placeholder="متن کامل روند پروژه، استراتژی کلمات کلیدی، بهینه‌سازی تکنیکال، حل مشکلات کنیبالیزیشن..."></textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="/admin/projects" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold transition">انصراف</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold transition shadow-md">
                ذخیره و انتشار پروژه
            </button>
        </div>
    </form>
</div>
