<?php
declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\ProjectController as FrontProjectController;
use App\Controllers\ArticleController as FrontArticleController;
use App\Controllers\LeadController as FrontLeadController;
use App\Controllers\SitemapController;
use App\Controllers\AiBriefController;
use App\Controllers\ServiceController;
use App\Controllers\PageController;
use App\Controllers\TelegramBotController;
use App\Controllers\BaleBotController;

use App\Controllers\Admin\AuthController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\ProjectController;
use App\Controllers\Admin\ArticleController;
use App\Controllers\Admin\LeadController;
use App\Controllers\Admin\SettingController;
use App\Controllers\Admin\FaqController;
use App\Controllers\Admin\PageManagerController;
use App\Controllers\Admin\AiWriterController;
use App\Core\Router;

/** @var Router $router */

// ----------------------------------------------------------
// ۱. مسیرهای فرانت‌اند (Public Frontend Routes)
// ----------------------------------------------------------
$router->get('/', [HomeController::class, 'index']);

// ابزار هوشمند تولید نقشه راه سئو و ثبت درخواست (Smart SEO Roadmap)
$router->get('/seo-roadmap', [AiBriefController::class, 'index']);
$router->post('/seo-roadmap', [AiBriefController::class, 'index']);
$router->get('/ai-brief', [AiBriefController::class, 'index']);
$router->post('/ai-brief', [AiBriefController::class, 'index']);
$router->get('/roadmap', [AiBriefController::class, 'index']);
$router->post('/roadmap', [AiBriefController::class, 'index']);
$router->get('/roadmap-generator', [AiBriefController::class, 'index']);
$router->post('/roadmap-generator', [AiBriefController::class, 'index']);

// صفحات اختصاصی درباره من و تماس با من
$router->get('/about', [PageController::class, 'about']);
$router->get('/contact', [PageController::class, 'contact']);

// خدمات تخصصی و لندینگ پیلار سئوی تکنیکال (پیلار ۱)
$router->get('/services/technical-seo', [ServiceController::class, 'technicalSeo']);
$router->get('/services/technical-wordpress-optimization', [ServiceController::class, 'technicalSeo']);
$router->get('/services/speed-optimization', [ServiceController::class, 'technicalSeo']);

// خدمات تخصصی و لندینگ پیلار اتوماسیون هوش مصنوعی و سیستم‌سازی محتوا (پیلار ۲)
$router->get('/services/ai-automation', [ServiceController::class, 'aiAutomation']);
$router->get('/services/ai-content-automation', [ServiceController::class, 'aiAutomation']);
$router->get('/services/ai-integration', [ServiceController::class, 'aiAutomation']);
$router->get('/services/gemini-wordpress-automation', [ServiceController::class, 'aiAutomation']);
$router->get('/services/mcp-automation', [ServiceController::class, 'mcpAutomation']);
$router->post('/services/mcp-automation', [ServiceController::class, 'mcpAutomation']);
$router->get('/services/mcp-integration', [ServiceController::class, 'mcpAutomation']);
$router->get('/services/mcp-simulator', [PageController::class, 'mcpSimulator']);
$router->post('/services/mcp-simulator', [PageController::class, 'mcpSimulator']);
$router->get('/mcp', [ServiceController::class, 'mcpAutomation']);
$router->get('/mcp-simulator', [PageController::class, 'mcpSimulator']);
$router->post('/mcp-simulator', [PageController::class, 'mcpSimulator']);

// خدمات تخصصی و لندینگ پیلار سئوی محلی و تسخیر نقشه‌ها (پیلار ۳)
$router->get('/services/local-seo', [ServiceController::class, 'localSeo']);
$router->get('/services/map-optimization', [ServiceController::class, 'localSeo']);
$router->get('/services/google-maps-seo', [ServiceController::class, 'localSeo']);
$router->get('/services/local-business-seo', [ServiceController::class, 'localSeo']);

// خدمات تخصصی و لندینگ پیلار طراحی لندینگ‌پیج و بهینه‌سازی نرخ تبدیل (پیلار ۴)
$router->get('/services/landing-page-design-cro', [ServiceController::class, 'landingPageCro']);
$router->get('/services/landing-page-design', [ServiceController::class, 'landingPageCro']);
$router->get('/services/cro', [ServiceController::class, 'landingPageCro']);
$router->get('/services/conversion-rate-optimization', [ServiceController::class, 'landingPageCro']);

