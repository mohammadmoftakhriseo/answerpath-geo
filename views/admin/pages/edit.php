<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl">
        <div class="flex items-center gap-3">
            <a href="/admin/pages" class="w-10 h-10 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 flex items-center justify-center transition">
                <i class="fas fa-arrow-right"></i>
            </a>
            <div>
                <h1 class="text-xl font-black text-white"><?= e($page['name']) ?></h1>
                <p class="text-xs text-slate-400 mt-0.5">آدرس صفحه: <span class="font-mono text-blue-400" dir="ltr"><?= e($page['url']) ?></span></p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="<?= e($page['url']) ?>" target="_blank" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded-xl text-xs font-bold transition flex items-center gap-1.5 border border-slate-700">
                <i class="fas fa-arrow-up-right-from-square"></i>
                مشاهده صفحه در سایت
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

    <!-- Form -->
    <form method="POST" action="/admin/pages/edit/<?= e($slug) ?>" class="space-y-6">
        <?= csrf_field() ?>

        <input type="hidden" name="name" value="<?= e($page['name']) ?>">

        <!-- کارت ۱: تنظیمات سئو و متادیتا (SEO & Meta Tags) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-sm font-black text-white flex items-center gap-2 border-b border-slate-800 pb-3">
                <i class="fas fa-magnifying-glass text-blue-400"></i>
                تنظیمات سئو و متادیتا (SEO & Meta Tags)
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">عنوان سئو (SEO Title / Tag &lt;title&gt;)</label>
                    <input type="text" name="seo_title" value="<?= e($page['seo_title'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                    <p class="text-[11px] text-slate-500 mt-1">تعداد کاراکتر پیشنهادی: ۵۰ تا ۶۵ کاراکتر</p>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">متا دیسکریپشن (Meta Description)</label>
                    <textarea name="meta_description" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500"><?= e($page['meta_description'] ?? '') ?></textarea>
                    <p class="text-[11px] text-slate-500 mt-1">تعداد کاراکتر پیشنهادی: ۱۲۰ تا ۱۶۰ کاراکتر برای نمایش کامل در سرپ گوگل</p>
                </div>
            </div>
        </div>

        <!-- کارت ۲: بخش اصلی هیرو و قلاب جذب (Hero Section) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-sm font-black text-white flex items-center gap-2 border-b border-slate-800 pb-3">
                <i class="fas fa-flag text-cyan-400"></i>
                بخش اصلی و قلاب جذب (Hero Section)
            </h2>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">تیتر اصلی صفحه (H1 Heading)</label>
                    <input type="text" name="h1_title" value="<?= e($page['h1_title'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">متن بج بالای تیتر (Top Badge Tag)</label>
                    <input type="text" name="badge_text" value="<?= e($page['badge_text'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">زیرتیتر توضیحی و مانیفست (Subtitle / Lead Paragraph)</label>
                    <textarea name="subtitle" rows="3" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500"><?= e($page['subtitle'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- کارت ۳: محتوای تکمیلی سفارشی (Custom Body Content / Rich Text) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-sm font-black text-white flex items-center gap-2 border-b border-slate-800 pb-3">
                <i class="fas fa-file-pen text-purple-400"></i>
                محتوای تکمیلی اختصاصی (Rich Text Editor)
            </h2>
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-1.5">متن و توضیحات تکمیلی صفحه (اختیاری):</label>
                <textarea name="content_html" class="tinymce-editor"><?= e($page['content_html'] ?? '') ?></textarea>
                <p class="text-[11px] text-slate-500 mt-1">می‌توانید توضیحات و هدینگ‌های سفارشی بیشتری را در این بخش قرار دهید.</p>
            </div>
        </div>

        <!-- کارت ۴: مدیریت سوالات متداول اختصاصی (FAQs Repeater) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <h2 class="text-sm font-black text-white flex items-center gap-2">
                    <i class="fas fa-circle-question text-amber-400"></i>
                    سوالات متداول اختصاصی صفحه (FAQs & JSON-LD)
                </h2>
                <button type="button" id="add-faq-btn" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-amber-400 border border-amber-500/20 text-xs font-bold flex items-center gap-1 transition">
                    <i class="fas fa-plus text-[10px]"></i>
                    افزودن سوال جدید
                </button>
            </div>

            <div id="faq-container" class="space-y-4">
                <?php if (!empty($faqs)): ?>
                    <?php foreach ($faqs as $index => $faq): ?>
                        <div class="faq-item p-4 rounded-xl bg-slate-800/60 border border-slate-700/80 space-y-3 relative group">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-amber-400 flex items-center gap-1.5">
                                    <i class="fas fa-question-circle text-[11px]"></i>
                                    پرسش متداول
                                </span>
                                <button type="button" class="remove-faq-btn text-rose-400 hover:text-rose-300 text-xs font-bold px-2 py-1 rounded bg-rose-500/10 transition">
                                    <i class="fas fa-trash-can text-[10px]"></i> حذف
                                </button>
                            </div>
                            <div>
                                <input type="text" name="faq_questions[]" value="<?= e($faq['question'] ?? '') ?>" placeholder="متن پرسش را وارد کنید..." class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-amber-500">
                            </div>
                            <div>
                                <textarea name="faq_answers[]" rows="2" placeholder="پاسخ کامل و شفاف سئو..." class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-amber-500"><?= e($faq['answer'] ?? '') ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p id="no-faq-text" class="text-xs text-slate-500 py-2">هیچ سوال متداولی تعریف نشده است. برای اضافه کردن روی دکمه بالا کلیک کنید.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- کارت ۵: باکس فراخوان اقدام به عمل (Call to Action) -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-6 space-y-4">
            <h2 class="text-sm font-black text-white flex items-center gap-2 border-b border-slate-800 pb-3">
                <i class="fas fa-bullhorn text-emerald-400"></i>
                باکس فراخوان نهایی (CTA Box)
            </h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">تیتر دعوت به همکاری</label>
                    <input type="text" name="cta_title" value="<?= e($page['cta_title'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-300 mb-1.5">متن روی دکمه اصلی</label>
                    <input type="text" name="cta_button" value="<?= e($page['cta_button'] ?? '') ?>" class="w-full px-4 py-2.5 rounded-xl bg-slate-800/80 border border-slate-700 text-white text-xs focus:outline-none focus:border-blue-500">
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="/admin/pages" class="px-6 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 text-xs font-bold transition">
                انصراف
            </a>
            <button type="submit" class="px-8 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-bold transition shadow-lg flex items-center gap-2">
                <i class="fas fa-save"></i>
                <span>ذخیره تغییرات صفحه</span>
            </button>
        </div>
    </form>
