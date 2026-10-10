<?php
/**
 * View: front/start.php
 * صفحه اختصاصی رزرو مشاوره استراتژیک، استعلام پروژه و شروع همکاری
 * منطبق ۱۰۰٪ با هویت بصری، تم رنگی برند (سرمه‌ای سلطنتی، طوسی استخوانی، مشکی عمیق) و اصول UX/CRO
 */
?>

<!-- مسیر راهنما (Breadcrumb) -->
<div class="max-w-6xl mx-auto px-4 sm:px-6 pt-6">
    <nav aria-label="Breadcrumb" class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition-colors">خانه</a>
        <span class="text-slate-400 dark:text-slate-600">/</span>
        <span class="text-accent dark:text-blue-400 font-bold">شروع همکاری و رزرو مشاوره</span>
    </nav>
</div>

<section class="py-10 md:py-16 relative overflow-hidden">
    <!-- افکت‌های نوری ملایم و پس‌زمینه هماهنگ با برند -->
    <div class="absolute top-10 right-10 w-96 h-96 bg-blue-500/10 dark:bg-blue-600/10 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-600/10 rounded-full blur-[140px] pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 relative z-10 space-y-12">
        
        <!-- هدر صفحه -->
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-900 text-accent dark:text-blue-400 text-xs sm:text-sm font-bold shadow-sm backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-accent animate-pulse"></span>
                <span>همکاری و مشاوره استراتژیک سئو | محمد مفتخری</span>
            </div>
            
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                شروع همکاری و <span class="text-transparent bg-clip-text bg-gradient-to-r from-accent via-blue-600 to-indigo-600 dark:from-blue-400 dark:via-blue-300 dark:to-indigo-300">تحول ترافیک ارگانیک</span>
            </h1>
            
            <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto">
                جهت ممیزی فنی و سرعت وب‌سایت، تدوین استراتژی جامع سئو یا پیاده‌سازی اتوماسیون هوش مصنوعی، اطلاعات پروژه خود را وارد فرمایید تا در کوتاه‌ترین زمان بررسی و تماس حاصل شود.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- ستون فرم ثبت درخواست (7 ستون) -->
            <div class="lg:col-span-7 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-10 shadow-xl backdrop-blur-xl space-y-6">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h2 class="text-base sm:text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-file-signature text-accent dark:text-blue-400"></i>
                        <span>فرم درخواست مشاوره و ممیزی</span>
                    </h2>
                    <span class="text-[11px] font-bold text-accent dark:text-blue-400 bg-blue-50 dark:bg-blue-950/80 px-2.5 py-1 rounded-full border border-blue-100 dark:border-blue-900">
                        <i class="fas fa-clock text-[10px] ml-1"></i>پاسخگویی کمتر از ۲۴ ساعت
                    </span>
                </div>

                <form action="/lead/submit" method="POST" class="space-y-5">
                    <?= csrf_field() ?>
                    <input type="hidden" name="source" value="start_page" />

                    <!-- انتخاب حوزه مدنظر (UX Service Pills) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2.5">
                            موضوع یا حوزه اصلی همکاری را انتخاب کنید:
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="technical_seo" class="peer sr-only" checked>
                                <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950/70 text-xs font-bold text-slate-700 dark:text-slate-300 peer-checked:border-accent peer-checked:bg-blue-50/80 dark:peer-checked:bg-blue-950/50 peer-checked:text-accent dark:peer-checked:text-blue-400 text-center transition-all">
                                    <i class="fas fa-bolt ml-1"></i>سئوی تکنیکال و سرعت
                                </div>
                            </label>
                            
                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="seo_strategy" class="peer sr-only">
                                <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950/70 text-xs font-bold text-slate-700 dark:text-slate-300 peer-checked:border-accent peer-checked:bg-blue-50/80 dark:peer-checked:bg-blue-950/50 peer-checked:text-accent dark:peer-checked:text-blue-400 text-center transition-all">
                                    <i class="fas fa-compass ml-1"></i>استراتژی و مشاوره
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="ai_automation" class="peer sr-only">
                                <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950/70 text-xs font-bold text-slate-700 dark:text-slate-300 peer-checked:border-accent peer-checked:bg-blue-50/80 dark:peer-checked:bg-blue-950/50 peer-checked:text-accent dark:peer-checked:text-blue-400 text-center transition-all">
                                    <i class="fas fa-network-wired ml-1"></i>یکپارچه‌سازی و اتوماسیون MCP
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="landing_cro" class="peer sr-only">
                                <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950/70 text-xs font-bold text-slate-700 dark:text-slate-300 peer-checked:border-accent peer-checked:bg-blue-50/80 dark:peer-checked:bg-blue-950/50 peer-checked:text-accent dark:peer-checked:text-blue-400 text-center transition-all">
                                    <i class="fas fa-layer-group ml-1"></i>طراحی لندینگ و CRO
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="local_seo" class="peer sr-only">
                                <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950/70 text-xs font-bold text-slate-700 dark:text-slate-300 peer-checked:border-accent peer-checked:bg-blue-50/80 dark:peer-checked:bg-blue-950/50 peer-checked:text-accent dark:peer-checked:text-blue-400 text-center transition-all">
                                    <i class="fas fa-map-location-dot ml-1"></i>سئوی محلی و نقشه‌ها
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="service_type" value="custom_dev" class="peer sr-only">
                                <div class="px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-950/70 text-xs font-bold text-slate-700 dark:text-slate-300 peer-checked:border-accent peer-checked:bg-blue-50/80 dark:peer-checked:bg-blue-950/50 peer-checked:text-accent dark:peer-checked:text-blue-400 text-center transition-all">
                                    <i class="fas fa-code ml-1"></i>طراحی اختصاصی سایت
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- نام و نام خانوادگی -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                            نام و نام خانوادگی / عنوان کسب‌وکار <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" required placeholder="مثال: علی رضایی (مدیر فروشگاه...)" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all font-medium" />
                    </div>

                    <!-- تماس و وب‌سایت -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                شماره تماس مستقیم <span class="text-rose-500">*</span>
                            </label>
                            <input type="tel" name="phone" required placeholder="۰۹۱۲..." class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all text-left dir-ltr font-medium" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                                آدرس وب‌سایت (دامنه)
                            </label>
                            <input type="url" name="website" placeholder="https://example.com" class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all text-left dir-ltr font-medium" />
                        </div>
                    </div>

                    <!-- توضیحات چالش یا هدف -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-2">
                            توضیح مختصر درباره وضعیت فعلی یا چالش اصلی
                        </label>
                        <textarea name="message" rows="4" placeholder="مثلاً: افت رتبه پس از آپدیت گوگل، کندی سرعت فروشگاه، نیاز به نقشه راه سئو، ساخت اتوماسیون محتوا یا توسعه لندینگ پرسرعت..." class="w-full px-4 py-3.5 rounded-xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 text-sm focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition-all resize-none font-medium leading-relaxed"></textarea>
                    </div>

                    <!-- دکمه سابمیت با استایل برند -->
                    <button type="submit" class="w-full py-4 rounded-xl bg-accent hover:bg-accentHover text-white font-black text-sm sm:text-base shadow-lg shadow-accent/20 active:scale-95 transition-all flex items-center justify-center gap-2.5">
                        <span>ارسال و ثبت نهایی درخواست مشاوره</span>
                        <i class="fas fa-paper-plane text-xs"></i>
                    </button>
                </form>
            </div>

            <!-- ستون اطلاعات تماس و تضمین‌های همکاری (5 ستون) -->
            <div class="lg:col-span-5 space-y-6">
                
                <!-- کارت ارتباط مستقیم -->
                <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-4">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fas fa-headset text-accent dark:text-blue-400"></i>
                        <span>ارتباط مستقیم و فوری</span>
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        در صورت نیاز به مشاوره تلفنی فوری یا پیگیری سریع نیازمندی‌های پروژه، مستقیماً تماس حاصل فرمایید:
                    </p>
                    
                    <div class="space-y-3 pt-2">
                        <a href="tel:09302928001" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-accent dark:hover:border-blue-500 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-blue-100 dark:bg-blue-950/80 text-accent dark:text-blue-400 flex items-center justify-center text-sm font-bold">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">تماس تلفنی مستقیم</div>
                                    <div class="text-[11px] text-slate-400">شنبه تا پنجشنبه ۹ الی ۱۹</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-accent dark:text-blue-400 dir-ltr">0930 292 8001</span>
                        </a>

                        <a href="https://t.me/maaad_mr" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-accent dark:hover:border-blue-500 transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 dark:bg-sky-950/80 text-sky-600 dark:text-sky-400 flex items-center justify-center text-sm font-bold">
                                    <i class="fab fa-telegram-plane"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">تلگرام مستقیم</div>
                                    <div class="text-[11px] text-slate-400">پاسخگویی سریع آنلاین</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-sky-600 dark:text-sky-400 dir-ltr">@maaad_mr</span>
                        </a>

                        <a href="https://ble.ir/maaad_mr" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-[#00B894] transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 text-[#00B894] flex items-center justify-center p-2">
                                    <svg class="w-full h-full fill-current" viewBox="54 4 32 32">
                                        <path d="M72.2139 4.1563C72.2051 4.15482 72.1962 4.15433 72.1878 4.15285C71.9482 4.12031 71.707 4.09171 71.464 4.06952C71.3821 4.06213 71.2993 4.0572 71.2169 4.05079C71.0409 4.03747 70.8649 4.02465 70.6869 4.01726C70.5631 4.01183 70.4383 4.01035 70.3141 4.00789C70.2091 4.00592 70.1055 4 70 4C69.9522 4 69.9043 4.00247 69.8565 4.00296C69.8235 4.00345 69.7909 4.00148 69.7579 4.00197C69.6864 4.00296 69.6159 4.0074 69.5449 4.00937C69.4423 4.01233 69.3393 4.01529 69.2367 4.01972C69.1253 4.02515 69.0148 4.03205 68.9039 4.03994C68.8018 4.04684 68.7002 4.05374 68.5987 4.06262C68.4882 4.07248 68.3787 4.08382 68.2688 4.09565C68.1687 4.1065 68.0681 4.11686 67.9685 4.12968C67.859 4.14348 67.7506 4.15975 67.6416 4.17553C67.5425 4.19032 67.4434 4.20413 67.3452 4.22089C67.2368 4.23914 67.1298 4.25935 67.0223 4.27957C66.9247 4.29781 66.827 4.31556 66.7304 4.33578C66.6229 4.35797 66.5169 4.38262 66.4104 4.40727C66.3147 4.42897 66.2191 4.45017 66.1244 4.47384C66.0174 4.50046 65.9119 4.52955 65.8059 4.55815C65.7127 4.5833 65.619 4.60795 65.5268 4.63458C65.4212 4.66515 65.3172 4.69818 65.2132 4.73122C65.1215 4.75982 65.0297 4.78792 64.9385 4.818C64.835 4.85251 64.7324 4.88998 64.6299 4.92647C64.5396 4.95852 64.4494 4.98958 64.3601 5.02311C64.2576 5.06206 64.156 5.10348 64.0539 5.14441C63.9671 5.17941 63.8794 5.21294 63.7931 5.24943C63.69 5.29282 63.589 5.33917 63.4874 5.38453C63.4036 5.422 63.3192 5.458 63.2359 5.49695C63.1343 5.54428 63.0342 5.59507 62.9337 5.64438C62.8528 5.68431 62.7709 5.72277 62.6906 5.76419C62.5895 5.81646 62.4899 5.87119 62.3903 5.92542C62.3124 5.96783 62.2335 6.00826 62.1566 6.05165C62.054 6.10934 61.9539 6.16998 61.8528 6.23014C61.7803 6.27304 61.7074 6.31445 61.6359 6.35834C61.5269 6.42539 61.4204 6.49541 61.3129 6.56493C61.2513 6.60487 60.6329 7.02743 60.6329 7.02743C60.6329 7.02743 57.7178 4.80616 56.5547 4.20018C55.3915 3.59421 54 4.43834 54 5.74989V8.70336V19.6933C54 19.7983 54 19.9014 54 20C54 28.4822 60.6014 35.4182 68.9463 35.9615C68.9946 35.965 69.0424 35.9694 69.0908 35.9724C69.251 35.9813 69.4127 35.9847 69.574 35.9892C69.6741 35.9921 69.7727 35.9985 69.8733 35.9995C69.8945 35.9995 69.9157 35.9985 69.9369 35.9985C69.9581 35.9985 69.9793 36 70.001 36C70.1213 36 70.2396 35.9936 70.3595 35.9911C70.4941 35.9882 70.6292 35.9872 70.7633 35.9808C70.9033 35.9744 71.0424 35.9625 71.1814 35.9522C71.3141 35.9423 71.4467 35.9349 71.5784 35.9221C71.7164 35.9088 71.853 35.8896 71.9901 35.8728C72.1207 35.8565 72.2524 35.8422 72.3826 35.823C72.5182 35.8028 72.6518 35.7771 72.7864 35.754C72.9156 35.7313 73.0448 35.7106 73.173 35.6849C73.3071 35.6578 73.4392 35.6258 73.5719 35.5957C73.6981 35.5671 73.8248 35.54 73.9496 35.5084C74.0812 35.4749 74.2109 35.4364 74.3411 35.3999C74.4649 35.3649 74.5891 35.3324 74.7114 35.2949C74.8406 35.255 74.9673 35.2106 75.095 35.1677C75.2158 35.1273 75.3381 35.0883 75.4574 35.0449C75.5837 34.9991 75.7074 34.9488 75.8322 34.9C75.9505 34.8536 76.0698 34.8092 76.1872 34.7599C76.3105 34.7082 76.4313 34.652 76.5526 34.5972C76.6679 34.5455 76.7843 34.4957 76.8982 34.4409C77.018 34.3837 77.1354 34.3216 77.2532 34.2614C77.3661 34.2038 77.48 34.1485 77.591 34.0884C77.7069 34.0258 77.8198 33.9587 77.9337 33.8936C78.0436 33.8305 78.1551 33.7694 78.2636 33.7038C78.3765 33.6357 78.4864 33.5633 78.5974 33.4923C78.7034 33.4247 78.8109 33.3586 78.9154 33.2886C79.0249 33.2152 79.1309 33.1373 79.2384 33.0608C79.3409 32.9884 79.4445 32.9173 79.5451 32.8429C79.6506 32.764 79.7531 32.6812 79.8567 32.6003C79.9553 32.5229 80.0549 32.448 80.1516 32.3686C80.2541 32.2843 80.3532 32.196 80.4533 32.1092C80.547 32.0284 80.6427 31.949 80.7344 31.8656C80.833 31.7764 80.9282 31.6827 81.0248 31.591C81.1141 31.5062 81.2053 31.4229 81.2925 31.3356C81.3867 31.2414 81.4775 31.1438 81.5692 31.0471C81.6545 30.9579 81.7413 30.8706 81.8246 30.7794C81.9143 30.6808 82.0001 30.5787 82.0874 30.4777C82.1683 30.3845 82.2511 30.2933 82.3295 30.1981C82.4143 30.096 82.4947 29.99 82.5765 29.8855C82.6535 29.7879 82.7323 29.6922 82.8068 29.5926C82.8862 29.4866 82.9611 29.3771 83.0381 29.2692C83.1105 29.1676 83.185 29.0675 83.2545 28.9644C83.3295 28.854 83.3995 28.7401 83.472 28.6277C83.539 28.5231 83.6081 28.4206 83.6727 28.3146C83.7422 28.2007 83.8068 28.0833 83.8738 27.967C83.936 27.859 84.0006 27.7525 84.0602 27.643C84.1248 27.5237 84.185 27.4019 84.2466 27.2806C84.3028 27.1712 84.361 27.0632 84.4147 26.9522C84.4749 26.828 84.5291 26.7008 84.5863 26.575C84.6366 26.4641 84.6894 26.3541 84.7367 26.2417C84.791 26.1135 84.8398 25.9824 84.8911 25.8527C84.9354 25.7398 84.9828 25.6284 85.0247 25.514C85.0735 25.3813 85.1164 25.2457 85.1618 25.1111C85.2002 24.9967 85.2416 24.8843 85.2776 24.7689C85.3205 24.6314 85.3575 24.4913 85.3965 24.3523C85.429 24.2374 85.4645 24.124 85.4941 24.0081C85.5311 23.8656 85.5612 23.7212 85.5942 23.5772C85.6203 23.4618 85.6499 23.3484 85.6736 23.232C85.7042 23.0841 85.7278 22.9342 85.754 22.7848C85.7742 22.6704 85.7973 22.5575 85.8151 22.4427C85.8393 22.2854 85.8565 22.1261 85.8757 21.9678C85.8891 21.8584 85.9063 21.7504 85.9172 21.6399C85.9354 21.4619 85.9463 21.2815 85.9581 21.1015C85.9645 21.0093 85.9744 20.9181 85.9793 20.8254C85.9926 20.5665 85.9985 20.3057 85.999 20.0434C85.999 20.0291 86 20.0148 86 20C86.001 11.9152 80.0026 5.23464 72.2139 4.1563ZM79.3404 17.9528L70.0503 27.2431C69.4404 27.8526 68.6416 28.1573 67.8423 28.1573C67.043 28.1573 66.2442 27.8526 65.6343 27.2431L60.6605 22.2691C59.4412 21.0497 59.4412 19.073 60.6605 17.8537C61.8799 16.6348 63.8567 16.6348 65.0761 17.8537L67.8428 20.6203L74.9254 13.5374C76.1448 12.3185 78.1215 12.3185 79.3409 13.5374C80.5598 14.7572 80.5598 16.7334 79.3404 17.9528Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">پیام‌رسان بله (مستقیم)</div>
                                    <div class="text-[11px] text-slate-400">ارتباط و پیام خصوصی</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-[#00B894] dir-ltr">@maaad_mr</span>
                        </a>

                        <a href="https://ble.ir/maaad_mrbot" target="_blank" rel="noopener" class="flex items-center justify-between p-3.5 rounded-2xl bg-slate-50 dark:bg-slate-950 border border-slate-200 dark:border-slate-800 hover:border-[#00B894] transition group">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-950/80 text-[#00B894] flex items-center justify-center p-2">
                                    <svg class="w-full h-full fill-current" viewBox="54 4 32 32">
                                        <path d="M72.2139 4.1563C72.2051 4.15482 72.1962 4.15433 72.1878 4.15285C71.9482 4.12031 71.707 4.09171 71.464 4.06952C71.3821 4.06213 71.2993 4.0572 71.2169 4.05079C71.0409 4.03747 70.8649 4.02465 70.6869 4.01726C70.5631 4.01183 70.4383 4.01035 70.3141 4.00789C70.2091 4.00592 70.1055 4 70 4C69.9522 4 69.9043 4.00247 69.8565 4.00296C69.8235 4.00345 69.7909 4.00148 69.7579 4.00197C69.6864 4.00296 69.6159 4.0074 69.5449 4.00937C69.4423 4.01233 69.3393 4.01529 69.2367 4.01972C69.1253 4.02515 69.0148 4.03205 68.9039 4.03994C68.8018 4.04684 68.7002 4.05374 68.5987 4.06262C68.4882 4.07248 68.3787 4.08382 68.2688 4.09565C68.1687 4.1065 68.0681 4.11686 67.9685 4.12968C67.859 4.14348 67.7506 4.15975 67.6416 4.17553C67.5425 4.19032 67.4434 4.20413 67.3452 4.22089C67.2368 4.23914 67.1298 4.25935 67.0223 4.27957C66.9247 4.29781 66.827 4.31556 66.7304 4.33578C66.6229 4.35797 66.5169 4.38262 66.4104 4.40727C66.3147 4.42897 66.2191 4.45017 66.1244 4.47384C66.0174 4.50046 65.9119 4.52955 65.8059 4.55815C65.7127 4.5833 65.619 4.60795 65.5268 4.63458C65.4212 4.66515 65.3172 4.69818 65.2132 4.73122C65.1215 4.75982 65.0297 4.78792 64.9385 4.818C64.835 4.85251 64.7324 4.88998 64.6299 4.92647C64.5396 4.95852 64.4494 4.98958 64.3601 5.02311C64.2576 5.06206 64.156 5.10348 64.0539 5.14441C63.9671 5.17941 63.8794 5.21294 63.7931 5.24943C63.69 5.29282 63.589 5.33917 63.4874 5.38453C63.4036 5.422 63.3192 5.458 63.2359 5.49695C63.1343 5.54428 63.0342 5.59507 62.9337 5.64438C62.8528 5.68431 62.7709 5.72277 62.6906 5.76419C62.5895 5.81646 62.4899 5.87119 62.3903 5.92542C62.3124 5.96783 62.2335 6.00826 62.1566 6.05165C62.054 6.10934 61.9539 6.16998 61.8528 6.23014C61.7803 6.27304 61.7074 6.31445 61.6359 6.35834C61.5269 6.42539 61.4204 6.49541 61.3129 6.56493C61.2513 6.60487 60.6329 7.02743 60.6329 7.02743C60.6329 7.02743 57.7178 4.80616 56.5547 4.20018C55.3915 3.59421 54 4.43834 54 5.74989V8.70336V19.6933C54 19.7983 54 19.9014 54 20C54 28.4822 60.6014 35.4182 68.9463 35.9615C68.9946 35.965 69.0424 35.9694 69.0908 35.9724C69.251 35.9813 69.4127 35.9847 69.574 35.9892C69.6741 35.9921 69.7727 35.9985 69.8733 35.9995C69.8945 35.9995 69.9157 35.9985 69.9369 35.9985C69.9581 35.9985 69.9793 36 70.001 36C70.1213 36 70.2396 35.9936 70.3595 35.9911C70.4941 35.9882 70.6292 35.9872 70.7633 35.9808C70.9033 35.9744 71.0424 35.9625 71.1814 35.9522C71.3141 35.9423 71.4467 35.9349 71.5784 35.9221C71.7164 35.9088 71.853 35.8896 71.9901 35.8728C72.1207 35.8565 72.2524 35.8422 72.3826 35.823C72.5182 35.8028 72.6518 35.7771 72.7864 35.754C72.9156 35.7313 73.0448 35.7106 73.173 35.6849C73.3071 35.6578 73.4392 35.6258 73.5719 35.5957C73.6981 35.5671 73.8248 35.54 73.9496 35.5084C74.0812 35.4749 74.2109 35.4364 74.3411 35.3999C74.4649 35.3649 74.5891 35.3324 74.7114 35.2949C74.8406 35.255 74.9673 35.2106 75.095 35.1677C75.2158 35.1273 75.3381 35.0883 75.4574 35.0449C75.5837 34.9991 75.7074 34.9488 75.8322 34.9C75.9505 34.8536 76.0698 34.8092 76.1872 34.7599C76.3105 34.7082 76.4313 34.652 76.5526 34.5972C76.6679 34.5455 76.7843 34.4957 76.8982 34.4409C77.018 34.3837 77.1354 34.3216 77.2532 34.2614C77.3661 34.2038 77.48 34.1485 77.591 34.0884C77.7069 34.0258 77.8198 33.9587 77.9337 33.8936C78.0436 33.8305 78.1551 33.7694 78.2636 33.7038C78.3765 33.6357 78.4864 33.5633 78.5974 33.4923C78.7034 33.4247 78.8109 33.3586 78.9154 33.2886C79.0249 33.2152 79.1309 33.1373 79.2384 33.0608C79.3409 32.9884 79.4445 32.9173 79.5451 32.8429C79.6506 32.764 79.7531 32.6812 79.8567 32.6003C79.9553 32.5229 80.0549 32.448 80.1516 32.3686C80.2541 32.2843 80.3532 32.196 80.4533 32.1092C80.547 32.0284 80.6427 31.949 80.7344 31.8656C80.833 31.7764 80.9282 31.6827 81.0248 31.591C81.1141 31.5062 81.2053 31.4229 81.2925 31.3356C81.3867 31.2414 81.4775 31.1438 81.5692 31.0471C81.6545 30.9579 81.7413 30.8706 81.8246 30.7794C81.9143 30.6808 82.0001 30.5787 82.0874 30.4777C82.1683 30.3845 82.2511 30.2933 82.3295 30.1981C82.4143 30.096 82.4947 29.99 82.5765 29.8855C82.6535 29.7879 82.7323 29.6922 82.8068 29.5926C82.8862 29.4866 82.9611 29.3771 83.0381 29.2692C83.1105 29.1676 83.185 29.0675 83.2545 28.9644C83.3295 28.854 83.3995 28.7401 83.472 28.6277C83.539 28.5231 83.6081 28.4206 83.6727 28.3146C83.7422 28.2007 83.8068 28.0833 83.8738 27.967C83.936 27.859 84.0006 27.7525 84.0602 27.643C84.1248 27.5237 84.185 27.4019 84.2466 27.2806C84.3028 27.1712 84.361 27.0632 84.4147 26.9522C84.4749 26.828 84.5291 26.7008 84.5863 26.575C84.6366 26.4641 84.6894 26.3541 84.7367 26.2417C84.791 26.1135 84.8398 25.9824 84.8911 25.8527C84.9354 25.7398 84.9828 25.6284 85.0247 25.514C85.0735 25.3813 85.1164 25.2457 85.1618 25.1111C85.2002 24.9967 85.2416 24.8843 85.2776 24.7689C85.3205 24.6314 85.3575 24.4913 85.3965 24.3523C85.429 24.2374 85.4645 24.124 85.4941 24.0081C85.5311 23.8656 85.5612 23.7212 85.5942 23.5772C85.6203 23.4618 85.6499 23.3484 85.6736 23.232C85.7042 23.0841 85.7278 22.9342 85.754 22.7848C85.7742 22.6704 85.7973 22.5575 85.8151 22.4427C85.8393 22.2854 85.8565 22.1261 85.8757 21.9678C85.8891 21.8584 85.9063 21.7504 85.9172 21.6399C85.9354 21.4619 85.9463 21.2815 85.9581 21.1015C85.9645 21.0093 85.9744 20.9181 85.9793 20.8254C85.9926 20.5665 85.9985 20.3057 85.999 20.0434C85.999 20.0291 86 20.0148 86 20C86.001 11.9152 80.0026 5.23464 72.2139 4.1563ZM79.3404 17.9528L70.0503 27.2431C69.4404 27.8526 68.6416 28.1573 67.8423 28.1573C67.043 28.1573 66.2442 27.8526 65.6343 27.2431L60.6605 22.2691C59.4412 21.0497 59.4412 19.073 60.6605 17.8537C61.8799 16.6348 63.8567 16.6348 65.0761 17.8537L67.8428 20.6203L74.9254 13.5374C76.1448 12.3185 78.1215 12.3185 79.3409 13.5374C80.5598 14.7572 80.5598 16.7334 79.3404 17.9528Z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-bold text-slate-900 dark:text-white">بازوی هوشمند بله</div>
                                    <div class="text-[11px] text-slate-400">دستیار و بات شخصی</div>
                                </div>
                            </div>
                            <span class="text-xs font-bold text-[#00B894] dir-ltr">@maaad_mrbot</span>
                        </a>
                    </div>
                </div>

                <!-- استانداردهای همکاری و اطمینان‌بخشی فنی -->
                <div class="bg-gradient-to-br from-slate-50 to-blue-50/40 dark:from-slate-900 dark:to-slate-850 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 sm:p-8 shadow-sm space-y-4">
                    <h4 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <i class="fas fa-shield-halved text-accent dark:text-blue-400"></i>
                        <span>تعهدات فنی و استانداردهای همکاری:</span>
                    </h4>
                    
                    <ul class="space-y-3.5 text-xs text-slate-600 dark:text-slate-300">
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5 shrink-0"></i>
                            <span><strong>معماری بدون Bloatware:</strong> توسعه با کدهای استاندارد بدون افزونه‌های سنگین و صفحه‌سازهای کندکننده.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5 shrink-0"></i>
                            <span><strong>تست کامل در محیط Staging:</strong> حفظ پایداری ۱۰۰٪ فروشگاه و عدم بروز اختلال در فرایند خرید مشتریان.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-check-circle text-emerald-500 mt-0.5 shrink-0"></i>
                            <span><strong>گزارش‌دهی شفاف داده‌محور:</strong> ارائه مستندات شفاف سرچ کنسول، Core Web Vitals و تحلیل ایمپکت کلمات کلیدی.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>

    </div>
</section>


