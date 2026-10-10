<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;

class PageContent
{
    private static ?bool $tableChecked = null;

    /**
     * اطمینان از وجود جدول page_contents در دیتابیس با فال‌بک خودکار
     */
    private static function ensureTable(): void
    {
        if (self::$tableChecked === true) {
            return;
        }

        try {
            Database::execute("
                CREATE TABLE IF NOT EXISTS `page_contents` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `slug` VARCHAR(100) NOT NULL UNIQUE,
                    `name` VARCHAR(150) NOT NULL,
                    `seo_title` VARCHAR(255) NULL,
                    `meta_description` TEXT NULL,
                    `h1_title` VARCHAR(255) NULL,
                    `badge_text` VARCHAR(150) NULL,
                    `subtitle` TEXT NULL,
                    `content_html` LONGTEXT NULL,
                    `faqs_json` LONGTEXT NULL,
                    `cta_title` VARCHAR(255) NULL,
                    `cta_button` VARCHAR(100) NULL,
                    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    INDEX `idx_page_slug` (`slug`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
            self::$tableChecked = true;
        } catch (\Throwable $e) {
            self::$tableChecked = false;
        }
    }

    /**
     * لیست استاندارد صفحات و پیلارهای سیستم با اطلاعات اولیه
     */
    public static function getDefaultPages(): array
    {
        return [
            'technical-seo' => [
                'name'             => 'پیلار ۱: سئوی تکنیکال و بهینه‌سازی سرعت وردپرس',
                'url'              => '/services/technical-seo',
                'icon'             => 'fa-bolt',
                'color'            => 'text-cyan-400',
                'badge'            => 'Technical SEO & Speed',
                'h1_title'         => 'بهینه‌سازی فنی وردپرس، نجات سرعت و تیونینگ دیتابیس',
                'badge_text'       => 'مهندسی عملکرد و زیرساخت وردپرس | محمد مفتخری',
                'subtitle'         => 'حل ریشه‌ای خطاهای Core Web Vitals (LCP, INP, CLS)، پاکسازی عمیق دیتابیس، کانفیگ اختصاصی وب‌سرور LiteSpeed Enterprise و ارتقای امتیاز PageSpeed به بالای ۹۰.',
                'seo_title'        => 'بهینه‌سازی فنی وردپرس و سرعت | سئو تکنیکال محمد مفتخری',
                'meta_description' => 'خدمات تخصصی سئوی تکنیکال وردپرس، تیونینگ سرور لایت‌اسپید، پاکسازی دیتابیس و پاس کردن معیارهای Core Web Vitals با گارانتی عملکردی توسط محمد مفتخری.',
                'cta_title'        => 'آماده‌اید سرعت و زیرساخت فنی سایتتان را متحول کنید؟',
                'cta_button'       => 'شروع بهینه‌سازی فنی و سرعت'
            ],
            'ai-automation' => [
                'name'             => 'پیلار ۲: اتوماسیون هوش مصنوعی و سیستم‌سازی محتوا',
                'url'              => '/services/ai-automation',
                'icon'             => 'fa-robot',
                'color'            => 'text-indigo-400',
                'badge'            => 'AI Integration & Automation',
                'h1_title'         => 'سیستم‌سازی تولید محتوا با هوش مصنوعی و Gemini API',
                'badge_text'       => 'طراحی پایپ‌لاین‌های اختصاصی هوش مصنوعی | محمد مفتخری',
                'subtitle'         => 'پیاده‌سازی پایپ‌لاین‌های هوشمند متصل به APIهای Gemini برای تولید مقالات غنی، خوشه‌بندی کلمات کلیدی، لینک‌سازی خودکار و پایش رقبا بدون افت کیفیت انسانی.',
                'seo_title'        => 'اتوماسیون هوش مصنوعی و سیستم‌سازی محتوا | محمد مفتخری',
                'meta_description' => 'سیستم‌سازی و تولید محتوای سئوشده با هوش مصنوعی گوگل (Gemini API)، لینک‌سازی خودکار داخلی و پایپ‌لاین‌های اختصاصی وردپرس توسط محمد مفتخری.',
                'cta_title'        => 'می‌خواهید فرآیند تولید محتوای سایتتان را ۱۰ برابر سریع‌تر کنید؟',
                'cta_button'       => 'سفارش پایپ‌لاین هوش مصنوعی'
            ],
            'local-seo' => [
                'name'             => 'پیلار ۳: سئوی محلی و تسخیر نقشه‌های گوگل، نشان و بلد',
                'url'              => '/services/local-seo',
                'icon'             => 'fa-map-location-dot',
                'color'            => 'text-emerald-400',
                'badge'            => 'Local SEO & Maps',
                'h1_title'         => 'تسخیر نتایج محلی گوگل؛ مشتریان همسایه را به رقیب ندهید',
                'badge_text'       => 'استراتژیست سئوی محلی و مدیریت نقشه‌ها | محمد مفتخری',
                'subtitle'         => 'ثبت، وریفای و بهینه‌سازی پروفایل در Google Maps، نشان و بلد به همراه پیاده‌سازی اسکیماهای لوکال بیزینس و یکپارچه‌سازی NAP برای جذب بیشترین تماس و فروش فیزیکی.',
                'seo_title'        => 'سئوی محلی و تسخیر نقشه‌های گوگل، نشان و بلد | محمد مفتخری',
                'meta_description' => 'خدمات سئوی محلی (Local SEO)، بهینه‌سازی گوگل مپ، ثبت در نشان و بلد و پیاده‌سازی لوکال اسکیما برای جذب تماس‌های منطقه‌ای با محمد مفتخری.',
                'cta_title'        => 'کسب‌وکار خود را صدر نتایج نقشه و جستجوهای محلی بنشانید',
                'cta_button'       => 'مشاوره سئوی محلی'
            ],
            'landing-page-cro' => [
                'name'             => 'پیلار ۴: طراحی لندینگ‌پیج‌های دیتامحور و بهینه‌سازی نرخ تبدیل (CRO)',
                'url'              => '/services/landing-page-design-cro',
                'icon'             => 'fa-layer-group',
                'color'            => 'text-amber-400',
                'badge'            => 'Landing Page Design & CRO',
                'h1_title'         => 'طراحی لندینگ‌پیج و افزایش نرخ تبدیل؛ جذب سرنخ‌های آماده خرید',
                'badge_text'       => 'مهندسی تبدیل و تجربه کاربری B2B | محمد مفتخری',
                'subtitle'         => 'طراحی اختصاصی صفحات فرود پرفروش با رعایت اصول روانشناسی تبدیل، بهینه‌سازی فرم‌های لید و سازگاری کامل با الگوریتم‌های هوش مصنوعی مولد گوگل (GEO/SGE).',
                'seo_title'        => 'طراحی صفحات فرود دیتامحور و CRO | محمد مفتخری',
                'meta_description' => 'طراحی تخصصی لندینگ‌پیج و بهینه‌سازی نرخ تبدیل (CRO) با رویکرد داده‌محور و بهینه‌سازی برای هوش مصنوعی (GEO) توسط محمد مفتخری.',
                'cta_title'        => 'میزان فروش و تماس‌های لندینگ‌پیج خود را چند برابر کنید',
                'cta_button'       => 'سفارش طراحی لندینگ CRO'
            ],
            'seo-strategy' => [
                'name'             => 'پیلار ۵: مشاوره، استراتژی و مدیریت جامع سئو',
                'url'              => '/services/seo-strategy',
                'icon'             => 'fa-compass',
                'color'            => 'text-blue-400',
                'badge'            => 'Enterprise SEO Strategy',
                'h1_title'         => 'استراتژی جامع سئو و معماری رشد ارگانیک سازمانی',
                'badge_text'       => 'مشاور و معمار استراتژی‌های کلان سئو | محمد مفتخری',
                'subtitle'         => 'تدوین نقشه راه اختصاصی رشد سئو، معماری پیلار-کلاستر، تحلیل عمیق رقبا و پیاده‌سازی سئو برای موتورهای جستجوی تولیدی (GEO, AEO) با ۶ سال تجربه میدانی.',
                'seo_title'        => 'مشاوره و استراتژی کلان سئو سازمانی | محمد مفتخری',
                'meta_description' => 'تدوین نقشه راه و استراتژی جامع سئو، کانتنت کلاسترینگ و هدایت کمپین‌های رشد ارگانیک در آژانس دیجیتال مارکتینگ اینتن توسط محمد مفتخری.',
                'cta_title'        => 'برای کسب سهم بازار و رتبه‌های پایدار آماده‌اید؟',
                'cta_button'       => 'دریافت استراتژی اختصاصی'
            ],
            'custom-web-development' => [
                'name'             => 'پیلار ۶: طراحی سایت اختصاصی و فروشگاهی (Coding Vibe)',
                'url'              => '/services/custom-web-development',
                'icon'             => 'fa-code',
                'color'            => 'text-emerald-400',
                'badge'            => 'Pure Coding & High Performance',
                'h1_title'         => 'طراحی سایتِ اختصاصی؛ بدون قالب‌های آماده، بدون صفحه‌سازهای سنگین',
                'badge_text'       => 'توسعه‌دهنده فول‌استک و متخصص پرفورمنس | محمد مفتخری',
                'subtitle'         => 'من سایت شما را دقیقاً با همان معماری، سرعت و وایب کدینگِ سایت خودم (سلیاپ) می‌سازم. خداحافظی با المنتور و کدهای اضافه؛ سلام به پرفورمنس ۱۰۰٪ با PHP و Tailwind CSS.',
                'seo_title'        => 'طراحی سایت اختصاصی و پرسرعت با وایب کدینگ | محمد مفتخری',
                'meta_description' => 'طراحی و برنامه‌نویسی سایت‌های اختصاصی، شرکتی و فروشگاهی بدون المنتور با PHP و Tailwind CSS، سرعت لود زیر ۱ ثانیه و معماری آماده سئو و هوش مصنوعی.',
                'cta_title'        => 'سفارش سایت اختصاصی (بدون باگ و قطعی)',
                'cta_button'       => 'سفارش توسعه اختصاصی'
            ],
            'mcp-automation' => [
                'name'             => 'پیلار ۷: اتوماسیون هوش مصنوعی و پروتکل MCP',
                'url'              => '/services/mcp-automation',
                'icon'             => 'fa-network-wired',
                'color'            => 'text-blue-400',
                'badge'            => 'AI Automation & MCP Integration',
                'h1_title'         => 'اتصال مستقیم هوش مصنوعی به سایت، دیتابیس و برنامه‌های کسب‌وکار شما',
                'badge_text'       => 'اتصال هوش مصنوعی به سیستم‌های کاری با پروتکل MCP | محمد مفتخری',
                'subtitle'         => 'هوش مصنوعی را از یک چت‌بات ساده به یک دستیار اجرایی تبدیل کنید که می‌تواند به دیتابیس شما متصل شود، وضعیت سئوی سایت را بررسی کند، گزارش فروش تهیه کند و کارهای تکراری را بدون دخالت انسان انجام دهد.',
                'seo_title'        => 'اتصال هوش مصنوعی به سایت و دیتابیس با پروتکل MCP | محمد مفتخری',
                'meta_description' => 'خدمات اتصال هوش مصنوعی به دیتابیس، سایت و برنامه‌های کاری با استاندارد MCP؛ انجام خودکار کارهای تکراری، گزارش‌گیری و رصد سئو با محمد مفتخری.',
                'cta_title'        => 'می‌خواهید کارهای تکراری کسب‌وکارتان را به هوش مصنوعی بسپارید؟',
                'cta_button'       => 'دریافت مشاوره و راه‌اندازی'
            ],
            'mcp-simulator' => [
                'name'             => 'پیلار ۸: شبیه‌ساز هوش مصنوعی و پروتکل MCP',
                'url'              => '/services/mcp-simulator',
                'icon'             => 'fa-terminal',
                'color'            => 'text-cyan-400',
                'badge'            => 'Interactive AI Simulator',
                'h1_title'         => 'شبیه‌ساز هوش مصنوعی؛ مشاهده نحوه درک دستورات و اجرای خودکار کارها',
                'badge_text'       => 'تست زنده تصمیم‌گیری هوش مصنوعی | محمد مفتخری',
                'subtitle'         => 'یک دستور یا سوال را به زبان فارسی خودمانی بنویسید؛ هوش مصنوعی مقصود شما را درک کرده و ابزار مناسب برای اسکن سایت، جستجو در دیتابیس یا ارسال پیام را اجرا می‌کند.',
                'seo_title'        => 'شبیه‌ساز هوش مصنوعی و اجرای ابزارها (MCP) | محمد مفتخری',
                'meta_description' => 'تست زنده و تعاملی نحوه تصمیم‌گیری هوش مصنوعی و اجرای خودکار ابزارهای وب، دیتابیس و تلگرام بر پایه پروتکل MCP با محمد مفتخری.',
                'cta_title'        => 'می‌خواهید چنین سیستمی را برای کسب‌وکارتان داشته باشید؟',
                'cta_button'       => 'مشاوره و راه‌اندازی'
            ],
            'about' => [
                'name'             => 'صفحه اختصاصی: درباره من و سوابق',
                'url'              => '/about',
                'icon'             => 'fa-user-tie',
                'color'            => 'text-sky-400',
                'badge'            => 'About Mohammad Moftakhari',
                'h1_title'         => 'من فقط سئو نمی‌کنم؛ من ماشین‌های رشد می‌سازم',
                'badge_text'       => 'محمد مفتخری | Technical SEO & AI Automation Developer',
                'subtitle'         => 'تخصص در نقطه تلاقی مهندسی نرم‌افزار (PHP/JS)، دیباگ عمیق زیرساخت و دیتابیس و اتوماسیون‌های هوش مصنوعی (LLMs) با ۶ سال تجربه در آژانس اینتن.',
                'seo_title'        => 'درباره من | محمد مفتخری - متخصص سئو و GEO/AEO',
                'meta_description' => 'سوابق حرفه‌ای، دستاوردها، متدولوژی کاری و تجربیات زیسته محمد مفتخری، کارشناس ارشد سئو و مدیر پروژه در آژانس دیجیتال مارکتینگ اینتن.',
                'cta_title'        => 'آماده همکاری و رشد کسب‌وکار شما هستیم',
                'cta_button'       => 'تماس با من'
            ],
            'contact' => [
                'name'             => 'صفحه اختصاصی: تماس با من و مشاوره',
                'url'              => '/contact',
                'icon'             => 'fa-headset',
                'color'            => 'text-rose-400',
                'badge'            => 'Contact & Direct Lead',
                'h1_title'         => 'ارتباط مستقیم و درخواست مشاوره تخصصی سئو',
                'badge_text'       => 'مشاوره اختصاصی سئو و بررسی پروژه | محمد مفتخری',
                'subtitle'         => 'برای بررسی اختصاصی سایت، دریافت راهکارهای فنی و رفع موانع رشد، پیام بگذارید یا با من در تلگرام، واتساپ یا تلفنی تماس بگیرید.',
                'seo_title'        => 'تماس با محمد مفتخری | مشاوره و استعلام پروژه سئو',
                'meta_description' => 'راه‌های ارتباط مستقیم، مشاوره سئو، رزرو جلسه آنلاین و استعلام هزینه اجرای پروژه‌های بهینه‌سازی موتورهای جستجو با محمد مفتخری.',
                'cta_title'        => 'در کمتر از ۲۴ ساعت پاسخگوی شما خواهم بود',
                'cta_button'       => 'ارسال پیام'
            ]
        ];
    }

    /**
     * دریافت اطلاعات داینامیک یک صفحه
     */
    public static function getPage(string $slug): array
    {
        $defaults = self::getDefaultPages()[$slug] ?? [
            'name'             => $slug,
            'url'              => '/' . $slug,
            'icon'             => 'fa-file-lines',
            'color'            => 'text-slate-400',
            'badge'            => 'Page',
            'h1_title'         => '',
            'badge_text'       => '',
            'subtitle'         => '',
            'seo_title'        => '',
            'meta_description' => '',
            'content_html'     => '',
            'faqs_json'        => '[]',
            'cta_title'        => '',
            'cta_button'       => ''
        ];

        self::ensureTable();

        try {
            $row = Database::one("SELECT * FROM page_contents WHERE slug = ? LIMIT 1", [$slug]);
            if ($row) {
                // Merge database record over defaults
                return array_merge($defaults, array_filter($row, fn($v) => $v !== null && $v !== ''));
            }
        } catch (\Throwable $e) {
            // Fallback to site_settings or defaults
        }

        // Check site_settings fallback
        $settingJson = SiteSetting::get('page_content_' . $slug);
        if ($settingJson) {
            $decoded = json_decode($settingJson, true);
            if (is_array($decoded)) {
                return array_merge($defaults, $decoded);
            }
        }

        return $defaults;
    }

    /**
     * ذخیره اطلاعات صفحه
     */
    public static function savePage(string $slug, array $data): bool
    {
        self::ensureTable();

        $name = $data['name'] ?? (self::getDefaultPages()[$slug]['name'] ?? $slug);
        $seoTitle = $data['seo_title'] ?? null;
        $metaDescription = $data['meta_description'] ?? null;
        $h1Title = $data['h1_title'] ?? null;
        $badgeText = $data['badge_text'] ?? null;
        $subtitle = $data['subtitle'] ?? null;
        $contentHtml = $data['content_html'] ?? null;
        $faqsJson = is_array($data['faqs'] ?? null) ? json_encode($data['faqs'], JSON_UNESCAPED_UNICODE) : ($data['faqs_json'] ?? '[]');
        $ctaTitle = $data['cta_title'] ?? null;
        $ctaButton = $data['cta_button'] ?? null;

        // Also save to SiteSetting for 100% redundancy
        SiteSetting::set('page_content_' . $slug, json_encode([
            'name'             => $name,
            'seo_title'        => $seoTitle,
            'meta_description' => $metaDescription,
            'h1_title'         => $h1Title,
            'badge_text'       => $badgeText,
            'subtitle'         => $subtitle,
            'content_html'     => $contentHtml,
            'faqs_json'        => $faqsJson,
            'cta_title'        => $ctaTitle,
            'cta_button'       => $ctaButton,
        ], JSON_UNESCAPED_UNICODE));

        try {
            $exists = Database::one("SELECT id FROM page_contents WHERE slug = ? LIMIT 1", [$slug]);
            if ($exists) {
                return Database::execute("
                    UPDATE page_contents SET 
                        name = ?, seo_title = ?, meta_description = ?, h1_title = ?,
                        badge_text = ?, subtitle = ?, content_html = ?, faqs_json = ?,
                        cta_title = ?, cta_button = ?
                    WHERE slug = ?
                ", [
                    $name, $seoTitle, $metaDescription, $h1Title,
                    $badgeText, $subtitle, $contentHtml, $faqsJson,
                    $ctaTitle, $ctaButton, $slug
                ]);
            } else {
                return Database::execute("
                    INSERT INTO page_contents 
                    (slug, name, seo_title, meta_description, h1_title, badge_text, subtitle, content_html, faqs_json, cta_title, cta_button)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                ", [
                    $slug, $name, $seoTitle, $metaDescription, $h1Title,
                    $badgeText, $subtitle, $contentHtml, $faqsJson, $ctaTitle, $ctaButton
                ]);
            }
        } catch (\Throwable $e) {
            return true; // Already saved in SiteSetting
        }
    }

    /**
     * دریافت لیست تمام صفحات قابل ویرایش
     */
    public static function allPages(): array
    {
        $defaultPages = self::getDefaultPages();
        $pages = [];

        foreach ($defaultPages as $slug => $def) {
            $pages[$slug] = self::getPage($slug);
        }

        return $pages;
    }
}