</div>

<script>
    // FAQ Dynamic Repeater Logic
    document.addEventListener('DOMContentLoaded', function() {
        const addBtn = document.getElementById('add-faq-btn');
        const container = document.getElementById('faq-container');
        const noFaqText = document.getElementById('no-faq-text');

        if (addBtn && container) {
            addBtn.addEventListener('click', function() {
                if (noFaqText) noFaqText.style.display = 'none';

                const item = document.createElement('div');
                item.className = 'faq-item p-4 rounded-xl bg-slate-800/60 border border-slate-700/80 space-y-3 relative group';
                item.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-400 flex items-center gap-1.5">
                            <i class="fas fa-question-circle text-[11px]"></i>
                            پرسش متداول جدید
                        </span>
                        <button type="button" class="remove-faq-btn text-rose-400 hover:text-rose-300 text-xs font-bold px-2 py-1 rounded bg-rose-500/10 transition">
                            <i class="fas fa-trash-can text-[10px]"></i> حذف
                        </button>
                    </div>
                    <div>
                        <input type="text" name="faq_questions[]" placeholder="متن پرسش را وارد کنید..." class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-amber-500">
                    </div>
                    <div>
                        <textarea name="faq_answers[]" rows="2" placeholder="پاسخ کامل و شفاف سئو..." class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white text-xs focus:outline-none focus:border-amber-500"></textarea>
                    </div>
                `;
                container.appendChild(item);
            });

            container.addEventListener('click', function(e) {
                if (e.target.closest('.remove-faq-btn')) {
                    const item = e.target.closest('.faq-item');
                    if (item) item.remove();
                }
            });
        }
    });
</script>
