<div class="py-12 md:py-16 space-y-12">
    <!-- Header -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-100 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800/80 text-accent dark:text-blue-400 text-xs font-bold">
            <i class="fas fa-book-open-reader"></i>
            دانش تخصصی و مقالات کاربردی
        </div>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-textMain dark:text-white tracking-tight">
            وبلاگ استراتژیک و تکنیکال سئو
        </h1>
        <p class="text-gray-600 dark:text-slate-300 leading-relaxed text-sm sm:text-base">
            آموزش‌های عمیق و تجربیات عملی در زمینه سئو تکنیکال، معماری اسکیماهای JSON-LD، سئو محلی و بهینه‌سازی برای هوش مصنوعی (GEO/AEO).
        </p>
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
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
        foreach ($articles as $article): 
            $catInfo = $catMap[$article['schema_type'] ?? ''] ?? ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => '/services/technical-seo'];
        ?>
            <article class="bg-white dark:bg-slate-800/90 rounded-2xl border border-gray-200 dark:border-slate-700 p-6 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between group">
                <div class="space-y-4">
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-slate-400">
                        <a href="<?= e($catInfo['url']) ?>" class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 text-accent dark:text-blue-400 font-bold border border-blue-100 dark:border-blue-800/80 hover:bg-blue-100 dark:hover:bg-blue-900 transition">
                            <?= e($catInfo['name']) ?>
                        </a>
                        <span class="flex items-center gap-1 font-medium">
                            <i class="far fa-clock"></i>
                            <?= e($article['reading_time'] ?? 5) ?> دقیقه مطالعه
                        </span>
                    </div>

                    <?php if (!empty($article['featured_image'])): ?>
                        <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-slate-700 bg-slate-900 aspect-video relative group-hover:shadow-md transition">
                            <img src="<?= e($article['featured_image']) ?>" 
                                 alt="تصویر مقاله <?= e($article['title']) ?> - محمد مفتخری" 
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                 loading="lazy">
                        </div>
                    <?php endif; ?>

                    <h2 class="text-xl font-bold text-textMain dark:text-white group-hover:text-accent dark:group-hover:text-blue-400 transition leading-snug">
                        <a href="/article/<?= e($article['slug']) ?>">
                            <?= e($article['title']) ?>
                        </a>
                    </h2>

                    <p class="text-gray-600 dark:text-slate-300 text-sm leading-relaxed line-clamp-3">
                        <?= e($article['summary'] ?? $article['direct_answer']) ?>
                    </p>
                </div>

                <div class="pt-6 border-t border-gray-100 dark:border-slate-700/80 mt-6 flex items-center justify-between">
                    <a href="/article/<?= e($article['slug']) ?>" class="text-xs font-bold text-accent dark:text-blue-400 flex items-center gap-1.5 group-hover:gap-2.5 transition-all">
                        مطالعه مقاله کامل
                        <i class="fas fa-arrow-left text-[10px]"></i>
                    </a>
                    <span class="w-8 h-8 rounded-full bg-blue-50 dark:bg-slate-700 text-accent dark:text-blue-400 flex items-center justify-center text-xs group-hover:bg-accent dark:group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</div>