// خدمات تخصصی و لندینگ پیلار مشاوره، استراتژی و مدیریت جامع سئو (پیلار ۵)
$router->get('/services/seo-strategy', [ServiceController::class, 'seoStrategy']);
$router->get('/services/enterprise-seo', [ServiceController::class, 'seoStrategy']);
$router->get('/services/seo-management', [ServiceController::class, 'seoStrategy']);
$router->get('/services/seo-consulting', [ServiceController::class, 'seoStrategy']);

// خدمات تخصصی و لندینگ پیلار طراحی سایت اختصاصی و فروشگاهی با وایب کدینگ (پیلار ۶)
$router->get('/services/custom-web-development', [ServiceController::class, 'customWebDevelopment']);
$router->get('/services/web-development', [ServiceController::class, 'customWebDevelopment']);
$router->get('/services/custom-development', [ServiceController::class, 'customWebDevelopment']);
$router->get('/services/website-design', [ServiceController::class, 'customWebDevelopment']);

// صفحه شروع و رزرو وقت مشاوره
$router->get('/start', [ServiceController::class, 'start']);

// پروژه‌ها و نمونه‌کارها
$router->get('/projects', [FrontProjectController::class, 'index']);
$router->get('/project/{slug}', [FrontProjectController::class, 'show']);

// مقالات و وبلاگ سئو
$router->get('/articles', [FrontArticleController::class, 'index']);
$router->get('/article/{slug}', [FrontArticleController::class, 'show']);

// ثبت فرم مشاوره و لید (CRO)
$router->post('/lead/submit', [FrontLeadController::class, 'submit'], ['csrf', 'rate_limit:10,3600']);

// سئو تکنیکال: نقشه سایت داینامیک و Robots
$router->get('/sitemap.xml', [SitemapController::class, 'sitemap']);
$router->get('/robots.txt', [SitemapController::class, 'robots']);

// وب‌هوک و دستیار هوش مصنوعی تلگرام (Telegram Bot AI Assistant Webhook)
$router->post('/api/telegram/webhook', [TelegramBotController::class, 'handle']);
$router->get('/api/telegram/webhook', [TelegramBotController::class, 'handle']);
$router->post('/telegram/webhook', [TelegramBotController::class, 'handle']);
$router->get('/telegram/webhook', [TelegramBotController::class, 'handle']);
$router->post('/bot-webhook.php', [TelegramBotController::class, 'handle']);
$router->get('/bot-webhook.php', [TelegramBotController::class, 'handle']);
$router->get('/admin/telegram/set-webhook', [TelegramBotController::class, 'setWebhook'], ['auth']);

// وب‌هوک و سیستم اعلان پیام‌رسان بله (Bale Messenger Bot Webhook)
$router->post('/api/bale/webhook', [BaleBotController::class, 'handle']);
$router->get('/api/bale/webhook', [BaleBotController::class, 'handle']);
$router->post('/bale-webhook.php', [BaleBotController::class, 'handle']);
$router->get('/bale-webhook.php', [BaleBotController::class, 'handle']);


// ----------------------------------------------------------
// ۲. مسیرهای احراز هویت ادمین (Admin Authentication)
// ----------------------------------------------------------
$router->get('/admin/login', [AuthController::class, 'showLogin'], ['guest', 'rate_limit:30,60']);
$router->post('/admin/login', [AuthController::class, 'login'], ['guest', 'csrf', 'rate_limit:5,900']);
$router->post('/admin/logout', [AuthController::class, 'logout'], ['auth', 'csrf']);


// ----------------------------------------------------------
// ۳. مسیرهای پنل مدیریت (Admin Protected Routes)
// ----------------------------------------------------------
$router->get('/admin', [DashboardController::class, 'index'], ['auth']);

// مدیریت پروژه‌ها (Projects CRUD)
$router->get('/admin/projects', [ProjectController::class, 'index'], ['auth']);
$router->get('/admin/projects/create', [ProjectController::class, 'create'], ['auth']);
$router->post('/admin/projects/create', [ProjectController::class, 'store'], ['auth', 'csrf']);
$router->get('/admin/projects/edit/{id}', [ProjectController::class, 'edit'], ['auth']);
$router->post('/admin/projects/edit/{id}', [ProjectController::class, 'update'], ['auth', 'csrf']);
$router->post('/admin/projects/delete/{id}', [ProjectController::class, 'delete'], ['auth', 'csrf']);

// مدیریت مقالات (Articles CRUD)
$router->get('/admin/articles', [ArticleController::class, 'index'], ['auth']);
$router->get('/admin/articles/create', [ArticleController::class, 'create'], ['auth']);
$router->post('/admin/articles/create', [ArticleController::class, 'store'], ['auth', 'csrf']);
$router->get('/admin/articles/edit/{id}', [ArticleController::class, 'edit'], ['auth']);
$router->post('/admin/articles/edit/{id}', [ArticleController::class, 'update'], ['auth', 'csrf']);
$router->post('/admin/articles/delete/{id}', [ArticleController::class, 'delete'], ['auth', 'csrf']);

