<div class="space-y-6 max-w-5xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-slate-900 border border-slate-800 p-6 rounded-2xl shadow-sm">
        <div>
            <h1 class="text-xl font-black text-white flex items-center gap-2">
                <i class="fas fa-magic text-blue-400"></i>
                ماشین تولید محتوای هوش مصنوعی
            </h1>
            <p class="text-xs text-slate-400 mt-1">
                استودیو هوشمند تولید محتوای لینکدین و نگارش مقالات سئومحور با Google Gemini.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1.5 rounded-xl bg-blue-500/10 border border-blue-500/20 text-blue-400 text-xs font-bold flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-blue-400 animate-pulse"></span>
                <span>Gemini Flash Active</span>
            </span>
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

    <!-- ========================================================================= -->
    <!-- بخش اختصاصی: ماشین استراتژیست تولید محتوای لینکدین (LinkedIn Content Engine) -->
    <!-- ========================================================================= -->
    <div id="linkedin" class="bg-gradient-to-br from-slate-900 via-[#0a152e] to-slate-950 border border-blue-900/40 rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <!-- نور پس‌زمینه -->
        <div class="absolute -top-24 -left-24 w-60 h-60 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-[#0A66C2]/20 border border-[#0A66C2]/40 text-[#0A66C2] flex items-center justify-center text-xl font-bold">
                        <i class="fab fa-linkedin-in"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-white">استراتژیست تولید محتوای لینکدین</h2>
                        <p class="text-xs text-slate-400 mt-0.5">تبدیل ایده‌های خام به پست‌های وایرال و الگوریتمی لینکدین</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#0A66C2]/15 text-[#0A66C2] text-xs font-bold border border-[#0A66C2]/30 self-start sm:self-auto">
                    <i class="fas fa-bolt text-[10px]"></i>
                    System Instruction Active
                </span>
            </div>

            <!-- ۵ قانون الگوریتمی لینکدین -->
            <div class="grid grid-cols-2 sm:grid-cols-5 gap-2.5 text-[11px] text-slate-300">
                <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60">
                    <div class="text-[#0A66C2] font-black mb-0.5">۱. قلاب (Hook)</div>
                    <div class="text-slate-400 text-[10px]">۲ خط اول میخکوب‌کننده برای کلیک روی See more</div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60">
                    <div class="text-[#0A66C2] font-black mb-0.5">۲. بدنه بولت‌پوینت</div>
                    <div class="text-slate-400 text-[10px]">پاراگراف‌های حداکثر ۲ خطی با ایموجی مینیمال</div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60">
                    <div class="text-[#0A66C2] font-black mb-0.5">۳. لحن داستان‌گو</div>
                    <div class="text-slate-400 text-[10px]">اول‌شخص، تجربی و ساده‌سازی تخصصی</div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60">
                    <div class="text-[#0A66C2] font-black mb-0.5">۴. دعوت به اقدام (CTA)</div>
                    <div class="text-slate-400 text-[10px]">سوال چالشی در انتها برای دریافت کامنت</div>
                </div>
                <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60 col-span-2 sm:col-span-1">
                    <div class="text-[#0A66C2] font-black mb-0.5">۵. دقیقاً ۵ هشتگ</div>
                    <div class="text-slate-400 text-[10px]">ترکیب هدفمند انگلیسی و فارسی</div>
                </div>
            </div>

            <!-- فرم دریافت ایده خام -->
            <form action="/admin/ai-writer/linkedin" method="POST" id="linkedin-form" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="linkedin_idea" class="block text-xs font-bold text-slate-300 mb-2">
                        ایده خام، چالش کاری، تجربه یا موضوع پست:
                    </label>
                    <textarea 
                        id="linkedin_idea" 
                        name="idea" 
                        rows="3" 
                        required
                        placeholder="مثال: دیروز متوجه شدم ۸۰ درصد کسب‌وکارها هنوز با روش‌های ۵ سال پیش سئو می‌کنند و هیچ برنامه‌ای برای هوش مصنوعی و GEO ندارند..."
                        class="w-full px-4 py-3 rounded-2xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 text-xs sm:text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-[#0A66C2] focus:border-transparent transition resize-y font-medium"
                    ><?= e($_SESSION['flash_linkedin_idea'] ?? '') ?></textarea>
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                        <i class="fas fa-info-circle text-[#0A66C2]"></i>
                        <span>پردازش مستقیم با پرامپت استراتژیست ارشد لینکدین</span>
                    </div>

                    <button 
                        type="submit" 
                        id="linkedin-btn"
                        class="px-6 py-3 rounded-xl bg-[#0A66C2] hover:bg-[#084e96] text-white font-bold text-xs sm:text-sm transition-all shadow-md flex items-center justify-center gap-2 active:scale-95"
                    >
                        <i class="fab fa-linkedin"></i>
                        <span>تولید پست حرفه‌ای لینکدین</span>
                    </button>
                </div>
            </form>

            <!-- کادر نمایش نتیجه پست تولید شده -->
            <?php if (!empty($_SESSION['flash_linkedin_post'])): ?>
                <div class="pt-5 border-t border-slate-800 space-y-3" id="linkedin-result">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-400 flex items-center gap-1.5">
                            <i class="fas fa-check-circle"></i>
                            پست آماده انتشار در لینکدین:
                        </span>
                        <button 
                            type="button" 
                            onclick="copyLinkedInPost()" 
                            id="copy-btn"
                            class="px-3.5 py-1.5 rounded-lg bg-emerald-600/20 hover:bg-emerald-600 text-emerald-300 hover:text-white text-xs font-bold transition flex items-center gap-1.5"
                        >
                            <i class="fas fa-copy"></i>
                            <span>کپی در کلیپ‌بورد</span>
                        </button>
                    </div>

                    <div class="relative">
                        <textarea 
                            id="generated_post_content" 
                            rows="12" 
                            readonly 
                            class="w-full p-4 rounded-2xl bg-slate-950 border border-slate-800 text-slate-200 text-xs sm:text-sm leading-relaxed font-normal focus:outline-none"
                        ><?= e($_SESSION['flash_linkedin_post']) ?></textarea>
                    </div>
                </div>
                <?php unset($_SESSION['flash_linkedin_post'], $_SESSION['flash_linkedin_idea']); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- ========================================================================= -->
    <!-- بخش اختصاصی: موتور تولید خودکار مقاله سئو شده و وبلاگ (Gemini + Pexels)    -->
    <!-- ========================================================================= -->
    <div id="blog-engine" class="bg-gradient-to-br from-slate-900 via-[#0d1b2a] to-slate-950 border border-emerald-900/40 rounded-3xl p-6 sm:p-8 shadow-xl relative overflow-hidden">
        <!-- نور پس‌زمینه -->
        <div class="absolute -top-24 -right-24 w-60 h-60 bg-emerald-600/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-800 pb-5">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-500/20 border border-emerald-500/40 text-emerald-400 flex items-center justify-center text-xl font-bold">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg font-black text-white">تولید مقاله سئو شده و بهینه‌سازی برای هوش مصنوعی (SEO & GEO)</h2>
                        <p class="text-xs text-slate-400 mt-0.5">ارکستراسیون پیشرفته Gemini + دریافت ۳ تصویر اختصاصی از Pexels (۱ تصویر شاخص + ۲ تصویر در بدنه)</p>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/15 text-emerald-400 text-xs font-bold border border-emerald-500/30 self-start sm:self-auto">
                    <i class="fas fa-images text-[10px]"></i>
                    GEO & 3 Pexels Images
                </span>
            </div>

            <!-- فرم تولید خودکار مقاله وبلاگ -->
            <form action="/admin/ai-writer/generate" method="POST" id="ai-blog-form" class="space-y-4">
                <?= csrf_field() ?>

                <div>
                    <label for="blog_topic" class="block text-xs font-bold text-slate-300 mb-2">
                        موضوع مقاله:
                    </label>
                    <input 
                        type="text" 
                        id="blog_topic" 
                        name="topic" 
                        required 
                        placeholder="مثال: راهنمای جامع سئوی تکنیکال برای وب‌سایت‌های پرسرعت در سال ۲۰۲۵" 
                        class="w-full px-4 py-3.5 rounded-2xl bg-slate-950/80 border border-slate-700/80 text-white placeholder-slate-500 text-xs sm:text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition font-medium" 
                    />
                </div>

                <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                    <div class="text-[11px] text-slate-400 flex items-center gap-1.5">
                        <i class="fas fa-shield-alt text-emerald-400"></i>
                        <span>شامل Direct Answer برای موتورهای پاسخ هوش مصنوعی + لینک‌سازی پیلار + ۳ تصویر Pexels</span>
                    </div>

                    <button 
                        type="submit" 
                        id="blog-submit-btn"
                        class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs sm:text-sm transition-all shadow-md flex items-center justify-center gap-2 active:scale-95"
                    >
                        <i class="fas fa-pen-nib"></i>
                        <span>تولید مقاله سئو و استخراج ۳ تصویر Pexels</span>
                    </button>
                </div>
            </form>

            <!-- نمایش نتیجه و پیش‌نمایش زنده مقاله تولید شده -->
            <?php if (!empty($_SESSION['flash_seo_article'])): 
                $seoArt = $_SESSION['flash_seo_article'];
            ?>
                <div class="pt-6 border-t border-slate-800 space-y-4" id="seo-article-result">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-950/60 p-4 rounded-2xl border border-slate-800">
                        <div>
                            <span class="text-xs font-bold text-emerald-400 flex items-center gap-1.5 mb-1">
                                <i class="fas fa-check-circle"></i>
                                پیش‌نمایش مقاله سئو و ۳ تصویر اختصاصی Pexels
                            </span>
                            <div class="text-sm font-black text-white"><?= e($seoArt['title'] ?? $seoArt['topic']) ?></div>
                            <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                <span class="text-[11px] text-slate-400">کلیدواژه‌های تصاویر:</span>
                                <?php 
                                $kws = $seoArt['keywords'] ?? (!empty($seoArt['keyword']) ? explode(',', (string)$seoArt['keyword']) : []);
                                foreach ($kws as $kw): 
                                ?>
                                    <span class="px-2 py-0.5 rounded-md bg-blue-500/20 text-blue-300 text-[10px] font-mono">[IMAGE: <?= e(trim($kw)) ?>]</span>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button 
                                type="button" 
                                onclick="copyArticleHtml()" 
                                id="copy-html-btn"
                                class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition flex items-center gap-1.5"
                            >
                                <i class="fas fa-code"></i>
                                <span>کپی HTML</span>
                            </button>
                            <?php if (!empty($seoArt['article_id'])): ?>
                                <a 
                                    href="/admin/articles/edit/<?= (int)$seoArt['article_id'] ?>" 
                                    target="_blank"
                                    class="px-3.5 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold transition flex items-center gap-1.5"
                                >
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>ویرایش در مقالات</span>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- کادر پیش‌نمایش مقاله -->
                    <div class="bg-slate-950 border border-slate-800/80 rounded-2xl p-6 text-slate-200 text-xs sm:text-sm leading-relaxed space-y-4">
                        <?= $seoArt['content_html'] ?>
                    </div>

                    <textarea id="raw_article_html_source" class="hidden"><?= htmlspecialchars($seoArt['content_html'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>
                <?php unset($_SESSION['flash_seo_article']); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- راهنما و پیش‌نویس‌های اخیر -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- تنظیمات کلید API -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
            <h3 class="text-xs font-black text-white mb-3 flex items-center gap-2">
                <i class="fas fa-key text-blue-400"></i>
                تنظیمات Google Gemini API
            </h3>
            <form action="/admin/ai-writer/save-key" method="POST" class="space-y-3">
                <?= csrf_field() ?>
                <div>
                    <input 
                        type="password" 
                        name="gemini_api_key" 
                        value="<?= e($apiKey) ?>" 
                        placeholder="کلید Gemini API..." 
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-800 border border-slate-700 text-white text-xs font-mono focus:outline-none focus:ring-1 focus:ring-blue-500"
                    />
                </div>
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-bold transition">
                    ذخیره کلید API
                </button>
            </form>
        </div>

        <!-- آخرین مقالات و پیش‌نویس‌ها -->
        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5">
            <h3 class="text-xs font-black text-white mb-3 flex items-center justify-between">
                <span>آخرین مقالات وبلاگ:</span>
                <a href="/admin/articles" class="text-blue-400 hover:underline text-[11px]">همه مقالات ←</a>
            </h3>
            <?php if (!empty($recentDrafts)): ?>
                <div class="space-y-2">
                    <?php foreach (array_slice($recentDrafts, 0, 4) as $d): ?>
                        <div class="p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/60 flex items-center justify-between gap-2">
                            <div class="text-xs font-bold text-white truncate"><?= e($d['title']) ?></div>
                            <a href="/admin/articles/edit/<?= (int)$d['id'] ?>" class="px-2.5 py-1 rounded-lg bg-blue-600/20 hover:bg-blue-600 text-blue-400 hover:text-white text-[11px] font-bold transition shrink-0">
                                ویرایش
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-xs text-slate-500 text-center py-2">هنوز مقاله‌ای در پیش‌نویس نیست.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<script>
// فرم پست لینکدین
document.getElementById('linkedin-form').addEventListener('submit', function() {
    const btn = document.getElementById('linkedin-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i> <span>در حال نگارش پست الگوریتمی لینکدین...</span>';
    btn.classList.add('opacity-75', 'cursor-not-allowed');
});

// فرم تولید خودکار مقاله وبلاگ (Gemini + Pexels)
document.getElementById('ai-blog-form').addEventListener('submit', function() {
    const btn = document.getElementById('blog-submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin text-sm"></i> <span>در حال نگارش سئو و دریافت تصویر از Pexels...</span>';
    btn.classList.add('opacity-75', 'cursor-not-allowed');
});

function copyLinkedInPost() {
    const post = document.getElementById('generated_post_content');
    if (!post) return;
    navigator.clipboard.writeText(post.value).then(() => {
        const copyBtn = document.getElementById('copy-btn');
        copyBtn.innerHTML = '<i class="fas fa-check"></i> <span>کپی شد!</span>';
        setTimeout(() => {
            copyBtn.innerHTML = '<i class="fas fa-copy"></i> <span>کپی در کلیپ‌بورد</span>';
        }, 2500);
    });
}

function copyArticleHtml() {
    const htmlSrc = document.getElementById('raw_article_html_source');
    if (!htmlSrc) return;
    navigator.clipboard.writeText(htmlSrc.value).then(() => {
        const btn = document.getElementById('copy-html-btn');
        btn.innerHTML = '<i class="fas fa-check"></i> <span>کپی شد!</span>';
        setTimeout(() => {
            btn.innerHTML = '<i class="fas fa-code"></i> <span>کپی HTML</span>';
        }, 2500);
    });
}
</script>
