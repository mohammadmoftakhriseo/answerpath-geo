<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'پنل مدیریت | محمد مفتخری') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/fonts/vazirmatn.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.0.0/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    <link href="https://unpkg.com/vazirmatn@33.0.3/misc/Farsi-Digits/Vazirmatn-FD-font-face.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        body, html, input, button, select, textarea { font-family: 'Vazirmatn', 'Vazirmatn FD', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body { background-color: #0F172A; color: #F8FAFC; -webkit-font-smoothing: antialiased; }
        .fa, .fas, .fab, .far, .fa-solid, .fa-brands, [class^="fa-"], [class*=" fa-"],
        .fa::before, .fas::before, .fab::before, .far::before, .fa-solid::before, .fa-brands::before {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", FontAwesome !important;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col md:flex-row">

    <!-- Sidebar Navigation -->
    <aside class="w-full md:w-64 bg-slate-900 border-b md:border-b-0 md:border-l border-slate-800 flex flex-col justify-between flex-shrink-0">
        <div>
            <!-- Admin Brand -->
            <div class="p-6 border-b border-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white font-black text-lg shadow-lg">M</div>
                <div>
                    <h1 class="font-black text-sm text-white">پنل مدیریت سئو</h1>
                    <p class="text-xs text-slate-400">محمد مفتخری</p>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="p-4 space-y-1 text-sm font-medium">
                <a href="/admin" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fas fa-gauge-high text-blue-400 w-5"></i>
                    <span>داشبورد اصلی</span>
                </a>
                <a href="/admin/pages" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fas fa-layer-group text-cyan-400 w-5"></i>
                    <span>پیلارها و صفحات سایت</span>
                </a>
                <a href="/admin/leads" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fas fa-comments text-emerald-400 w-5"></i>
                    <span>لیدها و بریف‌ها</span>
                </a>
                <a href="/admin/projects" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fas fa-briefcase text-sky-400 w-5"></i>
                    <span>مدیریت نمونه‌کارها</span>
                </a>
                <a href="/admin/articles" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fas fa-newspaper text-purple-400 w-5"></i>
                    <span>مقالات وبلاگ سئو</span>
                </a>
                <a href="/admin/ai-writer" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-slate-800/40 border border-slate-800 text-slate-400 hover:text-slate-300 transition text-xs font-semibold">
                    <i class="fas fa-robot text-slate-500 w-5"></i>
                    <span>ماشین محتوا با AI</span>
                    <span class="mr-auto px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 text-[10px]">غیرفعال</span>
                </a>
                <a href="/admin/settings" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fas fa-sliders text-amber-400 w-5"></i>
                    <span>تنظیمات سئو و سایت</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Actions -->
        <div class="p-4 border-t border-slate-800 space-y-2">
            <a href="/" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-bold text-slate-300 transition">
                <i class="fas fa-arrow-up-right-from-square"></i>
                <span>مشاهده سایت اصلی</span>
            </a>
            <form method="POST" action="/admin/logout">
                <?= csrf_field() ?>
                <button type="submit" class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/20 text-xs font-bold transition">
                    <i class="fas fa-arrow-right-from-bracket"></i>
                    <span>خروج از پنل</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-grow flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="bg-slate-900/60 border-b border-slate-800 px-6 py-4 flex items-center justify-between">
            <h2 class="text-base font-bold text-white"><?= e($title ?? 'مدیریت') ?></h2>
            <div class="flex items-center gap-3 text-xs text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>سیستم فعال و آنلاین</span>
            </div>
        </header>

        <!-- Dynamic Body -->
        <main class="p-6 md:p-8 flex-grow">
            <?= $content ?>
        </main>
    </div>

    <!-- Ultra-Lightweight Dynamic Rich Text Editor (Classic WordPress-style) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var textareas = document.querySelectorAll('.tinymce-editor, textarea[name="content"], textarea[name="description"]');
            if (textareas.length === 0) return;

            // Load TinyMCE dynamically only on pages where the editor is needed (0kb overhead on other pages)
            var script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js';
            script.referrerPolicy = 'origin';
            script.onload = function() {
                tinymce.init({
                    selector: '.tinymce-editor, textarea[name="content"], textarea[name="description"]',
                    height: 480,
                    directionality: 'rtl',
                    language: 'en',
                    menubar: false, // Lightweight: remove heavy classic top menu bar, keep compact classic toolbar
                    elementpath: false,
                    branding: false,
                    promotion: false,
                    plugins: 'lists link image table code fullscreen directionality wordcount',
                    toolbar: 'undo redo | blocks | bold italic underline strikethrough | forecolor backcolor | alignright aligncenter alignleft alignjustify | bullist numlist outdent indent | rtl ltr | link image table | blockquote hr | removeformat code fullscreen',
                    toolbar_mode: 'wrap',
                    skin: 'oxide-dark',
                    content_css: 'dark',
                    content_style: `
                        body {
                            font-family: 'Vazirmatn', 'Vazirmatn FD', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                            font-size: 14.5px;
                            line-height: 1.8;
                            direction: rtl;
                            text-align: right;
                            color: #e2e8f0;
                            background-color: #0f172a;
                            padding: 14px;
                        }
                        h1, h2, h3, h4, h5, h6 { color: #f8fafc; font-weight: 800; margin: 1.2em 0 0.4em; }
                        h1 { font-size: 1.7rem; }
                        h2 { font-size: 1.4rem; color: #60a5fa; }
                        h3 { font-size: 1.2rem; color: #93c5fd; }
                        p { margin-bottom: 1em; }
                        a { color: #38bdf8; text-decoration: underline; }
                        blockquote { border-right: 4px solid #3b82f6; padding: 10px 16px; margin: 1.2em 0; color: #cbd5e1; background: rgba(59, 130, 246, 0.08); border-radius: 6px; }
                        code { background: #1e293b; color: #f472b6; padding: 2px 5px; border-radius: 4px; font-family: monospace; font-size: 0.9em; }
                        pre { background: #1e293b; color: #e2e8f0; padding: 12px; border-radius: 6px; border: 1px solid #334155; overflow-x: auto; }
                        table { width: 100%; border-collapse: collapse; margin: 1.2em 0; }
                        th, td { border: 1px solid #334155; padding: 8px 12px; text-align: right; }
                        th { background: #1e293b; font-weight: bold; color: #60a5fa; }
                        img { max-width: 100%; height: auto; border-radius: 8px; }
                        ul, ol { padding-right: 24px; margin-bottom: 1em; }
                        ul { list-style-type: disc; }
                        ol { list-style-type: decimal; }
                        li { margin-bottom: 0.3em; }
                    `,
                    setup: function (editor) {
                        editor.on('change keyup NodeChange', function () {
                            editor.save();
                        });
                    }
                });
            };
            document.head.appendChild(script);
        });
    </script>
</body>
</html>