// مدیریت پیلارها و صفحات سایت (Pillars & Pages Management)
$router->get('/admin/pages', [PageManagerController::class, 'index'], ['auth']);
$router->get('/admin/pages/edit/{slug}', [PageManagerController::class, 'edit'], ['auth']);
$router->post('/admin/pages/edit/{slug}', [PageManagerController::class, 'update'], ['auth', 'csrf']);

// مدیریت لیدها (Leads & CRO Inquiries)
$router->get('/admin/leads', [LeadController::class, 'index'], ['auth']);
$router->get('/admin/leads/{id}', [LeadController::class, 'show'], ['auth']);
$router->post('/admin/leads/{id}', [LeadController::class, 'updateStatus'], ['auth', 'csrf']);
$router->post('/admin/leads/delete/{id}', [LeadController::class, 'delete'], ['auth', 'csrf']);

// مدیریت سوالات متداول (FAQs CRUD)
$router->get('/admin/faqs', [FaqController::class, 'index'], ['auth']);
$router->get('/admin/faqs/create', [FaqController::class, 'create'], ['auth']);
$router->post('/admin/faqs/create', [FaqController::class, 'store'], ['auth', 'csrf']);
$router->get('/admin/faqs/edit/{id}', [FaqController::class, 'edit'], ['auth']);
$router->post('/admin/faqs/edit/{id}', [FaqController::class, 'update'], ['auth', 'csrf']);
$router->post('/admin/faqs/delete/{id}', [FaqController::class, 'delete'], ['auth', 'csrf']);

// ماشین تولید محتوای هوش مصنوعی (Dedicated AI Content Machine)
$router->get('/admin/ai-writer', [AiWriterController::class, 'index'], ['auth']);
$router->post('/admin/ai-writer/generate', [AiWriterController::class, 'generate'], ['auth', 'csrf']);
$router->post('/admin/ai-writer/scifi', [AiWriterController::class, 'generateSciFi'], ['auth', 'csrf']);
$router->post('/admin/ai-writer/linkedin', [AiWriterController::class, 'generateLinkedIn'], ['auth', 'csrf']);
$router->post('/admin/ai-writer/save-key', [AiWriterController::class, 'saveApiKey'], ['auth', 'csrf']);

// مدیریت تنظیمات سئو و هویت سایت (Site Settings)
$router->get('/admin/settings', [SettingController::class, 'index'], ['auth']);
$router->post('/admin/settings', [SettingController::class, 'update'], ['auth', 'csrf']);
$router->post('/admin/settings/test-telegram', [SettingController::class, 'testTelegram'], ['auth', 'csrf']);
$router->post('/admin/settings/set-telegram-webhook', [SettingController::class, 'setTelegramWebhook'], ['auth', 'csrf']);
$router->post('/admin/settings/test-bale', [SettingController::class, 'testBale'], ['auth', 'csrf']);
$router->post('/admin/settings/set-bale-webhook', [SettingController::class, 'setBaleWebhook'], ['auth', 'csrf']);
$router->post('/admin/settings/test-cloudflare', [SettingController::class, 'testCloudflare'], ['auth', 'csrf']);
$router->post('/admin/settings/purge-cloudflare', [SettingController::class, 'purgeCloudflare'], ['auth', 'csrf']);
$router->post('/admin/settings/optimize-cloudflare', [SettingController::class, 'optimizeCloudflare'], ['auth', 'csrf']);
$router->post('/admin/settings/test-github', [SettingController::class, 'testGitHub'], ['auth', 'csrf']);


// بازنویسی و همگام‌سازی محتوای مقالات وبلاگ با مستر پرامپت (نیازمند احراز هویت ادمین)
$router->get('/system-sync-articles-seo', [PageController::class, 'syncArticlesSeo'], ['auth']);
$router->get('/system-sync-article-images', [PageController::class, 'syncArticleImages'], ['auth']);
$router->get('/system-clean-duplicates', [PageController::class, 'cleanDuplicates'], ['auth']);
$router->get('/system-clean-faqs', [PageController::class, 'cleanArticleFaqs'], ['auth']);
$router->get('/system-sync-article-media', [PageController::class, 'syncArticleMedia'], ['auth']);

$router->get('/api/system/bind-reddit', [PageController::class, 'bindRedditDirect'], ['auth']);


