<!-- Smart SEO Roadmap & Lead Generation Section -->
<div class="py-8 sm:py-14 max-w-4xl mx-auto">
    
    <!-- Hero Header & Step Guide -->
    <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-10 px-2">
        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-500/10 dark:bg-blue-500/15 border border-blue-500/20 text-accent dark:text-blue-400 text-xs font-bold mb-3 shadow-sm">
            <span class="w-2 h-2 rounded-full bg-accent dark:bg-cyan-400 animate-ping"></span>
            <i class="fas fa-sparkles"></i>
            <span>تحلیل هوشمند با Google Gemini AI</span>
        </div>
        
        <h1 class="text-2xl sm:text-4xl font-black text-textMain dark:text-white tracking-tight mb-3 leading-tight">
            دریافت رایگان نقشه راه رشد سئو و فروش
        </h1>
        
        <p class="text-xs sm:text-sm text-gray-600 dark:text-slate-400 leading-relaxed">
            اطلاعات سایت خود را ثبت کنید تا هوش مصنوعی بلافاصله گلوگاه‌های کسب‌وکار شما را شناسایی کرده و پیش‌نویس نقشه راه ۳ فازی محمد مفتخری را برایتان تدوین کند.
        </p>

        <!-- 3-Step Flow Pills (Mobile Friendly) -->
        <div class="grid grid-cols-3 gap-2 mt-5 text-[11px] sm:text-xs font-bold text-gray-500 dark:text-slate-400">
            <div class="flex flex-col sm:flex-row items-center justify-center gap-1 p-2 rounded-xl bg-gray-100 dark:bg-slate-800/60 border border-gray-200 dark:border-slate-700/50 text-accent dark:text-blue-400">
                <span class="w-5 h-5 rounded-full bg-accent dark:bg-blue-600 text-white flex items-center justify-center text-[10px] font-black">۱</span>
                <span>ثبت چالش سایت</span>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-1 p-2 rounded-xl bg-gray-100 dark:bg-slate-800/60 border border-gray-200 dark:border-slate-700/50 text-accent dark:text-blue-400">
                <span class="w-5 h-5 rounded-full bg-accent dark:bg-blue-600 text-white flex items-center justify-center text-[10px] font-black">۲</span>
                <span>تحلیل هوش مصنوعی</span>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-1 p-2 rounded-xl bg-gray-100 dark:bg-slate-800/60 border border-gray-200 dark:border-slate-700/50 text-accent dark:text-blue-400">
                <span class="w-5 h-5 rounded-full bg-accent dark:bg-blue-600 text-white flex items-center justify-center text-[10px] font-black">۳</span>
                <span>دریافت نقشه راه</span>
            </div>
        </div>
    </div>

    <!-- Lead Form Card -->
    <div class="card rounded-3xl p-5 sm:p-8 md:p-10 mb-8 border border-gray-200 dark:border-slate-800 shadow-xl relative overflow-hidden">
        <form method="POST" action="/seo-roadmap" class="space-y-5" id="roadmapForm">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <!-- Name Input -->
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-bold text-textMain dark:text-slate-200 mb-2">
                        <i class="fas fa-user text-accent dark:text-blue-400 ml-1"></i>
                        نام و نام خانوادگی:
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           required 
                           value="<?= htmlspecialchars($name ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                           placeholder="مثال: محمد امینی" 
                           class="w-full px-4 py-3.5 sm:py-4 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-gray-400 dark:placeholder-slate-500 text-sm sm:text-base outline-none focus:border-accent dark:focus:border-blue-500 focus:ring-2 focus:ring-accent/20 dark:focus:ring-blue-500/30 transition">
                </div>

                <!-- Phone Input (Required) -->
                <div>
                    <label for="phone" class="block text-xs sm:text-sm font-bold text-textMain dark:text-slate-200 mb-2 flex items-center justify-between">
                        <span>
                            <i class="fas fa-phone text-accent dark:text-blue-400 ml-1"></i>
                            شماره موبایل:
                        </span>
                        <span class="text-[11px] text-accent dark:text-blue-400 font-bold">* جهت ارسال نقشه راه</span>
                    </label>
                    <input type="tel" 
                           id="phone" 
                           name="phone" 
                           required 
                           dir="ltr"
                           inputmode="tel"
                           value="<?= htmlspecialchars($phone ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                           placeholder="09123456789" 
                           class="w-full px-4 py-3.5 sm:py-4 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-gray-400 dark:placeholder-slate-500 text-sm sm:text-base outline-none focus:border-accent dark:focus:border-blue-500 focus:ring-2 focus:ring-accent/20 dark:focus:ring-blue-500/30 text-left transition font-mono">
                </div>
            </div>

            <!-- Website URL Input -->
            <div>
                <label for="website_url" class="block text-xs sm:text-sm font-bold text-textMain dark:text-slate-200 mb-2 flex items-center justify-between">
                    <span>
                        <i class="fas fa-globe text-accent dark:text-blue-400 ml-1"></i>
                        آدرس وب‌سایت:
                    </span>
                    <span class="text-[11px] text-gray-400 font-normal">اختیاری</span>
                </label>
                <input type="text" 
                       id="website_url" 
                       name="website_url" 
                       dir="ltr"
                       inputmode="url"
                       value="<?= htmlspecialchars($websiteUrl ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       placeholder="example.ir" 
                       class="w-full px-4 py-3.5 sm:py-4 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-gray-400 dark:placeholder-slate-500 text-sm sm:text-base outline-none focus:border-accent dark:focus:border-blue-500 focus:ring-2 focus:ring-accent/20 dark:focus:ring-blue-500/30 text-left transition font-mono">
            </div>

            <!-- Main Challenge & Quick Chips -->
            <div>
                <label for="challenge" class="block text-xs sm:text-sm font-bold text-textMain dark:text-slate-200 mb-2">
                    <i class="fas fa-bullseye text-accent dark:text-blue-400 ml-1"></i>
                    هدف یا چالش اصلی سایت شما:
                </label>

                <!-- Quick-Select Challenge Chips for Mobile -->
                <div class="mb-3">
                    <span class="block text-[11px] text-gray-500 dark:text-slate-400 mb-2">انتخاب سریع با یک لمس:</span>
                    <div class="flex flex-wrap gap-2">
                        <button type="button" onclick="selectChip(this, 'سایت ورودی و بازدید دارد اما نرخ فروش و تماس بسیار کم است.')" class="chip-btn px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs text-textMain dark:text-slate-300 border border-gray-300 dark:border-slate-700 transition active:scale-95 text-right">
                            💰 ترافیک دارم ولی فروش کمه
                        </button>
                        <button type="button" onclick="selectChip(this, 'رتبه‌های سایت در کلمات کلیدی اصلی اخیراً دچار افت شدید شده است.')" class="chip-btn px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs text-textMain dark:text-slate-300 border border-gray-300 dark:border-slate-700 transition active:scale-95 text-right">
                            📉 افت رتبه در گوگل
                        </button>
                        <button type="button" onclick="selectChip(this, 'سایت تازه راه‌اندازی شده و می‌خواهیم در سریع‌ترین زمان به صفحه اول گوگل برسیم.')" class="chip-btn px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs text-textMain dark:text-slate-300 border border-gray-300 dark:border-slate-700 transition active:scale-95 text-right">
                            🚀 سئو سایت نوپا و جدید
                        </button>
                        <button type="button" onclick="selectChip(this, 'نیاز به سئو محلی، ثبت در نقشه و جذب تماس تلفنی روزانه از شهر خودمان داریم.')" class="chip-btn px-3 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-xs text-textMain dark:text-slate-300 border border-gray-300 dark:border-slate-700 transition active:scale-95 text-right">
                            📍 سئو محلی و لید تلفنی
                        </button>
                    </div>
                </div>

                <textarea id="challenge" 
                          name="challenge" 
                          rows="3" 
                          required 
                          placeholder="یا چالش اختصاصی سایت خود را اینجا بنویسید..." 
                          class="w-full px-4 py-3.5 rounded-2xl bg-gray-50 dark:bg-slate-900 border border-gray-300 dark:border-slate-700 text-textMain dark:text-white placeholder-gray-400 dark:placeholder-slate-500 text-sm sm:text-base outline-none focus:border-accent dark:focus:border-blue-500 focus:ring-2 focus:ring-accent/20 dark:focus:ring-blue-500/30 transition leading-relaxed"><?= htmlspecialchars($challenge ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
            </div>

            <!-- Submit Button (Large & Touch-Friendly) -->
            <div class="pt-2">
                <button type="submit" 
                        id="submitRoadmapBtn" 
                        class="w-full py-4 px-6 rounded-2xl bg-accent dark:bg-blue-600 hover:bg-opacity-90 active:scale-[0.98] text-white font-black text-sm sm:text-base shadow-lg shadow-blue-900/20 hover:shadow-xl transition flex items-center justify-center gap-2.5 cursor-pointer interactive-scale">
                    <i class="fas fa-wand-magic-sparkles" id="btnIcon"></i>
                    <span id="btnText">دریافت نقشه راه اختصاصی</span>
                    <i class="fas fa-spinner fa-spin hidden" id="btnSpinner"></i>
                </button>
                <span class="block text-center text-[11px] text-gray-500 dark:text-slate-400 mt-2">
                    <i class="fas fa-lock ml-1 text-emerald-500"></i>
                    اطلاعات شما کاملاً محرمانه نزد محمد مفتخری محفوظ است.
                </span>
            </div>
        </form>
    </div>

    <!-- Alert Messages -->
    <?php if (!empty($warningMessage)): ?>
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-amber-50 dark:bg-amber-950/50 border border-amber-300 dark:border-amber-600/40 text-amber-900 dark:text-amber-200 text-xs sm:text-sm leading-relaxed flex items-start gap-3 shadow-md">
            <i class="fas fa-triangle-exclamation text-amber-500 text-lg mt-0.5 flex-shrink-0"></i>
            <div><?= htmlspecialchars($warningMessage, ENT_QUOTES, 'UTF-8') ?></div>
        </div>
    <?php endif; ?>

    <?php if (!empty($errorMessage)): ?>
        <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-rose-50 dark:bg-rose-950/50 border border-rose-300 dark:border-rose-600/40 text-rose-900 dark:text-rose-200 text-xs sm:text-sm leading-relaxed flex items-start gap-3 shadow-md">
            <i class="fas fa-circle-exclamation text-rose-500 text-lg mt-0.5 flex-shrink-0"></i>
            <div>
                <strong class="block font-black mb-1">خطا:</strong>
                <?= htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Generated Roadmap Result Container -->
    <?php if (!empty($roadmapResult)): ?>
        <div class="card rounded-3xl p-5 sm:p-8 md:p-10 border border-accent/30 dark:border-blue-500/40 shadow-2xl space-y-6 animate-fadeIn" id="resultContainer">
            
            <!-- Result Header -->
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-200 dark:border-white/10 pb-4 sm:pb-5">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-accent/10 dark:bg-blue-500/20 text-accent dark:text-blue-400 flex items-center justify-center text-lg sm:text-xl font-bold flex-shrink-0">
                        <i class="fas fa-map-location-dot"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-xl font-black text-textMain dark:text-white">
                            نقشه راه اختصاصی تدوین‌شده برای <span class="text-accent dark:text-blue-400"><?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?></span>
                        </h2>
                        <span class="text-xs text-gray-500 dark:text-slate-400">سایت هدف: <?= htmlspecialchars($websiteUrl ?: 'ثبت‌شده', ENT_QUOTES, 'UTF-8') ?></span>
                    </div>
                </div>

                <button type="button" onclick="copyRoadmap()" class="text-xs font-bold text-accent dark:text-blue-300 hover:underline flex items-center gap-1.5 px-3 py-2 rounded-xl bg-accent/10 dark:bg-blue-500/15 border border-accent/20 dark:border-blue-500/30 transition">
                    <i class="far fa-copy"></i>
                    <span id="copyBtnText">کپی متن نقشه راه</span>
                </button>
            </div>

            <!-- Content Area (Persian Optimized Typography) -->
            <div class="bg-gray-50 dark:bg-slate-900/90 p-5 sm:p-8 rounded-2xl border border-gray-200 dark:border-slate-800 text-sm sm:text-base text-textMain dark:text-slate-200 leading-relaxed space-y-4 font-sans" id="roadmapContent">
                <?php
                $renderedHtml = htmlspecialchars($roadmapResult, ENT_QUOTES, 'UTF-8');
                // Clean any trailing or leading excessive hash characters
                $renderedHtml = preg_replace('/^#{4,6}\s*(.+)$/m', '<h4 class="text-sm font-bold text-accent dark:text-blue-400 mt-3 mb-1 flex items-center gap-1.5"><i class="fas fa-angle-left text-xs"></i>$1</h4>', $renderedHtml);
                $renderedHtml = preg_replace('/^###\s*(.+)$/m', '<h3 class="text-base font-bold text-accent dark:text-cyan-300 mt-4 mb-2 flex items-center gap-2"><i class="fas fa-chevron-left text-xs"></i>$1</h3>', $renderedHtml);
                $renderedHtml = preg_replace('/^##\s*(.+)$/m', '<h2 class="text-lg font-black text-textMain dark:text-blue-400 mt-6 mb-3 pb-2 border-b border-gray-200 dark:border-slate-800 flex items-center gap-2"><i class="fas fa-layer-group text-sm text-accent dark:text-blue-400"></i>$1</h2>', $renderedHtml);
                $renderedHtml = preg_replace('/^#\s*(.+)$/m', '<h2 class="text-xl font-black text-textMain dark:text-white mt-4 mb-3">$1</h2>', $renderedHtml);
                $renderedHtml = preg_replace('/\*\*(.+?)\*\*/s', '<strong class="font-black text-textMain dark:text-white">$1</strong>', $renderedHtml);
                $renderedHtml = preg_replace('/^\s*[\*\-]\s+(.+)$/m', '<li class="mr-4 my-1 list-disc text-gray-700 dark:text-slate-300">$1</li>', $renderedHtml);
                $renderedHtml = preg_replace('/(<li.*<\/li>(\n|))+/s', '<ul class="my-2 space-y-1">$0</ul>', $renderedHtml);
                $renderedHtml = nl2br($renderedHtml);
                // Clean excessive linebreaks right after headers and list elements
                $renderedHtml = preg_replace('/(<\/h[1-4]>|<\/ul>)\s*<br\s*\/?>/i', '$1', $renderedHtml);
                echo $renderedHtml;
                ?>
            </div>

            <!-- Follow-up Notice & Direct Contact Actions -->
            <div class="p-5 rounded-2xl bg-accent/5 dark:bg-blue-600/10 border border-accent/20 dark:border-blue-500/30 text-textMain dark:text-slate-200 text-xs sm:text-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <i class="fas fa-phone-volume text-accent dark:text-blue-400 text-2xl flex-shrink-0"></i>
                    <div>
                        <strong class="block text-textMain dark:text-white font-bold mb-0.5">درخواست و گزارش شما ثبت شد</strong>
                        <span class="text-gray-600 dark:text-slate-300">محمد مفتخری به‌زودی با شماره <b dir="ltr" class="font-mono text-accent dark:text-blue-400 font-bold"><?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?></b> تماس خواهد گرفت تا جزئیات اجرای نقشه راه را بررسی کند.</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a href="tel:09302928001" class="flex-1 sm:flex-none text-center px-4 py-2.5 rounded-xl bg-accent dark:bg-blue-600 hover:bg-opacity-90 text-white text-xs font-bold shadow-md transition flex items-center justify-center gap-1.5">
                        <i class="fas fa-phone"></i>
                        <span>تماس فوری</span>
                    </a>
                    <a href="https://wa.me/989302928001" target="_blank" rel="noopener" class="flex-1 sm:flex-none text-center px-4 py-2.5 rounded-xl bg-[#25D366] hover:bg-opacity-90 text-white text-xs font-bold shadow-md transition flex items-center justify-center gap-1.5">
                        <i class="fab fa-whatsapp"></i>
                        <span>واتساپ</span>
                    </a>
                </div>
            </div>

        </div>
    <?php endif; ?>

</div>

<script>
    const form = document.getElementById('roadmapForm');
    const submitBtn = document.getElementById('submitRoadmapBtn');
    const btnText = document.getElementById('btnText');
    const btnIcon = document.getElementById('btnIcon');
    const btnSpinner = document.getElementById('btnSpinner');

    function selectChip(btn, text) {
        const textarea = document.getElementById('challenge');
        if (textarea) {
            textarea.value = text;
            textarea.focus();
            
            // Highlight selected chip
            document.querySelectorAll('.chip-btn').forEach(el => {
                el.classList.remove('ring-2', 'ring-accent', 'bg-accent/10', 'dark:bg-blue-500/20');
            });
            btn.classList.add('ring-2', 'ring-accent', 'bg-accent/10', 'dark:bg-blue-500/20');
        }
    }

    form?.addEventListener('submit', function() {
        submitBtn.disabled = true;
        submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
        btnText.innerText = 'در حال تحلیل چالش و تدوین نقشه راه هوشمند...';
        btnIcon.classList.add('hidden');
        btnSpinner.classList.remove('hidden');
    });

    function copyRoadmap() {
        const text = <?= json_encode($roadmapResult ?? '', JSON_UNESCAPED_UNICODE) ?>;
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            const btn = document.getElementById('copyBtnText');
            if (btn) {
                btn.innerText = 'کپی شد! ✓';
                setTimeout(() => { btn.innerText = 'کپی متن نقشه راه'; }, 2500);
            }
        });
    }
</script>