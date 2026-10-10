<?php
if (empty($schemaJsonLd) && !empty($schemas) && is_array($schemas)) {
    $filteredSchemas = array_values(array_filter($schemas));
    if (!empty($filteredSchemas)) {
        if (count($filteredSchemas) === 1) {
            $schemaJsonLd = json_encode($filteredSchemas[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } else {
            $schemaJsonLd = json_encode([
                '@context' => 'https://schema.org',
                '@graph'   => $filteredSchemas
            ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'محمد مفتخری (Mohammad Moftakhari) | کارشناس و استراتژیست سئو') ?></title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="<?= e($description ?? 'وب‌سایت رسمی محمد مفتخری (Mohammad Moftakhari)، کارشناس ارشد سئو و معمار هوش مصنوعی با بیش از ۶ سال سابقه در آژانس دیجیتال مارکتینگ اینتن.') ?>">
    <meta name="keywords" content="محمد مفتخری, Mohammad Moftakhari, Mohammad Moftakhar, Mohammad Moftakhari Rostamkhani, محمد مفتخری رستم خانی, maaadmr, maaad_mr, سئو, متخصص سئو, کارشناس سئو, دیجیتال مارکتینگ, اینتن">
    <meta name="author" content="Mohammad Moftakhari (محمد مفتخری)">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e($canonical ?? url('/')) ?>">
    
    <!-- Open Graph -->
    <meta property="og:title" content="<?= e($title ?? 'محمد مفتخری (Mohammad Moftakhari) | متخصص سئو') ?>">
    <meta property="og:description" content="<?= e($description ?? 'وب‌سایت رسمی محمد مفتخری (Mohammad Moftakhari)، کارشناس ارشد سئو و معمار سیستم‌های هوش مصنوعی.') ?>">
    <meta property="og:url" content="<?= e($canonical ?? url('/')) ?>">
    <meta property="og:site_name" content="Mohammad Moftakhari | محمد مفتخری">
    <meta property="og:type" content="website">
    <meta property="og:image" content="<?= url('/assets/images/mohammadmoftakhari.jpg') ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($title ?? 'محمد مفتخری (Mohammad Moftakhari)') ?>">
    <meta name="twitter:description" content="<?= e($description ?? 'سایت رسمی محمد مفتخری (Mohammad Moftakhari)، متخصص سئو و معمار هوش مصنوعی.') ?>">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico?v=3">
    <link rel="icon" type="image/webp" href="/assets/images/logo.webp?v=3">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png?v=3">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png?v=3">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/images/apple-touch-icon.png?v=3">
    <link rel="shortcut icon" href="/favicon.ico?v=3">

    <!-- Vazirmatn Font (Primary Local Self-Hosted + Multi-CDN Fallbacks) -->
    <link rel="stylesheet" href="/assets/fonts/vazirmatn.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/vazirmatn@33.0.3/misc/Farsi-Digits/Vazirmatn-FD-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Vazirmatn', 'Vazirmatn FD', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'sans-serif'],
                        vazir: ['Vazirmatn', 'Vazirmatn FD', 'sans-serif'],
                    },
                    colors: {
                        background: '#F8FAFC', /* سفید استخوانی / اسلیت بسیار تمیز */
                        textMain: '#0F172A', /* مشکی عمیق و خوانا */
                        accent: '#1E3A8A', /* سرمه‌ای سلطنتی رسمی برند */
                        accentHover: '#172554',
                    }
                }
            }
        }
    </script>
    
    <script>
        // Automatic standard device theme detection (follows user OS / browser setting)
        function applySystemTheme() {
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        applySystemTheme();
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applySystemTheme);
        }
    </script>
    
    <style>
        body, html, input, button, select, textarea, optgroup, option {
            font-family: 'Vazirmatn', 'Vazirmatn FD', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body, html {
            background-color: #F8FAFC;
            color: #0F172A;
            scroll-behavior: smooth;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: optimizeLegibility;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .dark body, html.dark body {
            background-color: #0B1120;
            color: #F1F5F9;
        }

        /* Protect FontAwesome Icons from being overridden by text font */
        .fa, .fas, .fab, .far, .fa-solid, .fa-brands, .fa-regular,
        .fa::before, .fas::before, .fab::before, .far::before, .fa-solid::before, .fa-brands::before, .fa-regular::before {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", FontAwesome !important;
        }
        .fab, .fab::before, .fa-brands, .fa-brands::before {
            font-family: "Font Awesome 6 Brands" !important;
        }
        
        .glass-header {
            background: rgba(248, 250, 252, 0.94);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .dark .glass-header {
            background: rgba(11, 17, 32, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .card {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
        }

        .dark .card {
            background: #151F32;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.4);
            color: #F1F5F9;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px -3px rgba(0, 0, 0, 0.06), 0 4px 6px -2px rgba(0, 0, 0, 0.03);
        }

        .dark .card:hover {
            box-shadow: 0 10px 20px -3px rgba(0, 0, 0, 0.6);
        }
        
        .hero-pattern {
            background-image: radial-gradient(#1E3A8A 0.5px, transparent 0.5px);
            background-size: 24px 24px;
            opacity: 0.06;
        }
        }
        
        /* Smooth micro-interactions */
        .interactive-scale {
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .interactive-scale:active {
            transform: scale(0.97);
        }
    </style>

    <!-- Injected JSON-LD Schema (GEO/AEO) -->
    <?php if (!empty($schemaJsonLd)): ?>
        <script type="application/ld+json">
            <?= $schemaJsonLd ?>
        </script>
    <?php endif; ?>
</head>
<body class="antialiased selection:bg-accent selection:text-white flex flex-col min-h-screen dark:bg-[#0B1120] dark:text-slate-100">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass-header transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 sm:h-24">
                
                <!-- Logo & Brand -->
                <div class="flex-shrink-0 flex items-center gap-4">
                    <a href="/" class="flex items-center gap-3 group">
                        <img src="/assets/images/logo.webp?v=<?= @filemtime(__DIR__ . '/../../../../assets/images/logo.webp') ?: time() ?>" alt="لوگو محمد مفتخری" class="w-11 h-11 sm:w-12 sm:h-12 object-contain rounded-2xl shadow-md group-hover:scale-105 transition-transform duration-300">
                        <div class="flex flex-col">
                            <span class="text-base sm:text-lg font-black text-slate-900 dark:text-white tracking-tight">محمد مفتخری</span>
                            <span class="text-[11px] font-bold text-accent dark:text-blue-400">استراتژیست سئو و اتوماسیون</span>
                        </div>
                    </a>
                </div>
                
                <!-- Clean Desktop Menu -->
                <div class="hidden lg:flex space-x-6 space-x-reverse items-center">
                    <a href="/" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors">خانه</a>
                    <a href="/about" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors">درباره من</a>
                    
                    <!-- Dropdown Services -->
                    <div class="relative group">
                        <button type="button" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 flex items-center gap-1.5 py-2 transition-colors">
                            <span>خدمات تخصصی سئو</span>
                            <i class="fas fa-chevron-down text-[10px] group-hover:rotate-180 transition-transform duration-200"></i>
                        </button>
                        <div class="absolute right-0 top-full pt-2 w-72 hidden group-hover:block transition-all z-50">
                            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-slate-200 dark:border-slate-700 p-2 space-y-1">
                                <a href="/services/seo-strategy" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-compass"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">استراتژی و مشاوره جامع</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">معماری کلاستر و نقشه رشد</div>
                                    </div>
                                </a>
                                <a href="/services/technical-seo" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-bolt"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">سئوی تکنیکال و سرعت</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">Core Web Vitals و دیتابیس</div>
                                    </div>
                                </a>
                                <a href="/services/ai-automation" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-robot"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">اتوماسیون هوش مصنوعی</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">سیستم‌سازی محتوا با Gemini</div>
                                    </div>
                                </a>
                                <a href="/services/mcp-automation" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-network-wired"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">اتوماسیون هوش مصنوعی با MCP</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">اتصال به دیتابیس و برنامه‌ها</div>
                                    </div>
                                </a>
                                <a href="/services/mcp-simulator" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-terminal"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">شبیه‌ساز هوش مصنوعی (MCP)</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">کنسول تست زنده ابزارها</div>
                                    </div>
                                </a>
                                <a href="/services/local-seo" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-map-location-dot"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">سئوی محلی و نقشه‌ها</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">گوگل مپ، نشان و بلد</div>
                                    </div>
                                </a>
                                <a href="/services/landing-page-design-cro" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-layer-group"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">طراحی لندینگ و CRO</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">افزایش نرخ تبدیل و فروش</div>
                                    </div>
                                </a>
                                <a href="/services/custom-web-development" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700/60 transition group/item">
                                    <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/40 text-accent dark:text-blue-400 flex items-center justify-center text-xs shrink-0">
                                        <i class="fas fa-code"></i>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white group-hover/item:text-accent dark:group-hover/item:text-blue-400">طراحی سایت اختصاصی</div>
                                        <div class="text-[11px] text-slate-500 dark:text-slate-400">بدون المنتور | پرسرعت و امن</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/projects" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors">نمونه‌کارها</a>
                    <a href="/articles" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors">وبلاگ سئو</a>
                    <a href="/seo-roadmap" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors">نقشه راه</a>
                    <a href="/services/mcp-simulator" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent animate-pulse"></span>
                        <span>شبیه‌ساز MCP</span>
                    </a>
                    <a href="/contact" class="text-sm font-bold text-slate-700 dark:text-slate-300 hover:text-accent dark:hover:text-blue-400 transition-colors">تماس</a>
                </div>

                <!-- Right Actions: Direct Contact & Mobile Hamburger -->
                <div class="flex items-center gap-3">
                    <a href="/start" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-accent text-white font-bold text-xs sm:text-sm shadow-md hover:bg-accentHover transition-all interactive-scale">
                        <span>رزرو مشاوره</span>
                        <i class="fas fa-arrow-left text-xs"></i>
                    </a>

                    <!-- Mobile Hamburger -->
                    <button id="mobile-menu-btn" class="lg:hidden text-slate-800 dark:text-white hover:text-accent focus:outline-none p-2" aria-label="منوی موبایل">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Clean Mobile Menu -->
        <div id="mobile-menu" class="hidden lg:hidden bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 absolute w-full shadow-2xl">
            <div class="px-4 pt-3 pb-6 space-y-1.5 sm:px-3">
                <a href="/" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">صفحه اصلی</a>
                <a href="/about" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">درباره من</a>
                <div class="pt-2 pb-1 border-t border-slate-100 dark:border-slate-800">
                    <span class="px-3 text-[11px] font-bold text-slate-400 block mb-1">خدمات تخصصی:</span>
                    <a href="/services/seo-strategy" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">استراتژی و مشاوره جامع</a>
                    <a href="/services/technical-seo" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">سئوی تکنیکال و سرعت</a>
                    <a href="/services/ai-automation" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">اتوماسیون هوش مصنوعی</a>
                    <a href="/services/mcp-automation" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">اتوماسیون هوش مصنوعی با MCP</a>
                    <a href="/services/mcp-simulator" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">شبیه‌ساز هوش مصنوعی (MCP)</a>
                    <a href="/services/local-seo" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">سئوی محلی و نقشه‌ها</a>
                    <a href="/services/landing-page-design-cro" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">طراحی لندینگ و CRO</a>
                    <a href="/services/custom-web-development" class="block px-3 py-1.5 text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-accent">طراحی سایت اختصاصی</a>
                </div>
                <a href="/projects" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">نمونه‌کارها</a>
                <a href="/articles" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">وبلاگ سئو</a>
                <a href="/seo-roadmap" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">نقشه راه سئو</a>
                <a href="/services/mcp-simulator" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">شبیه‌ساز هوش مصنوعی MCP</a>
                <a href="/contact" class="block px-3 py-2 rounded-xl text-sm font-bold text-slate-800 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800">تماس با من</a>
                <a href="/start" class="block mt-3 text-center px-4 py-2.5 text-sm font-bold rounded-xl text-white bg-accent">رزرو مشاوره و استعلام پروژه</a>
            </div>
        </div>
    </nav>

    <!-- Dynamic Main Content -->
    <main id="main-content" class="flex-grow pt-20 md:pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <?= $content ?>
    </main>

    <!-- Refined Elegant Footer -->
    <footer class="bg-[#0B1120] text-slate-400 pt-16 pb-12 border-t border-slate-800/80 mt-auto" role="contentinfo">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 pb-12 border-b border-slate-800 items-start">
                
                <!-- ستون ۱: معرفی و شبکه‌های اجتماعی (5 cols) -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="/assets/images/logo.webp?v=<?= @filemtime(__DIR__ . '/../../../../assets/images/logo.webp') ?: time() ?>" alt="لوگو محمد مفتخری" class="w-11 h-11 object-contain rounded-xl shadow-md">
                        <div>
                            <span class="text-lg font-black text-white block">محمد مفتخری (Mohammad Moftakhari)</span>
                            <span class="text-xs text-blue-400 font-bold">کارشناس و استراتژیست سئو | ۶ سال سابقه</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-md font-normal text-justify">
                        مشاوره و اجرای استراتژی‌های سئوی مدرن، بهینه‌سازی تکنیکال و سرعت وردپرس، اتوماسیون محتوا با هوش مصنوعی و تسخیر نقشه‌های محلی در آژانس دیجیتال مارکتینگ اینتن.
                    </p>
                    <div class="flex items-center gap-2 pt-2 flex-wrap">
                        <a href="https://www.instagram.com/maaad_mr/" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-800/90 hover:bg-[#E1306C] text-slate-300 hover:text-white flex items-center justify-center transition" aria-label="اینستاگرام" title="اینستاگرام: @maaad_mr">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="https://t.me/maaad_mr" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-800/90 hover:bg-[#229ED9] text-slate-300 hover:text-white flex items-center justify-center transition" aria-label="تلگرام" title="تلگرام: @maaad_mr">
                            <i class="fab fa-telegram-plane text-sm"></i>
                        </a>
                        <a href="https://ble.ir/maaad_mr" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-800/90 hover:bg-[#00B894] text-slate-300 hover:text-white flex items-center justify-center transition group" aria-label="پیام‌رسان بله" title="پیام‌رسان بله: @maaad_mr">
                            <svg class="w-4 h-4 fill-current group-hover:scale-110 transition-transform" viewBox="54 4 32 32">
                                <path d="M72.2139 4.1563C72.2051 4.15482 72.1962 4.15433 72.1878 4.15285C71.9482 4.12031 71.707 4.09171 71.464 4.06952C71.3821 4.06213 71.2993 4.0572 71.2169 4.05079C71.0409 4.03747 70.8649 4.02465 70.6869 4.01726C70.5631 4.01183 70.4383 4.01035 70.3141 4.00789C70.2091 4.00592 70.1055 4 70 4C69.9522 4 69.9043 4.00247 69.8565 4.00296C69.8235 4.00345 69.7909 4.00148 69.7579 4.00197C69.6864 4.00296 69.6159 4.0074 69.5449 4.00937C69.4423 4.01233 69.3393 4.01529 69.2367 4.01972C69.1253 4.02515 69.0148 4.03205 68.9039 4.03994C68.8018 4.04684 68.7002 4.05374 68.5987 4.06262C68.4882 4.07248 68.3787 4.08382 68.2688 4.09565C68.1687 4.1065 68.0681 4.11686 67.9685 4.12968C67.859 4.14348 67.7506 4.15975 67.6416 4.17553C67.5425 4.19032 67.4434 4.20413 67.3452 4.22089C67.2368 4.23914 67.1298 4.25935 67.0223 4.27957C66.9247 4.29781 66.827 4.31556 66.7304 4.33578C66.6229 4.35797 66.5169 4.38262 66.4104 4.40727C66.3147 4.42897 66.2191 4.45017 66.1244 4.47384C66.0174 4.50046 65.9119 4.52955 65.8059 4.55815C65.7127 4.5833 65.619 4.60795 65.5268 4.63458C65.4212 4.66515 65.3172 4.69818 65.2132 4.73122C65.1215 4.75982 65.0297 4.78792 64.9385 4.818C64.835 4.85251 64.7324 4.88998 64.6299 4.92647C64.5396 4.95852 64.4494 4.98958 64.3601 5.02311C64.2576 5.06206 64.156 5.10348 64.0539 5.14441C63.9671 5.17941 63.8794 5.21294 63.7931 5.24943C63.69 5.29282 63.589 5.33917 63.4874 5.38453C63.4036 5.422 63.3192 5.458 63.2359 5.49695C63.1343 5.54428 63.0342 5.59507 62.9337 5.64438C62.8528 5.68431 62.7709 5.72277 62.6906 5.76419C62.5895 5.81646 62.4899 5.87119 62.3903 5.92542C62.3124 5.96783 62.2335 6.00826 62.1566 6.05165C62.054 6.10934 61.9539 6.16998 61.8528 6.23014C61.7803 6.27304 61.7074 6.31445 61.6359 6.35834C61.5269 6.42539 61.4204 6.49541 61.3129 6.56493C61.2513 6.60487 60.6329 7.02743 60.6329 7.02743C60.6329 7.02743 57.7178 4.80616 56.5547 4.20018C55.3915 3.59421 54 4.43834 54 5.74989V8.70336V19.6933C54 19.7983 54 19.9014 54 20C54 28.4822 60.6014 35.4182 68.9463 35.9615C68.9946 35.965 69.0424 35.9694 69.0908 35.9724C69.251 35.9813 69.4127 35.9847 69.574 35.9892C69.6741 35.9921 69.7727 35.9985 69.8733 35.9995C69.8945 35.9995 69.9157 35.9985 69.9369 35.9985C69.9581 35.9985 69.9793 36 70.001 36C70.1213 36 70.2396 35.9936 70.3595 35.9911C70.4941 35.9882 70.6292 35.9872 70.7633 35.9808C70.9033 35.9744 71.0424 35.9625 71.1814 35.9522C71.3141 35.9423 71.4467 35.9349 71.5784 35.9221C71.7164 35.9088 71.853 35.8896 71.9901 35.8728C72.1207 35.8565 72.2524 35.8422 72.3826 35.823C72.5182 35.8028 72.6518 35.7771 72.7864 35.754C72.9156 35.7313 73.0448 35.7106 73.173 35.6849C73.3071 35.6578 73.4392 35.6258 73.5719 35.5957C73.6981 35.5671 73.8248 35.54 73.9496 35.5084C74.0812 35.4749 74.2109 35.4364 74.3411 35.3999C74.4649 35.3649 74.5891 35.3324 74.7114 35.2949C74.8406 35.255 74.9673 35.2106 75.095 35.1677C75.2158 35.1273 75.3381 35.0883 75.4574 35.0449C75.5837 34.9991 75.7074 34.9488 75.8322 34.9C75.9505 34.8536 76.0698 34.8092 76.1872 34.7599C76.3105 34.7082 76.4313 34.652 76.5526 34.5972C76.6679 34.5455 76.7843 34.4957 76.8982 34.4409C77.018 34.3837 77.1354 34.3216 77.2532 34.2614C77.3661 34.2038 77.48 34.1485 77.591 34.0884C77.7069 34.0258 77.8198 33.9587 77.9337 33.8936C78.0436 33.8305 78.1551 33.7694 78.2636 33.7038C78.3765 33.6357 78.4864 33.5633 78.5974 33.4923C78.7034 33.4247 78.8109 33.3586 78.9154 33.2886C79.0249 33.2152 79.1309 33.1373 79.2384 33.0608C79.3409 32.9884 79.4445 32.9173 79.5451 32.8429C79.6506 32.764 79.7531 32.6812 79.8567 32.6003C79.9553 32.5229 80.0549 32.448 80.1516 32.3686C80.2541 32.2843 80.3532 32.196 80.4533 32.1092C80.547 32.0284 80.6427 31.949 80.7344 31.8656C80.833 31.7764 80.9282 31.6827 81.0248 31.591C81.1141 31.5062 81.2053 31.4229 81.2925 31.3356C81.3867 31.2414 81.4775 31.1438 81.5692 31.0471C81.6545 30.9579 81.7413 30.8706 81.8246 30.7794C81.9143 30.6808 82.0001 30.5787 82.0874 30.4777C82.1683 30.3845 82.2511 30.2933 82.3295 30.1981C82.4143 30.096 82.4947 29.99 82.5765 29.8855C82.6535 29.7879 82.7323 29.6922 82.8068 29.5926C82.8862 29.4866 82.9611 29.3771 83.0381 29.2692C83.1105 29.1676 83.185 29.0675 83.2545 28.9644C83.3295 28.854 83.3995 28.7401 83.472 28.6277C83.539 28.5231 83.6081 28.4206 83.6727 28.3146C83.7422 28.2007 83.8068 28.0833 83.8738 27.967C83.936 27.859 84.0006 27.7525 84.0602 27.643C84.1248 27.5237 84.185 27.4019 84.2466 27.2806C84.3028 27.1712 84.361 27.0632 84.4147 26.9522C84.4749 26.828 84.5291 26.7008 84.5863 26.575C84.6366 26.4641 84.6894 26.3541 84.7367 26.2417C84.791 26.1135 84.8398 25.9824 84.8911 25.8527C84.9354 25.7398 84.9828 25.6284 85.0247 25.514C85.0735 25.3813 85.1164 25.2457 85.1618 25.1111C85.2002 24.9967 85.2416 24.8843 85.2776 24.7689C85.3205 24.6314 85.3575 24.4913 85.3965 24.3523C85.429 24.2374 85.4645 24.124 85.4941 24.0081C85.5311 23.8656 85.5612 23.7212 85.5942 23.5772C85.6203 23.4618 85.6499 23.3484 85.6736 23.232C85.7042 23.0841 85.7278 22.9342 85.754 22.7848C85.7742 22.6704 85.7973 22.5575 85.8151 22.4427C85.8393 22.2854 85.8565 22.1261 85.8757 21.9678C85.8891 21.8584 85.9063 21.7504 85.9172 21.6399C85.9354 21.4619 85.9463 21.2815 85.9581 21.1015C85.9645 21.0093 85.9744 20.9181 85.9793 20.8254C85.9926 20.5665 85.9985 20.3057 85.999 20.0434C85.999 20.0291 86 20.0148 86 20C86.001 11.9152 80.0026 5.23464 72.2139 4.1563ZM79.3404 17.9528L70.0503 27.2431C69.4404 27.8526 68.6416 28.1573 67.8423 28.1573C67.043 28.1573 66.2442 27.8526 65.6343 27.2431L60.6605 22.2691C59.4412 21.0497 59.4412 19.073 60.6605 17.8537C61.8799 16.6348 63.8567 16.6348 65.0761 17.8537L67.8428 20.6203L74.9254 13.5374C76.1448 12.3185 78.1215 12.3185 79.3409 13.5374C80.5598 14.7572 80.5598 16.7334 79.3404 17.9528Z"/>
                            </svg>
                        </a>
                        <a href="https://wa.me/989302928001" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-800/90 hover:bg-[#25D366] text-slate-300 hover:text-white flex items-center justify-center transition" aria-label="واتساپ" title="واتساپ: 09302928001">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                        <a href="https://www.linkedin.com/in/mohammad-moftakhari-b90687217" target="_blank" rel="noopener" class="w-9 h-9 rounded-xl bg-slate-800/90 hover:bg-[#0A66C2] text-slate-300 hover:text-white flex items-center justify-center transition" aria-label="لینکدین" title="لینکدین: Mohammad Moftakhari">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                        <a href="tel:09302928001" class="w-9 h-9 rounded-xl bg-slate-800/90 hover:bg-accent text-slate-300 hover:text-white flex items-center justify-center transition" aria-label="تماس تلفنی" title="تماس: 09302928001">
                            <i class="fas fa-phone text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- ستون ۲: خدمات تخصصی (3 cols) -->
                <div class="lg:col-span-3 space-y-3">
                    <h4 class="text-white font-bold text-sm">خدمات تخصصی</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="/services/seo-strategy" class="hover:text-blue-400 transition">مشاوره و استراتژی کلان سئو</a></li>
                        <li><a href="/services/technical-seo" class="hover:text-blue-400 transition">سئوی تکنیکال و افزایش سرعت</a></li>
                        <li><a href="/services/ai-automation" class="hover:text-blue-400 transition">اتوماسیون محتوا و Gemini API</a></li>
                        <li><a href="/services/mcp-automation" class="hover:text-blue-400 transition">یکپارچه‌سازی و اتوماسیون MCP</a></li>
                        <li><a href="/services/local-seo" class="hover:text-blue-400 transition">سئوی محلی، گوگل‌مپ، نشان و بلد</a></li>
                        <li><a href="/services/landing-page-design-cro" class="hover:text-blue-400 transition">طراحی صفحات فرود و CRO</a></li>
                        <li><a href="/services/custom-web-development" class="hover:text-blue-400 transition">طراحی سایت اختصاصی</a></li>
                    </ul>
                </div>

                <!-- ستون ۳: صفحات اصلی (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-white font-bold text-sm">دسترسی سریع</h4>
                    <ul class="space-y-2.5 text-xs text-slate-400">
                        <li><a href="/about" class="hover:text-white transition">درباره من</a></li>
                        <li><a href="/projects" class="hover:text-white transition">نمونه‌کارها و نتایج</a></li>
                        <li><a href="/articles" class="hover:text-white transition">وبلاگ و مقالات سئو</a></li>
                        <li><a href="/seo-roadmap" class="hover:text-white transition">نقشه راه سئو</a></li>
                        <li><a href="/contact" class="hover:text-white transition">تماس با من</a></li>
                    </ul>
                </div>

                <!-- ستون ۴: شروع همکاری (2 cols) -->
                <div class="lg:col-span-2 space-y-3">
                    <h4 class="text-white font-bold text-sm">شروع همکاری</h4>
                    <p class="text-xs text-slate-400 leading-relaxed font-normal">
                        تحلیل اختصاصی وضعیت سئو یا رزرو جلسه مشاوره:
                    </p>
                    <a href="/start" class="inline-flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-accent text-white font-bold text-xs hover:bg-accentHover shadow-md transition">
                        <span>رزرو نوبت مشاوره</span>
                        <i class="fas fa-arrow-left text-[10px]"></i>
                    </a>
                </div>

            </div>

            <!-- کپی رایت -->
            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-500 gap-4">
                <p>© <?= date('Y') ?> تمامی حقوق مادی و معنوی متعلق به محمد مفتخری می‌باشد.</p>
                <div class="flex items-center gap-4">
                    <a href="/sitemap.xml" class="hover:text-slate-400 transition">نقشه سایت</a>
                </div>
            </div>

        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });

            menu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.add('hidden');
                });
            });
        }

        // Navbar Scroll Styling with Dark Mode awareness
        const navbar = document.getElementById('navbar');
        function updateNavbarStyle() {
            const isDark = document.documentElement.classList.contains('dark');
            if (window.scrollY > 10) {
                navbar.classList.add('shadow-md');
                navbar.style.background = isDark ? 'rgba(15, 23, 42, 0.95)' : 'rgba(255, 255, 255, 0.95)';
            } else {
                navbar.classList.remove('shadow-md');
                navbar.style.background = isDark ? 'rgba(11, 17, 32, 0.9)' : 'rgba(229, 231, 235, 0.85)';
            }
        }
        window.addEventListener('scroll', updateNavbarStyle);
        if (window.matchMedia) {
            window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                setTimeout(updateNavbarStyle, 50);
            });
        }
        updateNavbarStyle();

        // Smooth Scrolling for Hash Anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href.startsWith('#')) {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    </script>
</body>
</html>
