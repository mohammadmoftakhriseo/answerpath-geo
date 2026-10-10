<?php
$catMap = [
    'سئوی تکنیکال'              => ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => '/services/technical-seo'],
    'سئوی تکنیکال و پرفورمنس'    => ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => '/services/technical-seo'],
    'TechArticle'                => ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => '/services/technical-seo'],
    'اتوماسیون هوش مصنوعی'       => ['name' => 'اتوماسیون هوش مصنوعی', 'url' => '/services/ai-automation'],
    'اتوماسیون هوش مصنوعی و MCP' => ['name' => 'اتوماسیون هوش مصنوعی و MCP', 'url' => '/services/ai-automation'],
    'پروتکل MCP'                 => ['name' => 'اتوماسیون پروتکل MCP', 'url' => '/services/mcp-automation'],
    'طراحی لندینگ‌پیج و CRO'     => ['name' => 'طراحی لندینگ‌پیج و نرخ تبدیل', 'url' => '/services/landing-page-design-cro'],
    'سئوی محلی و گوگل مپ'        => ['name' => 'سئوی محلی و گوگل مپ', 'url' => '/services/local-seo'],
    'استراتژی سئو'               => ['name' => 'استراتژی و مشاوره سئو', 'url' => '/services/seo-strategy'],
    'توسعه اختصاصی وب'           => ['name' => 'طراحی سایت و کدنویسی اختصاصی', 'url' => '/services/custom-web-development'],
];
$categoryInfo = $catMap[$article['schema_type'] ?? ''] ?? ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => '/services/technical-seo'];
?>
<div class="py-10 space-y-12 max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-gray-500 dark:text-slate-400">
        <a href="/" class="hover:text-accent dark:hover:text-blue-400 transition">صفحه اصلی</a>
        <i class="fas fa-chevron-left text-[10px]"></i>
        <a href="/articles" class="hover:text-accent dark:hover:text-blue-400 transition">مقالات</a>
        <i class="fas fa-chevron-left text-[10px]"></i>
        <a href="<?= e($categoryInfo['url']) ?>" class="hover:text-accent dark:hover:text-blue-400 transition font-medium"><?= e($categoryInfo['name']) ?></a>
        <i class="fas fa-chevron-left text-[10px]"></i>
        <span class="text-textMain dark:text-slate-200 font-medium truncate max-w-xs"><?= e($article['title']) ?></span>
    </nav>

    <!-- Article Header -->
    <header class="space-y-6">
        <div class="flex flex-wrap items-center gap-3 text-xs">
            <a href="<?= e($categoryInfo['url']) ?>" class="px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-950/60 text-accent dark:text-blue-300 font-bold border border-blue-200 dark:border-blue-900 hover:bg-blue-200 dark:hover:bg-blue-900 transition flex items-center gap-1.5">
                <i class="fas fa-layer-group text-[10px]"></i>
                <span><?= e($categoryInfo['name']) ?></span>
            </a>
            <span class="text-gray-500 dark:text-slate-400 flex items-center gap-1.5">
                <i class="far fa-user"></i>
                نویسنده: محمد مفتخری
            </span>
            <span class="text-gray-400 dark:text-slate-600">•</span>
            <span class="text-gray-500 dark:text-slate-400 flex items-center gap-1.5">
                <i class="far fa-clock"></i>
                زمان مطالعه: <?= e($article['reading_time'] ?? 5) ?> دقیقه
            </span>
        </div>

        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-textMain dark:text-white leading-tight">
            <?= e($article['title']) ?>
        </h1>

        <!-- Cafe Danesh Style: خلاصه سریع (Quick Takeaways / Summary) -->
        <?php
        $summaryText = !empty($article['direct_answer']) ? $article['direct_answer'] : ($article['summary'] ?? '');
        $quickPoints = [];
        if (!empty($summaryText)) {
            $splitSentences = preg_split('/(?<=[.؟!؛\n])\s+/u', trim($summaryText), -1, PREG_SPLIT_NO_EMPTY);
            foreach ($splitSentences as $sentence) {
                $cleanSentence = trim(strip_tags($sentence));
                if (mb_strlen($cleanSentence) > 10) {
                    $quickPoints[] = $cleanSentence;
                }
            }
            if (empty($quickPoints)) {
                $quickPoints = [trim(strip_tags($summaryText))];
            }
        }
        ?>

        <?php if (!empty($quickPoints)): ?>
            <div class="relative bg-gradient-to-br from-[#0c162d] via-[#0f172a] to-[#0a1122] text-slate-100 rounded-2xl p-5 sm:p-7 border-r-4 border-amber-400 border border-blue-900/50 shadow-xl shadow-blue-950/30 overflow-hidden my-6">
                <!-- Ambient Glow Elements -->
                <div class="absolute -left-12 -top-12 w-48 h-48 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -right-12 -bottom-12 w-40 h-40 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- Header -->
                <div class="flex items-center justify-between gap-3 mb-4 relative z-10">
                    <div class="flex items-center gap-2.5 text-white font-black text-base sm:text-lg">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400 shadow-md shadow-amber-400/70 inline-block animate-pulse"></span>
                        <span>خلاصه سریع</span>
                    </div>
                    <span class="text-[10px] sm:text-[11px] font-bold px-2.5 py-1 rounded-lg bg-blue-950/90 border border-blue-700/50 text-blue-300 shadow-sm flex items-center gap-1.5">
                        <i class="fas fa-bolt text-amber-400 text-[10px]"></i>
                        <span>نکات کلیدی مقاله</span>
                    </span>
                </div>

                <!-- Bullet Points (Cafe Danesh Style with Royal Navy Theme) -->
                <div class="space-y-2.5 relative z-10">
                    <?php foreach ($quickPoints as $point): ?>
                        <div class="flex items-start gap-3 bg-[#131f38]/85 border border-blue-900/40 hover:border-blue-500/50 hover:bg-[#182645] rounded-xl p-3.5 sm:p-4 text-xs sm:text-sm text-slate-100 leading-relaxed transition-all duration-200">
                            <span class="w-5 h-5 rounded-lg bg-amber-400/10 text-amber-400 border border-amber-400/30 flex items-center justify-center text-xs font-black flex-shrink-0 mt-0.5 select-none shadow-sm">✓</span>
                            <span class="font-normal text-slate-200"><?= e($point) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($article['featured_image'])): ?>
            <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-slate-800 shadow-md aspect-[21/9] sm:aspect-[2/1] bg-slate-900 relative">
                <img src="<?= e($article['featured_image']) ?>" 
                     alt="تصویر شاخص <?= e($article['title']) ?> - محمد مفتخری" 
                     class="w-full h-full object-cover object-center"
                     loading="eager">
            </div>
        <?php endif; ?>
    </header>

    <!-- Article Body -->
    <article class="bg-white dark:bg-slate-900 rounded-2xl border border-gray-200 dark:border-slate-800 p-6 sm:p-10 shadow-sm space-y-6 text-gray-800 dark:text-slate-200 leading-relaxed text-sm sm:text-base">
        <style>
            /* Explicit Heading & Typography Hierarchy (Royal Navy Theme) */
            .article-content h2 {
                font-size: 1.4rem !important;
                line-height: 1.6 !important;
                font-weight: 900 !important;
                color: #0F172A !important;
                margin-top: 2.25rem !important;
                margin-bottom: 1rem !important;
                padding-right: 0.875rem !important;
                border-right: 4px solid #1E3A8A !important;
                display: block !important;
            }
            .dark .article-content h2 {
                color: #FFFFFF !important;
                border-right-color: #3B82F6 !important;
            }
            @media (min-width: 640px) {
                .article-content h2 {
                    font-size: 1.75rem !important;
                }
            }

            .article-content h3 {
                font-size: 1.2rem !important;
                line-height: 1.6 !important;
                font-weight: 800 !important;
                color: #1E3A8A !important;
                margin-top: 1.75rem !important;
                margin-bottom: 0.75rem !important;
                padding-right: 0.625rem !important;
                border-right: 3px solid #93C5FD !important;
                display: block !important;
            }
            .dark .article-content h3 {
                color: #60A5FA !important;
                border-right-color: #2563EB !important;
            }
            @media (min-width: 640px) {
                .article-content h3 {
                    font-size: 1.35rem !important;
                }
            }

            .article-content h4 {
                font-size: 1.1rem !important;
                line-height: 1.5 !important;
                font-weight: 700 !important;
                color: #1E293B !important;
                margin-top: 1.5rem !important;
                margin-bottom: 0.5rem !important;
                display: block !important;
            }
            .dark .article-content h4 {
                color: #E2E8F0 !important;
            }

            .article-content h5, .article-content h6 {
                font-size: 1rem !important;
                font-weight: 700 !important;
                color: #334155 !important;
                margin-top: 1.25rem !important;
                margin-bottom: 0.5rem !important;
                display: block !important;
            }
            .dark .article-content h5, .dark .article-content h6 {
                color: #CBD5E1 !important;
            }

            .article-content p {
                font-size: 0.95rem !important;
                line-height: 2 !important;
                color: #334155 !important;
                margin-bottom: 1.25rem !important;
            }
            .dark .article-content p {
                color: #CBD5E1 !important;
            }
            @media (min-width: 640px) {
                .article-content p {
                    font-size: 1rem !important;
                }
            }

            .article-content ul {
                list-style-type: disc !important;
                padding-right: 1.5rem !important;
                margin-top: 0.75rem !important;
                margin-bottom: 1.25rem !important;
            }
            .article-content ol {
                list-style-type: decimal !important;
                padding-right: 1.5rem !important;
                margin-top: 0.75rem !important;
                margin-bottom: 1.25rem !important;
            }
            .article-content li {
                margin-bottom: 0.5rem !important;
                line-height: 1.9 !important;
                color: #334155 !important;
            }
            .dark .article-content li {
                color: #CBD5E1 !important;
            }
            .article-content li strong {
                color: #0F172A !important;
                font-weight: 800 !important;
            }
            .dark .article-content li strong {
                color: #FFFFFF !important;
            }

            .article-content a {
                color: #1E3A8A !important;
                font-weight: 700 !important;
                text-decoration: underline !important;
                text-underline-offset: 4px !important;
                transition: color 0.2s ease !important;
            }
            .dark .article-content a {
                color: #60A5FA !important;
            }
            .article-content a:hover {
                color: #2563EB !important;
            }
            .dark .article-content a:hover {
                color: #93C5FD !important;
            }

            .article-content blockquote {
                background: #F1F5F9 !important;
                border-right: 4px solid #1E3A8A !important;
                border-radius: 1rem !important;
                padding: 1.25rem 1.5rem !important;
                margin: 1.75rem 0 !important;
                color: #0F172A !important;
                box-shadow: 0 1px 3px rgba(0,0,0,0.04) !important;
            }
            .dark .article-content blockquote {
                background: #131F37 !important;
                border-right-color: #3B82F6 !important;
                border: 1px solid rgba(59, 130, 246, 0.25) !important;
                border-right-width: 4px !important;
                color: #F1F5F9 !important;
            }
            .article-content blockquote strong {
                color: #1E3A8A !important;
                font-weight: 800 !important;
                display: block !important;
                margin-bottom: 0.5rem !important;
                font-size: 1rem !important;
            }
            .dark .article-content blockquote strong {
                color: #60A5FA !important;
            }
        </style>

        <div class="article-content prose prose-slate dark:prose-invert max-w-none space-y-4 text-gray-800 dark:text-slate-200 leading-relaxed text-sm sm:text-base">
            <?php
            $rawArticleContent = $article['content'] ?? '';
            // ۱. حذف هرگونه بلوک تکراری قبلی Direct Answer / پاسخ مستقیم از داخل متن HTML
            $cleanArticleContent = preg_replace('/<div[^>]*class="[^"]*bg-gradient-to-r[^"]*"[^>]*>[\s\S]*?<\/div>\s*<\/div>/ui', '', $rawArticleContent);
            if ($cleanArticleContent === null || $cleanArticleContent === $rawArticleContent) {
                $cleanArticleContent = preg_replace('/<div[^>]*class="[^"]*(?:bg-gradient|border-blue)[^"]*"[^>]*>[\s\S]*?<\/p>\s*<\/div>/ui', '', $rawArticleContent);
            }
            if ($cleanArticleContent === null) {
                $cleanArticleContent = $rawArticleContent;
            }

            // ۲. حذف هوشمند تصاویر تکراری (یک‌پاس یکپارچه بدون تداخل تگ‌ها)
            $seenImageSignatures = [];
            
            // ثبت اثرانگشت تصویر شاخص
            if (!empty($article['featured_image'])) {
                $featUrl = trim($article['featured_image']);
                if (preg_match('/photos\/(\d+)/i', $featUrl, $pm)) {
                    $seenImageSignatures['photo_' . $pm[1]] = true;
                }
                $basename = basename(parse_url($featUrl, PHP_URL_PATH) ?? '');
                if (!empty($basename)) {
                    $seenImageSignatures['file_' . $basename] = true;
                }
                $seenImageSignatures['url_' . $featUrl] = true;
            }

            // فیلتر یکپارچه: بررسی figure و img های مستقل در یک مرحله
            $cleanArticleContent = preg_replace_callback(
                '/(<figure\b[^>]*>[\s\S]*?<img\b[^>]+src=["\']([^"\']+)["\'][^>]*>[\s\S]*?<\/figure>|<img\b[^>]+src=["\']([^"\']+)["\'][^>]*>)/ui',
                function ($matches) use (&$seenImageSignatures) {
                    $src = trim(!empty($matches[2]) ? $matches[2] : ($matches[3] ?? ''));
                    if (empty($src)) {
                        return $matches[0];
                    }

                    $sigKey = null;
                    if (preg_match('/photos\/(\d+)/i', $src, $pm)) {
                        $sigKey = 'photo_' . $pm[1];
                    } else {
                        $basename = basename(parse_url($src, PHP_URL_PATH) ?? '');
                        $sigKey = !empty($basename) ? 'file_' . $basename : 'url_' . $src;
                    }

                    if (isset($seenImageSignatures[$sigKey])) {
                        return ''; // حذف عنصر تکراری
                    }

                    $seenImageSignatures[$sigKey] = true;
                    return $matches[0];
                },
                $cleanArticleContent
            );

            // ۳. حذف هرگونه بخش پرسش‌های متداول یا FAQ از داخل بدنه متن خام تا در بخش اختصاصی آکاردئون نمایش یابد
            $cleanArticleContent = preg_replace('/<(?:h[2-4]|div|section)[^>]*>(?:[\s\S]*?)(?:پرسش‌های\s*متداول|پرسش\s*های\s*متداول|سوالات\s*متداول|سوال\s*های\s*متداول|FAQ)(?:[\s\S]*?)<\/(?:h[2-4]|div|section)>[\s\S]*?(?=<h[2-3]|<section class="pt-8|<!-- Author Bio|\Z)/ui', '', $cleanArticleContent);
            if ($cleanArticleContent === null) {
                $cleanArticleContent = $rawArticleContent;
            }

            // ۴. تضمین قطعی وجود ۲ تصویر باکیفیت Pexels در بدنه محتوا
            preg_match_all('/<img\b/i', $cleanArticleContent, $existingImgs);
            $imgCount = count($existingImgs[0] ?? []);

            if ($imgCount < 2) {
                $categoryFallbackPexels = [
                    'سئوی تکنیکال و پرفورمنس'    => [
                        'https://images.pexels.com/photos/1181244/pexels-photo-1181244.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                        'https://images.pexels.com/photos/1181675/pexels-photo-1181675.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
                    ],
                    'اتوماسیون هوش مصنوعی'       => [
                        'https://images.pexels.com/photos/3861969/pexels-photo-3861969.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                        'https://images.pexels.com/photos/8386440/pexels-photo-8386440.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
                    ],
                    'طراحی لندینگ‌پیج و نرخ تبدیل' => [
                        'https://images.pexels.com/photos/3183150/pexels-photo-3183150.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                        'https://images.pexels.com/photos/3182773/pexels-photo-3182773.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
                    ],
                    'سئوی محلی و گوگل مپ'        => [
                        'https://images.pexels.com/photos/7413936/pexels-photo-7413936.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                        'https://images.pexels.com/photos/19891030/pexels-photo-19891030.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
                    ],
                    'استراتژی و مشاوره سئو'       => [
                        'https://images.pexels.com/photos/3183197/pexels-photo-3183197.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                        'https://images.pexels.com/photos/7947666/pexels-photo-7947666.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
                    ],
                    'طراحی سایت و کدنویسی اختصاصی' => [
                        'https://images.pexels.com/photos/574071/pexels-photo-574071.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1',
                        'https://images.pexels.com/photos/270348/pexels-photo-270348.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1'
                    ]
                ];
                
                $catName = $categoryInfo['name'] ?? 'سئوی تکنیکال و پرفورمنس';
                $pickedPexels = $categoryFallbackPexels[$catName] ?? $categoryFallbackPexels['سئوی تکنیکال و پرفورمنس'];
                
                $engine = new \App\Services\AiContentEngine();
                $cleanArticleContent = $engine->injectBodyImagesIntoContent($cleanArticleContent, $pickedPexels, $article['title']);
            }

            // ۵. تبدیل و رندر کامل Markdown به HTML استاندارد و بدون نقص
            $formatMarkdownToHtml = function($text) {
                if (empty($text)) return '';
                
                // استانداردسازی خطوط جدید
                $text = str_replace(["\r\n", "\r"], "\n", $text);

                // حذف کلمه markdown در شروع بلاک‌ها
                $text = preg_replace('/^\s*```?\s*markdown\s*$/mi', '', $text);

                // تبدیل جریان‌های فرآیندی مرحله‌ای به کارت‌های شکیل فرآیندی با آیکون فلش
                $text = preg_replace_callback('/((?:^\[[^\]]+\]\s*\n\s*[│|]\s*\n\s*[▼v]\s*\n)+^\[[^\]]+\])/mu', function($m) {
                    $raw = $m[1];
                    preg_match_all('/\[([^\]]+)\]/u', $raw, $nodes);
                    if (empty($nodes[1])) return $m[0];
                    
                    $html = '<div class="my-6 space-y-2 max-w-xl mx-auto">';
                    foreach ($nodes[1] as $idx => $nodeText) {
                        $nodeText = trim($nodeText);
                        if ($idx > 0) {
                            $html .= '<div class="flex justify-center text-accent dark:text-blue-400 py-1"><i class="fas fa-arrow-down text-xs animate-bounce"></i></div>';
                        }
                        $html .= '<div class="bg-slate-50 dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700 rounded-xl p-3.5 text-center text-xs sm:text-sm font-bold text-textMain dark:text-white shadow-sm flex items-center justify-center gap-2.5">';
                        $html .= '<span class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/60 text-accent dark:text-blue-300 flex items-center justify-center text-xs font-mono font-black shrink-0">' . ($idx + 1) . '</span>';
                        $html .= '<span>' . htmlspecialchars($nodeText, ENT_QUOTES, 'UTF-8') . '</span>';
                        $html .= '</div>';
                    }
                    $html .= '</div>';
                    return $html;
                }, $text);

                // پاکسازی خطوط تک‌فلش سرگردان
                $text = preg_replace('/^\s*[│|]\s*$\n^\s*[▼v]\s*$/mu', '', $text);
                $text = preg_replace('/^\s*[│|▼]\s*$/mu', '', $text);

                // تبدیل کدهای چندخطی یا بلاک‌های کد
                $text = preg_replace_callback('/```(?:[a-zA-Z0-9_\-]+)?\n([\s\S]*?)```/u', function($m) {
                    return '<div class="overflow-x-auto my-5"><pre class="bg-[#0B1120] text-blue-300 p-4 rounded-xl text-xs font-mono border border-slate-800 dir-ltr text-left leading-relaxed"><code>' . htmlspecialchars($m[1], ENT_QUOTES, 'UTF-8') . '</code></pre></div>';
                }, $text);

                // تبدیل دیاگرام‌های ASCII و جعبه‌ها (فقط اگر بلوک کامل باشد)
                $text = preg_replace_callback('/((?:^[^\n]*[─┌┐└┘├┤┼──►◄][^\n]*$\n?){3,})/um', function($m) {
                    return '<div class="overflow-x-auto my-5"><pre class="bg-[#0B1120] text-emerald-400 p-4 rounded-xl text-xs font-mono border border-slate-800 dir-ltr text-left leading-relaxed">' . htmlspecialchars(trim($m[1]), ENT_QUOTES, 'UTF-8') . '</pre></div>';
                }, $text);

                // تبدیل جداول مارک‌داون به جدول خوش‌ساخت و واکنش‌گرا
                $text = preg_replace_callback('/((?:^\|.+?\|\n)+)/m', function($match) {
                    $lines = array_filter(array_map('trim', explode("\n", trim($match[1]))));
                    if (count($lines) < 2) return $match[0];
                    
                    $tableHtml = '<div class="overflow-x-auto my-6"><table class="w-full text-right border-collapse rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 text-xs sm:text-sm shadow-sm">';
                    $isHeader = true;
                    $hasTbody = false;
                    
                    foreach ($lines as $i => $line) {
                        if (preg_match('/^\|[\s\-:|]+\|$/', $line)) {
                            $isHeader = false;
                            $tableHtml .= '</thead><tbody class="divide-y divide-slate-200 dark:divide-slate-800">';
                            $hasTbody = true;
                            continue;
                        }
                        
                        $cells = array_values(array_filter(array_map('trim', explode('|', $line)), function($c) { return $c !== ''; }));
                        if ($isHeader && $i === 0) {
                            $tableHtml .= '<thead class="bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold"><tr>';
                            foreach ($cells as $cell) {
                                $tableHtml .= '<th class="p-3.5 border-b border-slate-200 dark:border-slate-700">' . $cell . '</th>';
                            }
                            $tableHtml .= '</tr>';
                        } else {
                            $bgClass = ($i % 2 === 0) ? 'bg-white dark:bg-slate-900' : 'bg-slate-50/50 dark:bg-slate-850/50';
                            $tableHtml .= '<tr class="' . $bgClass . '">';
                            foreach ($cells as $cell) {
                                $tableHtml .= '<td class="p-3.5 text-slate-700 dark:text-slate-300">' . $cell . '</td>';
                            }
                            $tableHtml .= '</tr>';
                        }
                    }
                    if ($hasTbody) {
                        $tableHtml .= '</tbody>';
                    }
                    $tableHtml .= '</table></div>';
                    return $tableHtml;
                }, $text);

                // تبدیل خطوط جداکننده مارک‌داون
                $text = preg_replace('/^\s*---\s*$/m', '<hr class="my-6 border-slate-200 dark:border-slate-800">', $text);

                // تبدیل هدینگ‌های مارک‌داون
                $text = preg_replace('/^####\s+(.*?)$/m', '<h4>$1</h4>', $text);
                $text = preg_replace('/^###\s+(.*?)$/m', '<h3>$1</h3>', $text);
                $text = preg_replace('/^##\s+(.*?)$/m', '<h2>$1</h2>', $text);
                $text = preg_replace('/^#\s+(.*?)$/m', '<h2>$1</h2>', $text);

                // تبدیل لیست‌های بالت‌پوینت مارک‌داون (قبل از ایتالیک تا با * تداخل نکند)
                $text = preg_replace_callback('/((?:^\s*[-*•]\s+.+$\n?)+)/m', function($match) {
                    $items = preg_split('/\n/', trim($match[1]));
                    $html = '<ul class="list-disc pr-6 my-4 space-y-2">';
                    foreach ($items as $item) {
                        $cleaned = preg_replace('/^\s*[-*•]\s+/', '', trim($item));
                        if (!empty($cleaned)) {
                            $html .= '<li class="text-slate-700 dark:text-slate-300 leading-relaxed">' . $cleaned . '</li>';
                        }
                    }
                    $html .= '</ul>';
                    return $html;
                }, $text);

                // تبدیل لیست‌های عددی مارک‌داون
                $text = preg_replace_callback('/((?:^\s*\d+\.\s+.+$\n?)+)/m', function($match) {
                    $items = preg_split('/\n/', trim($match[1]));
                    $html = '<ol class="list-decimal pr-6 my-4 space-y-2">';
                    foreach ($items as $item) {
                        $cleaned = preg_replace('/^\s*\d+\.\s+/', '', trim($item));
                        if (!empty($cleaned)) {
                            $html .= '<li class="text-slate-700 dark:text-slate-300 leading-relaxed">' . $cleaned . '</li>';
                        }
                    }
                    $html .= '</ol>';
                    return $html;
                }, $text);

                // تبدیل بولد و ایتالیک
                $text = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $text);
                $text = preg_replace('/(?<!\*)\*(?!\*)(.*?)(?<!\*)\*(?!\*)/s', '<em>$1</em>', $text);

                // تمیزکاری تگ‌های اضافی متداخل داخل پاراگراف‌ها
                $blocks = preg_split('/\n{2,}/', $text);
                $formattedBlocks = [];
                foreach ($blocks as $block) {
                    $trimmed = trim($block);
                    if (empty($trimmed)) continue;
                    if (preg_match('/^<(?:h[1-6]|p|div|section|table|ul|ol|figure|blockquote|hr|pre)\b/i', $trimmed)) {
                        $formattedBlocks[] = $trimmed;
                    } else {
                        $formattedBlocks[] = '<p>' . nl2br($trimmed) . '</p>';
                    }
                }
                
                $finalHtml = implode("\n\n", $formattedBlocks);
                // رفع باگ تگ‌های متداخل p و h2/hr
                $finalHtml = preg_replace('/<p>\s*(<(?:h[1-6]|div|section|table|ul|ol|figure|blockquote|hr|pre)\b[\s\S]*?<\/(?:h[1-6]|div|section|table|ul|ol|figure|blockquote|pre)>|<hr[^>]*>)\s*<\/p>/ui', '$1', $finalHtml);
                $finalHtml = preg_replace('/<p>\s*<br\s*\/?>\s*/ui', '<p>', $finalHtml);
                $finalHtml = preg_replace('/\s*<br\s*\/?>\s*<\/p>/ui', '</p>', $finalHtml);
                
                return $finalHtml;
            };

            $cleanArticleContent = $formatMarkdownToHtml($cleanArticleContent);
            echo trim($cleanArticleContent);
            ?>
        </div>

        <!-- FAQ Section (سوالات متداول با طراحی آکاردئون و اسکیما) -->
        <?php if (!empty($faqs)): ?>
            <div class="pt-8 border-t border-gray-200 dark:border-slate-800 mt-8 space-y-4">
                <div class="flex items-center gap-2.5 text-textMain dark:text-white font-black text-lg sm:text-xl">
                    <span class="w-3 h-3 rounded-full bg-accent dark:bg-blue-500 inline-block"></span>
                    <h3>پرسش‌های متداول</h3>
                </div>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 font-normal">
                    پاسخ‌های شفاف و تخصصی به پرتکرارترین سوالات این مقاله
                </p>
                <div class="space-y-3 pt-2" id="article-faq-accordion">
                    <?php foreach ($faqs as $i => $faq): ?>
                        <div class="border border-gray-200 dark:border-slate-700/80 rounded-2xl bg-slate-50/70 dark:bg-slate-800/60 overflow-hidden transition-all duration-200 shadow-sm hover:border-accent/40 dark:hover:border-blue-500/40">
                            <button type="button" class="faq-toggle w-full px-5 sm:px-6 py-4 text-right flex items-center justify-between gap-4 focus:outline-none cursor-pointer" aria-expanded="false" data-target="art-faq-<?= $i ?>">
                                <span class="text-xs sm:text-sm font-bold text-textMain dark:text-slate-100"><?= e($faq['question']) ?></span>
                                <span class="faq-icon shrink-0 w-7 h-7 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 transition-transform duration-300 shadow-sm">
                                    <i class="fas fa-chevron-down text-[10px]"></i>
                                </span>
                            </button>
                            <div id="art-faq-<?= $i ?>" class="faq-content max-h-0 overflow-hidden transition-all duration-300 ease-in-out px-5 sm:px-6">
                                <p class="text-slate-600 dark:text-slate-300 text-xs sm:text-sm leading-relaxed pb-4 border-t border-gray-200 dark:border-slate-700/80 pt-3 font-normal">
                                    <?= e($faq['answer']) ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- Author Bio Box -->
        <div class="pt-8 border-t border-gray-200 dark:border-slate-800 mt-8 flex flex-col sm:flex-row items-center gap-5 bg-slate-50 dark:bg-slate-800/60 p-6 rounded-2xl border border-gray-200 dark:border-slate-700">
            <img src="/assets/images/mohammadmoftakhari.jpg" alt="محمد مفتخری" class="w-16 h-16 rounded-2xl object-cover border-2 border-accent/20">
            <div class="space-y-1 text-center sm:text-right">
                <h4 class="font-bold text-textMain dark:text-white text-sm">درباره نویسنده: محمد مفتخری</h4>
                <p class="text-xs text-gray-600 dark:text-slate-300 leading-relaxed">
                    کارشناس سئو و مدیر پروژه دیجیتال مارکتینگ با ۶ سال سابقه در طراحی و اجرای استراتژی‌های سئو تکنیکال، سئو معنایی و هوش مصنوعی.
                </p>
            </div>
        </div>
    </article>

    <!-- Bottom CTA -->
    <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white rounded-3xl p-8 text-center space-y-4">
        <h3 class="text-xl sm:text-2xl font-black">نیاز به اجرای این استراتژی‌ها روی سایت خود دارید؟</h3>
        <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto leading-relaxed">
            جهت مشاوره تخصصی یا ممیزی سئوی فنی وب‌سایت، فرم بریف را ارسال کنید تا در اسرع وقت با شما تماس گرفته شود.
        </p>
        <a href="/#smart-brief" class="inline-flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-bold px-6 py-3 rounded-xl transition text-xs shadow-md">
            <i class="fas fa-file-signature"></i>
            تکمیل فرم بریف و مشاوره سئو
        </a>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const toggles = document.querySelectorAll('.faq-toggle');
    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const targetId = toggle.getAttribute('data-target');
            const content = document.getElementById(targetId);
            const icon = toggle.querySelector('.faq-icon');
            const isExpanded = toggle.getAttribute('aria-expanded') === 'true';

            toggles.forEach(otherToggle => {
                if (otherToggle !== toggle) {
                    const otherTargetId = otherToggle.getAttribute('data-target');
                    const otherContent = document.getElementById(otherTargetId);
                    const otherIcon = otherToggle.querySelector('.faq-icon');
                    if (otherContent) otherContent.style.maxHeight = null;
                    if (otherIcon) otherIcon.style.transform = 'rotate(0deg)';
                    otherToggle.setAttribute('aria-expanded', 'false');
                }
            });

            if (isExpanded) {
                content.style.maxHeight = null;
                icon.style.transform = 'rotate(0deg)';
                toggle.setAttribute('aria-expanded', 'false');
            } else {
                content.style.maxHeight = content.scrollHeight + 'px';
                icon.style.transform = 'rotate(180deg)';
                toggle.setAttribute('aria-expanded', 'true');
            }
        });
    });
});
</script>
