<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-xl font-black text-white">نوشتن مقاله تخصصی سئو</h1>
        <a href="/admin/articles" class="text-xs text-slate-400 hover:text-white flex items-center gap-1">
            <i class="fas fa-arrow-right"></i>
            بازگشت به لیست
        </a>
    </div>

    <form method="POST" action="/admin/articles/create" enctype="multipart/form-data" class="bg-slate-900 border border-slate-800 rounded-2xl p-6 sm:p-8 space-y-6 text-xs text-slate-300">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="space-y-1.5">
                <label class="font-bold text-white block">عنوان نوشته (H1 مقاله) *</label>
                <input type="text" name="title" id="article_title" required placeholder="مثال: پیاده‌سازی اسکیماهای سفارشی JSON-LD" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 text-xs">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1.5">
                    <label class="font-bold text-white block">نوع اسکیما</label>
                    <select name="schema_type" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 text-xs">
                        <option value="TechArticle">TechArticle (تکنیکال)</option>
                        <option value="Article">Article (عمومی)</option>
                        <option value="BlogPosting">BlogPosting (وبلاگ)</option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="font-bold text-white block">زمان مطالعه (دقیقه)</label>
                    <input type="number" name="reading_time" value="6" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 font-mono text-xs">
                </div>
            </div>
        </div>

        <!-- Featured Image Box -->
        <div class="p-5 bg-slate-950/70 border border-slate-800 rounded-2xl space-y-4">
            <div class="flex items-center justify-between border-b border-slate-800 pb-2.5">
                <label class="font-bold text-white text-xs flex items-center gap-2">
                    <i class="fas fa-image text-purple-400"></i>
                    تصویر شاخص مقاله (Featured Image)
                </label>
                <span class="text-[11px] text-slate-400 font-mono">OpenGraph & Header Banner</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                <div class="space-y-3">
                    <div class="space-y-1">
                        <span class="text-[11px] text-slate-400 block">آدرس تصویر یا انتخاب مسیر:</span>
                        <input type="text" name="featured_image" id="featured_image_input" placeholder="/assets/images/custom-schema-json-ld.webp" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-2.5 text-white outline-none focus:border-purple-500 text-xs font-mono text-left" dir="ltr">
                    </div>

                    <div class="space-y-1">
                        <span class="text-[11px] text-slate-400 block">یا آپلود مستقیم تصویر از سیستم:</span>
                        <input type="file" name="featured_image_file" id="featured_image_file" accept="image/*" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-2 text-slate-400 text-xs file:mr-2 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-500 cursor-pointer">
                    </div>

                    <div class="pt-1">
                        <span class="text-[10px] text-slate-500 block mb-1.5">تصاویر پیشنهادی موجود در هاست:</span>
                        <div class="flex flex-wrap gap-1.5">
                            <button type="button" onclick="setPresetImg('/assets/images/custom-schema-json-ld.webp')" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded text-[10px] text-slate-300">اسکیما JSON-LD</button>
                            <button type="button" onclick="setPresetImg('/assets/images/optimizing-core-web-vitals.webp')" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded text-[10px] text-slate-300">Core Web Vitals</button>
                            <button type="button" onclick="setPresetImg('/assets/images/advanced-local-seo-techniques.webp')" class="px-2 py-1 bg-slate-800 hover:bg-slate-700 border border-slate-700 rounded text-[10px] text-slate-300">سئو محلی</button>
                        </div>
                    </div>
                </div>

                <!-- Preview Area -->
                <div class="space-y-1.5">
                    <span class="text-[11px] text-slate-400 block">پیش‌نمایش زنده تصویر شاخص:</span>
                    <div id="image_preview_box" class="w-full aspect-[2/1] rounded-xl border border-slate-700 bg-slate-900 overflow-hidden flex items-center justify-center text-slate-600 text-xs">
                        <img id="featured_img_preview" src="" alt="پیش‌نمایش" class="w-full h-full object-cover hidden">
                        <span id="no_img_placeholder"><i class="fas fa-image text-2xl mb-1 block text-center"></i>بدون تصویر شاخص</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Native Google SEO Snippet Box -->
        <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-5 sm:p-6 space-y-5">
            <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-blue-600/20 border border-blue-500/30 flex items-center justify-center text-blue-400 text-xs">
                        <i class="fab fa-google"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-xs flex items-center gap-2">
                            پیش‌نمایش و تنظیمات متاتگ‌های سئو
                            <span class="text-[10px] bg-blue-500/20 text-blue-300 px-2 py-0.5 rounded-full font-mono">Google SERP</span>
                        </h3>
                    </div>
                </div>
                <span class="text-[11px] text-slate-400 font-mono">Google Snippet</span>
            </div>

            <!-- Google Live Preview -->
            <div class="bg-[#202124] border border-[#3c4043] rounded-xl p-4 space-y-1.5 font-sans">
                <div class="flex items-center gap-2 text-[12px] text-[#bdc1c6] font-mono" dir="ltr">
                    <div class="w-4 h-4 rounded-full bg-blue-600 flex items-center justify-center text-white text-[9px] font-bold">M</div>
                    <span class="text-[#dadce0]">https://maaadmr.ir</span>
                    <span class="text-[#9aa0a6]">› article › <span id="serp_slug_preview" class="text-[#dadce0] font-medium">post-slug</span></span>
                </div>
                <div>
                    <h4 id="serp_title_preview" class="text-[#8ab4f8] text-base sm:text-lg font-medium leading-snug hover:underline cursor-pointer">
                        عنوان سئو نوشته | محمد مفتخری
                    </h4>
                </div>
                <p id="serp_desc_preview" class="text-[#bdc1c6] text-xs sm:text-sm leading-relaxed line-clamp-2">
                    توضیحات متای صفحه در نتایج سرچ گوگل برای جذب بیشترین نرخ کلیک (CTR) و رتبه ارگانیک...
                </p>
            </div>

            <!-- SEO Title -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="font-bold text-white text-xs">عنوان سئو (SEO Title)</label>
                    <div class="flex items-center gap-2 text-[11px] font-mono">
                        <span id="title_px_badge" class="text-slate-400">0px / 580px</span>
                        <span class="text-slate-600">•</span>
                        <span id="title_count_badge" class="font-bold text-slate-300">0 / 60</span>
                    </div>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div id="title_bar" class="h-full bg-red-500 transition-all duration-200" style="width: 0%;"></div>
                </div>
                <input type="text" name="seo_title" id="seo_title" placeholder="عنوان جذاب سئو جهت نمایش در گوگل..." class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 text-xs">
                <p class="text-[11px] text-slate-400">این چیزی است که وقتی این نوشته در نتایج جستجو نشان داده می‌شود، در خط اول ظاهر می‌شود.</p>
            </div>

            <!-- Permalink / Slug -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="font-bold text-white text-xs">پیوند یکتا (Slug / Permalink) *</label>
                    <span id="slug_count_badge" class="text-[11px] font-mono text-slate-400">0 / 75</span>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div id="slug_bar" class="h-full bg-emerald-500 transition-all duration-200" style="width: 0%;"></div>
                </div>
                <input type="text" name="slug" id="slug" required placeholder="custom-json-ld-schemas" dir="ltr" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 font-mono text-left text-xs">
                <p class="text-[11px] text-slate-400">این URL یونیک این صفحه است که در نتایج جستجو زیر عنوان نوشته نمایش داده می‌شود.</p>
            </div>

            <!-- Meta Description -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="font-bold text-white text-xs">توضیحات متا (Meta Description)</label>
                    <div class="flex items-center gap-2 text-[11px] font-mono">
                        <span id="desc_px_badge" class="text-slate-400">0px / 920px</span>
                        <span class="text-slate-600">•</span>
                        <span id="desc_count_badge" class="font-bold text-slate-300">0 / 160</span>
                    </div>
                </div>
                <div class="w-full bg-slate-800 rounded-full h-1.5 overflow-hidden">
                    <div id="desc_bar" class="h-full bg-red-500 transition-all duration-200" style="width: 0%;"></div>
                </div>
                <textarea name="seo_description" id="seo_description" rows="3" placeholder="توضیحات جذاب و ترغیب‌کننده برای افزایش نرخ کلیک (CTR) در نتایج سرچ گوگل..." class="w-full bg-slate-900 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 text-xs leading-relaxed"></textarea>
                <p class="text-[11px] text-slate-400">این توضیح کوتاه صفحه در نتایج جستجو است که به کاربر و ربات‌های جستجو دلیل کلیک را نشان می‌دهد.</p>
            </div>
        </div>

        <!-- Direct Answer Box -->
        <div class="p-4 bg-purple-950/20 border border-purple-800/40 rounded-xl space-y-1.5">
            <label class="font-bold text-purple-300 block text-xs flex items-center gap-1.5">
                <i class="fas fa-bolt text-yellow-400"></i>
                پاسخ سریع و مستقیم (Direct Answer برای AI Overview و Featured Snippet)
            </label>
            <textarea name="direct_answer" id="direct_answer" rows="3" placeholder="پاسخ مستقیم و چکیده در ۲ تا ۳ جمله صریح و بدون مقدمه..." class="w-full bg-slate-900 border border-purple-800/50 rounded-lg p-3 text-white outline-none focus:border-purple-400 text-xs leading-relaxed"></textarea>
        </div>

        <!-- Summary -->
        <div class="space-y-1.5">
            <label class="font-bold text-white block">خلاصه کارت مقاله (Archive Summary)</label>
            <textarea name="summary" id="summary" rows="2" placeholder="توضیح کوتاه ۱-۲ خطی برای نمایش در کارت‌های صفحه مقالات..." class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500"></textarea>
        </div>

        <!-- Dynamic FAQ Section Builder -->
        <div class="bg-slate-950/70 border border-slate-800 rounded-2xl p-5 sm:p-6 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-800 pb-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-emerald-600/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-xs">
                        <i class="fas fa-circle-question"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-xs flex items-center gap-2">
                            پرسش‌های متداول مقاله (FAQ & Schema)
                            <span class="text-[10px] bg-emerald-500/20 text-emerald-300 px-2 py-0.5 rounded-full font-mono">FAQPage Schema</span>
                        </h3>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" id="auto_faq_btn" class="px-3 py-1.5 rounded-xl bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-300 border border-emerald-500/30 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer" title="اسکن محتوای مقاله و استخراج هوشمند سوال و جواب‌ها">
                        <i class="fas fa-wand-magic-sparkles"></i>
                        <span>تولید خودکار از متن</span>
                    </button>
                    <button type="button" id="add_faq_btn" class="px-3 py-1.5 rounded-xl bg-purple-600/20 hover:bg-purple-600/30 text-purple-300 border border-purple-500/30 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fas fa-plus"></i>
                        <span>افزودن دستی</span>
                    </button>
                </div>
            </div>

            <div id="faq_container" class="space-y-3">
                <!-- Dynamically added FAQ items -->
            </div>
            <p class="text-[11px] text-slate-400">می‌توانید با دکمه <strong class="text-emerald-400">تولید خودکار از متن</strong> سوالات متداول را بر اساس تیترها و پاراگراف‌ها استخراج کنید یا به صورت دستی اضافه نمایید.</p>
        </div>

        <!-- Full Content Classic Editor -->
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <label class="font-bold text-white block flex items-center gap-2">
                    <i class="fas fa-pen-nib text-purple-400"></i>
                    <span>متن کامل مقاله *</span>
                </label>
                <div class="flex items-center gap-2 text-[11px] text-slate-400">
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-800 border border-slate-700 text-slate-300 font-medium">
                        <i class="fas fa-edit ml-1 text-purple-400"></i> ویرایشگر پیشرفته محتوا
                    </span>
                </div>
            </div>
            <textarea name="content" id="article_content" rows="15" class="tinymce-editor w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-white outline-none focus:border-purple-500 leading-loose" placeholder="محتوای جامع مقاله، تیترها، راهنماها و کدهای تکنیکال..."></textarea>
        </div>

        <script>
        function setPresetImg(path) {
            var input = document.getElementById('featured_image_input');
            input.value = path;
            updateImgPreview(path);
        }

        function updateImgPreview(src) {
            var img = document.getElementById('featured_img_preview');
            var placeholder = document.getElementById('no_img_placeholder');
            if (src && src.trim() !== '') {
                img.src = src;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            } else {
                img.src = '';
                img.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            var articleTitle = document.getElementById('article_title');
            var seoTitle = document.getElementById('seo_title');
            var slug = document.getElementById('slug');
            var seoDesc = document.getElementById('seo_description');
            var summary = document.getElementById('summary');
            var directAnswer = document.getElementById('direct_answer');
            var featuredImgInput = document.getElementById('featured_image_input');
            var featuredImgFile = document.getElementById('featured_image_file');

            var serpTitle = document.getElementById('serp_title_preview');
            var serpSlug = document.getElementById('serp_slug_preview');
            var serpDesc = document.getElementById('serp_desc_preview');

            var titleBar = document.getElementById('title_bar');
            var titleCountBadge = document.getElementById('title_count_badge');
            var titlePxBadge = document.getElementById('title_px_badge');

            var slugBar = document.getElementById('slug_bar');
            var slugCountBadge = document.getElementById('slug_count_badge');

            var descBar = document.getElementById('desc_bar');
            var descCountBadge = document.getElementById('desc_count_badge');
            var descPxBadge = document.getElementById('desc_px_badge');

            featuredImgInput.addEventListener('input', function() {
                updateImgPreview(this.value.trim());
            });

            featuredImgFile.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        updateImgPreview(e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            function updateTitle() {
                var val = seoTitle.value.trim() || articleTitle.value.trim() || 'عنوان سئو نوشته | محمد مفتخری';
                serpTitle.textContent = val;
                var len = seoTitle.value.length;
                var px = Math.round(len * 9.6);
                titleCountBadge.textContent = len + ' / 60';
                titlePxBadge.textContent = px + 'px / 580px';

                var pct = Math.min(100, Math.round((len / 60) * 100));
                titleBar.style.width = pct + '%';
                if (len >= 45 && len <= 62) {
                    titleBar.className = 'h-full bg-emerald-500 transition-all duration-200';
                } else if (len >= 30 && len < 45) {
                    titleBar.className = 'h-full bg-amber-500 transition-all duration-200';
                } else {
                    titleBar.className = 'h-full bg-red-500 transition-all duration-200';
                }
            }

            function updateSlug() {
                var val = slug.value.trim() || 'post-slug';
                serpSlug.textContent = val;
                var len = slug.value.length;
                slugCountBadge.textContent = len + ' / 75';
                var pct = Math.min(100, Math.round((len / 75) * 100));
                slugBar.style.width = pct + '%';
                if (len > 0 && len <= 60) {
                    slugBar.className = 'h-full bg-emerald-500 transition-all duration-200';
                } else if (len > 60 && len <= 75) {
                    slugBar.className = 'h-full bg-amber-500 transition-all duration-200';
                } else {
                    slugBar.className = 'h-full bg-red-500 transition-all duration-200';
                }
            }

            function updateDesc() {
                var val = seoDesc.value.trim() || summary.value.trim() || directAnswer.value.trim() || 'توضیحات متای صفحه در نتایج سرچ گوگل برای جذب بیشترین نرخ کلیک (CTR) و رتبه ارگانیک...';
                serpDesc.textContent = val;
                var len = seoDesc.value.length;
                var px = Math.round(len * 5.75);
                descCountBadge.textContent = len + ' / 160';
                descPxBadge.textContent = px + 'px / 920px';

                var pct = Math.min(100, Math.round((len / 160) * 100));
                descBar.style.width = pct + '%';
                if (len >= 120 && len <= 165) {
                    descBar.className = 'h-full bg-emerald-500 transition-all duration-200';
                } else if (len >= 75 && len < 120) {
                    descBar.className = 'h-full bg-amber-500 transition-all duration-200';
                } else {
                    descBar.className = 'h-full bg-red-500 transition-all duration-200';
                }
            }

            articleTitle.addEventListener('input', function() {
                if (!seoTitle.value) {
                    updateTitle();
                }
                if (!slug.value) {
                    slug.value = articleTitle.value.toLowerCase()
                        .replace(/[^\u0600-\u06FFa-zA-Z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-');
                    updateSlug();
                }
            });

            seoTitle.addEventListener('input', updateTitle);
            slug.addEventListener('input', updateSlug);
            seoDesc.addEventListener('input', updateDesc);
            summary.addEventListener('input', function() {
                if (!seoDesc.value) updateDesc();
            });
            directAnswer.addEventListener('input', function() {
                if (!seoDesc.value && !summary.value) updateDesc();
            });

            updateTitle();
            updateSlug();
            updateDesc();

            // FAQ Builder Logic
            var faqContainer = document.getElementById('faq_container');
            var addFaqBtn = document.getElementById('add_faq_btn');

            function createFaqItem(q, a) {
                var div = document.createElement('div');
                div.className = 'p-4 bg-slate-900 border border-slate-700/80 rounded-xl space-y-2.5 relative group';
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-slate-300 flex items-center gap-1.5">
                            <i class="fas fa-question text-purple-400"></i> پرسش و پاسخ
                        </span>
                        <button type="button" class="remove-faq-btn text-slate-500 hover:text-rose-400 p-1 transition cursor-pointer text-xs" title="حذف پرسش">
                            <i class="fas fa-trash-can"></i>
                        </button>
                    </div>
                    <input type="text" name="faq_questions[]" required placeholder="عنوان پرسش متداول (مثال: سئو تکنیکال چقدر زمان می‌برد؟)" value="${q ? q.replace(/"/g, '&quot;') : ''}" class="w-full bg-slate-800 border border-slate-700 rounded-lg p-2.5 text-white text-xs outline-none focus:border-purple-500">
                    <textarea name="faq_answers[]" rows="2" required placeholder="پاسخ صریح، کوتاه و شفاف به پرسش..." class="w-full bg-slate-800 border border-slate-700 rounded-lg p-2.5 text-white text-xs outline-none focus:border-purple-500 leading-relaxed">${a ? a : ''}</textarea>
                `;
                div.querySelector('.remove-faq-btn').addEventListener('click', function() {
                    div.remove();
                });
                faqContainer.appendChild(div);
            }

            addFaqBtn.addEventListener('click', function() {
                createFaqItem('', '');
            });

            var autoFaqBtn = document.getElementById('auto_faq_btn');
            function autoExtractFaqs() {
                var contentHtml = '';
                if (typeof tinymce !== 'undefined' && tinymce.get('article_content')) {
                    contentHtml = tinymce.get('article_content').getContent();
                } else {
                    contentHtml = document.getElementById('article_content').value;
                }

                var title = articleTitle.value.trim() || 'این مقاله';
                var directAns = directAnswer.value.trim() || summary.value.trim();

                var parser = new DOMParser();
                var doc = parser.parseFromString(contentHtml, 'text/html');
                var headings = doc.querySelectorAll('h2, h3, h4');
                var extracted = [];

                headings.forEach(function(h) {
                    var hText = (h.textContent || '').trim();
                    if (!hText || hText.length < 4) return;

                    var q = hText;
                    if (!q.includes('؟') && !q.includes('?')) {
                        if (/^(چرا|چگونه|آیا|نحوه|تفاوت|مراحل|راهنمای|دلایل|بهترین)/.test(q)) {
                            q += '؟';
                        } else if (/(چیست|چیه|کدام است|چگونه است)/.test(q)) {
                            q += '؟';
                        } else {
                            q = 'در رابطه با «' + q + '» چه نکاتی حائز اهمیت است؟';
                        }
                    }

                    var p = h.nextElementSibling;
                    var pText = '';
                    while (p && p.tagName !== 'P' && !/^H[1-6]$/.test(p.tagName)) {
                        p = p.nextElementSibling;
                    }
                    if (p && p.tagName === 'P') {
                        pText = (p.textContent || '').trim();
                    }

                    var a = pText ? (pText.length > 250 ? pText.substring(0, 250) + '...' : pText) : 'این مبحث یکی از محورهای اساسی این مقاله تخصصی است که در ساختار اجرایی سئو بررسی شده است.';

                    if (extracted.length < 4) {
                        extracted.push({ q: q, a: a });
                    }
                });

                if (extracted.length === 0) {
                    if (directAns) {
                        extracted.push({
                            q: 'مهم‌ترین نتیجه و پاسخ سریع در رابطه با ' + title + ' چیست؟',
                            a: directAns
                        });
                    }
                    var cleanText = doc.body.textContent.trim();
                    if (cleanText) {
                        extracted.push({
                            q: 'اجرای اصولی ' + title + ' چه تاثیری بر رشد سئوی وب‌سایت دارد؟',
                            a: cleanText.length > 220 ? cleanText.substring(0, 220) + '...' : cleanText
                        });
                    }
                }

                if (extracted.length > 0) {
                    faqContainer.innerHTML = '';
                    extracted.forEach(function(item) {
                        createFaqItem(item.q, item.a);
                    });
                }
            }

            autoFaqBtn.addEventListener('click', autoExtractFaqs);
        });
        </script>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-800">
            <a href="/admin/articles" class="px-5 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold transition">انصراف</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-500 text-white font-bold transition shadow-md">
                انتشار مقاله
            </button>
        </div>
    </form>
</div>
