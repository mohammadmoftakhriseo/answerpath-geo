<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\SEOManager;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $articles = Article::published();
        $this->render('front/articles/index', [
            'title'       => 'مقالات تخصصی و استراتژی‌های سئو | محمد مفتخری',
            'description' => 'آموزش‌ها و تکنیک‌های به‌روز سئو تکنیکال، سئو محتوا، الگوریتم‌های جدید گوگل و هوش مصنوعی.',
            'articles'    => $articles,
            'schemas'     => [SEOManager::getPersonSchema()]
        ]);
    }

    public function show(Request $request, Response $response): void
    {
        $slug = (string)$request->param('slug');
        $article = Article::findBySlug($slug);

        if (!$article) {
            $response->setStatusCode(404);
            $this->render('errors/404', ['title' => 'مقاله یافت نشد']);
            return;
        }

        $catMap = [
            'سئوی تکنیکال'              => ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => url('/services/technical-seo')],
            'سئوی تکنیکال و پرفورمنس'    => ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => url('/services/technical-seo')],
            'TechArticle'                => ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => url('/services/technical-seo')],
            'اتوماسیون هوش مصنوعی'       => ['name' => 'اتوماسیون هوش مصنوعی', 'url' => url('/services/ai-automation')],
            'اتوماسیون هوش مصنوعی و MCP' => ['name' => 'اتوماسیون هوش مصنوعی و MCP', 'url' => url('/services/ai-automation')],
            'پروتکل MCP'                 => ['name' => 'اتوماسیون پروتکل MCP', 'url' => url('/services/mcp-automation')],
            'طراحی لندینگ‌پیج و CRO'     => ['name' => 'طراحی لندینگ‌پیج و نرخ تبدیل', 'url' => url('/services/landing-page-design-cro')],
            'سئوی محلی و گوگل مپ'        => ['name' => 'سئوی محلی و گوگل مپ', 'url' => url('/services/local-seo')],
            'استراتژی سئو'               => ['name' => 'استراتژی و مشاوره سئو', 'url' => url('/services/seo-strategy')],
            'توسعه اختصاصی وب'           => ['name' => 'طراحی سایت و کدنویسی اختصاصی', 'url' => url('/services/custom-web-development')],
        ];
        $categoryInfo = $catMap[$article['schema_type'] ?? ''] ?? ['name' => 'سئوی تکنیکال و پرفورمنس', 'url' => url('/services/technical-seo')];

        $faqs = [];
        if (!empty($article['faq_data'])) {
            $decoded = json_decode($article['faq_data'], true);
            if (is_array($decoded) && !empty($decoded)) {
                $faqs = $decoded;
            }
        }
        if (empty($faqs)) {
            $faqs = SEOManager::extractFaqsFromContent($article['content'] ?? '', $article['title'] ?? '', $article['direct_answer'] ?? '');
        }

        $schemas = [
            SEOManager::getPersonSchema(),
            SEOManager::getArticleSchema($article),
            SEOManager::getBreadcrumbSchema([
                ['name' => 'صفحه اصلی', 'url' => url('/')],
                ['name' => 'مقالات', 'url' => url('/articles')],
                ['name' => $categoryInfo['name'], 'url' => $categoryInfo['url']],
                ['name' => $article['title'], 'url' => url('/article/' . $article['slug'])],
            ])
        ];

        if (!empty($faqs)) {
            $faqSchema = SEOManager::getFaqSchema($faqs);
            if ($faqSchema) {
                $schemas[] = $faqSchema;
            }
        }

        $this->render('front/articles/show', [
            'title'       => (!empty($article['seo_title']) ? $article['seo_title'] : $article['title']) . ' | محمد مفتخری',
            'description' => !empty($article['seo_description']) ? $article['seo_description'] : (!empty($article['summary']) ? $article['summary'] : $article['direct_answer']),
            'article'     => $article,
            'faqs'        => $faqs,
            'schemas'     => $schemas
        ]);
    }
}
