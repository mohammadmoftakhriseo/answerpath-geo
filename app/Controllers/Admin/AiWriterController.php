<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Database;
use App\Models\Article;
use App\Models\SiteSetting;
use App\Services\AiContentEngine;

class AiWriterController extends Controller
{
    /**
     * صفحه استودیو ماشین تولید محتوای هوش مصنوعی
     */
    public function index(Request $request, Response $response): void
    {
        $currentApiKey = SiteSetting::get('gemini_api_key') ?: (require ROOT_PATH . '/config/ai.php')['gemini_api_key'] ?? '';
        
        // لیست ۶ پیلار تخصصی سئو برای لینک‌سازی کلاسترینگ
        $pillars = [
            'https://maaadmr.ir/services/seo-strategy'             => 'پیلار ۵: استراتژی و مدیریت جامع سئو (Enterprise SEO)',
            'https://maaadmr.ir/services/technical-seo'            => 'پیلار ۱: سئوی تکنیکال و بهینه‌سازی سرعت وردپرس',
            'https://maaadmr.ir/services/ai-automation'             => 'پیلار ۲: اتوماسیون هوش مصنوعی و Gemini API',
            'https://maaadmr.ir/services/local-seo'                => 'پیلار ۳: سئوی محلی و تسخیر نقشه‌ها (Google Maps)',
            'https://maaadmr.ir/services/landing-page-design-cro'  => 'پیلار ۴: طراحی لندینگ‌پیج و بهینه‌سازی نرخ تبدیل (CRO)',
            'https://maaadmr.ir/services/custom-web-development'   => 'پیلار ۶: طراحی سایت اختصاصی و پرسرعت (Coding Vibe)',
            'https://maaadmr.ir/about'                             => 'برگه درباره من (E-E-A-T)',
            'https://maaadmr.ir/contact'                           => 'برگه تماس و مشاوره سئو',
        ];

        // دریافت ۵ مقاله اخیر پیش‌نویس
        $recentDrafts = Database::query("SELECT id, title, slug, featured_image, status, created_at FROM articles WHERE status = 'draft' ORDER BY id DESC LIMIT 5");

        $this->render('admin/ai-writer/index', [
            'title'         => 'ماشین اختصاصی تولید محتوا با هوش مصنوعی (Gemini & Imagen 3)',
            'apiKey'        => $currentApiKey,
            'pillars'       => $pillars,
            'recentDrafts'  => $recentDrafts,
            'success'       => $_SESSION['flash_success'] ?? null,
            'error'         => $_SESSION['flash_error'] ?? null,
        ], 'admin/layouts/admin');

        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    /**
     * پردازش درخواست تولید مقاله سئوشده وبلاگ با Gemini و Pexels (Orchestration)
     */
    public function generate(Request $request, Response $response): void
    {
        $topic = trim((string)$request->input('topic', ''));
        if (empty($topic)) {
            $topic = trim((string)$request->input('title', ''));
        }

        if (empty($topic)) {
            if ($request->isAjax()) {
                $response->json(['success' => false, 'error' => 'لطفاً موضوع مقاله را وارد کنید.']);
                return;
            }
            $_SESSION['flash_error'] = 'لطفاً موضوع مقاله را وارد کنید.';
            $response->redirect('/admin/ai-writer#blog-engine');
            return;
        }

        try {
            $engine = new AiContentEngine();
            $result = $engine->generateSeoArticleWithPexels($topic);

            if ($request->isAjax()) {
                $response->json($result);
                return;
            }

            $_SESSION['flash_seo_article'] = $result;
            $_SESSION['flash_success'] = 'مقاله سئو با موفقیت تولید شد و با تصویر شاخص Pexels در آرشیو و دیتابیس ذخیره گردید.';
        } catch (\Throwable $e) {
            if ($request->isAjax()) {
                $response->json(['success' => false, 'error' => $e->getMessage()]);
                return;
            }
            $_SESSION['flash_error'] = 'خطا در تولید مقاله سئو: ' . $e->getMessage();
        }

        $response->redirect('/admin/ai-writer#blog-engine');
    }

    /**
     * تولید پست حرفه‌ای لینکدین بر اساس ایده خام با ساختار الگوریتمی
     */
    public function generateLinkedIn(Request $request, Response $response): void
    {
        $idea = trim((string)$request->input('idea', ''));
        if (empty($idea)) {
            if ($request->isAjax()) {
                $response->json(['success' => false, 'error' => 'لطفاً ایده یا موضوع پست لینکدین را وارد کنید.']);
                return;
            }
            $_SESSION['flash_error'] = 'لطفاً ایده یا موضوع پست لینکدین را وارد کنید.';
            $response->redirect('/admin/ai-writer#linkedin');
            return;
        }

        try {
            $engine = new AiContentEngine();
            $result = $engine->generateLinkedInPost($idea);

            if ($request->isAjax()) {
                $response->json($result);
                return;
            }

            $_SESSION['flash_linkedin_post'] = $result['post'];
            $_SESSION['flash_linkedin_idea'] = $idea;
            $_SESSION['flash_success'] = 'پست لینکدین با ساختار الگوریتمی با موفقیت تولید شد.';
        } catch (\Throwable $e) {
            if ($request->isAjax()) {
                $response->json(['success' => false, 'error' => $e->getMessage()]);
                return;
            }
            $_SESSION['flash_error'] = 'خطا در تولید پست لینکدین: ' . $e->getMessage();
        }

        $response->redirect('/admin/ai-writer#linkedin');
    }

    /**
     * تولید مقاله علمی-تخیلی و فناوری آنتی‌گرویتی با ساختار چندرسانه‌ای
     */
    public function generateSciFi(Request $request, Response $response): void
    {
        $topic = trim((string)$request->input('topic', 'تکنولوژی آنتی‌گرویتی و پادگرانش'));

        try {
            $engine = new AiContentEngine();
            $result = $engine->generateSciFiAntiGravityArticle($topic);

            if ($request->isAjax()) {
                $response->json($result);
                return;
            }

            $_SESSION['flash_success'] = 'مقاله تخصصی آنتی‌گرویتی با موفقیت تولید، تصویرسازی و در وب‌سایت منتشر شد: ' . $result['title'];
        } catch (\Throwable $e) {
            if ($request->isAjax()) {
                $response->json(['success' => false, 'error' => $e->getMessage()]);
                return;
            }
            $_SESSION['flash_error'] = 'خطا در تولید مقاله آنتی‌گرویتی: ' . $e->getMessage();
        }

        $response->redirect('/admin/articles');
    }

    /**
     * ذخیره یا به‌روزرسانی کلید Gemini API
     */
    public function saveApiKey(Request $request, Response $response): void
    {
        $key = trim((string)$request->input('gemini_api_key', ''));
        if (!empty($key)) {
            SiteSetting::set('gemini_api_key', $key);
            $_SESSION['flash_success'] = 'کلید Google Gemini API با موفقیت در سیستم ذخیره شد.';
        } else {
            $_SESSION['flash_error'] = 'کلید API نمی‌تواند خالی باشد.';
        }
        $response->redirect('/admin/ai-writer');
    }
}
