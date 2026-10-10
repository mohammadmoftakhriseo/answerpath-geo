<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'ورود به پنل مدیریت') ?></title>
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
        body, html, input, button { font-family: 'Vazirmatn', 'Vazirmatn FD', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        body { background-color: #0F172A; -webkit-font-smoothing: antialiased; }
        .fa, .fas, .fab, .far, .fa-solid, .fa-brands, [class^="fa-"], [class*=" fa-"],
        .fa::before, .fas::before, .fab::before, .far::before, .fa-solid::before, .fa-brands::before {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", FontAwesome !important;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-3xl p-8 shadow-2xl">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-2xl mx-auto flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-blue-500/30 mb-4">
                M
            </div>
            <h1 class="text-2xl font-black text-white">پنل مدیریت اختصاصی</h1>
            <p class="text-xs text-slate-400 mt-1">محمد مفتخری (Mohammad Moftakhari)</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm font-bold flex items-center gap-2">
                <i class="fas fa-circle-exclamation text-base"></i>
                <span><?= e($error) ?></span>
            </div>
        <?php endif; ?>

        <form method="POST" action="/admin/login" class="space-y-5">
            <?= csrf_field() ?>
            <div>
                <label class="block text-xs font-bold text-slate-300 mb-2">نام کاربری</label>
                <div class="relative">
                    <span class="absolute right-4 top-3.5 text-slate-400"><i class="fas fa-user"></i></span>
                    <input type="text" name="username" required autofocus placeholder="admin" dir="ltr"
                           class="w-full pl-4 pr-11 py-3 bg-slate-900/60 border border-slate-700 rounded-xl text-white text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-300 mb-2">رمز عبور</label>
                <div class="relative">
                    <span class="absolute right-4 top-3.5 text-slate-400"><i class="fas fa-lock"></i></span>
                    <input type="password" name="password" required placeholder="••••••••" dir="ltr"
                           class="w-full pl-4 pr-11 py-3 bg-slate-900/60 border border-slate-700 rounded-xl text-white text-sm outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-black text-sm shadow-lg shadow-blue-600/30 transition duration-150">
                ورود به سیستم
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="/" class="text-xs text-slate-400 hover:text-slate-200 transition flex items-center justify-center gap-1.5">
                <i class="fas fa-arrow-right text-[10px]"></i>
                بازگشت به وب‌سایت
            </a>
        </div>
    </div>
</body>
</html>
