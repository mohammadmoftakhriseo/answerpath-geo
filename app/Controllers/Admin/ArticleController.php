<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $articles = Article::all();
        $this->render('admin/articles/index', [
            'title'    => 'مدیریت مقالات وبلاگ سئو',
            'articles' => $articles,
        ], 'admin/layouts/admin');
    }

    public function create(Request $request, Response $response): void
    {
        $this->render('admin/articles/create', [
            'title' => 'افزودن مقاله تخصصی جدید',
        ], 'admin/layouts/admin');
    }

    public function store(Request $request, Response $response): void
    {
        $title = trim((string)$request->input('title', ''));
        $slug = trim((string)$request->input('slug', ''));
        $directAnswer = trim((string)$request->input('direct_answer', ''));
        $summary = trim((string)$request->input('summary', ''));
        $content = trim((string)$request->input('content', ''));
        $schemaType = trim((string)$request->input('schema_type', 'TechArticle'));
        $readingTime = (int)$request->input('reading_time', 5);
        $featuredImage = trim((string)$request->input('featured_image', ''));

        // Handle File Upload if provided
        if (!empty($_FILES['featured_image_file']['name']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->handleImageUpload($_FILES['featured_image_file']);
            if ($uploadedPath) {
                $featuredImage = $uploadedPath;
            }
        }

        $seoTitle = trim((string)$request->input('seo_title', ''));
        $seoDescription = trim((string)$request->input('seo_description', ''));

        $faqQuestions = (array)($request->input('faq_questions') ?? []);
        $faqAnswers = (array)($request->input('faq_answers') ?? []);
        $faqs = [];
        foreach ($faqQuestions as $i => $q) {
            $q = trim((string)$q);
            $a = trim((string)($faqAnswers[$i] ?? ''));
            if (!empty($q) && !empty($a)) {
                $faqs[] = [
                    'question' => $q,
                    'answer'   => $a,
                ];
            }
        }
        $faqData = !empty($faqs) ? json_encode($faqs, JSON_UNESCAPED_UNICODE) : '[]';

        if (empty($title) || empty($slug) || empty($content)) {
            $response->redirect('/admin/articles/create?error=required');
            return;
        }

        Article::create([
            'author_id'       => 1,
            'title'           => $title,
            'slug'            => $slug,
            'direct_answer'   => $directAnswer,
            'summary'         => !empty($summary) ? $summary : mb_substr(strip_tags($content), 0, 150),
            'content'         => $content,
            'featured_image'  => !empty($featuredImage) ? $featuredImage : null,
            'reading_time'    => $readingTime,
            'seo_title'       => !empty($seoTitle) ? $seoTitle : $title,
            'seo_description' => !empty($seoDescription) ? $seoDescription : (!empty($summary) ? $summary : $directAnswer),
            'faq_data'        => $faqData,
            'schema_type'     => $schemaType,
            'status'          => $request->input('status', 'published')
        ]);

        // پاکسازی هوشمند کش کلودفلر برای این مقاله و صفحه اصلی
        try {
            $cf = new \App\Services\CloudflareService();
            if ($cf->isConfigured()) {
                $cf->purgeArticle($slug);
            }
        } catch (\Throwable) {}

        $response->redirect('/admin/articles?status=created');
    }

    public function edit(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $article = Article::findById($id);

        if (!$article) {
            $response->redirect('/admin/articles?error=notfound');
            return;
        }

        $this->render('admin/articles/edit', [
            'title'   => 'ویرایش مقاله: ' . $article['title'],
            'article' => $article,
        ], 'admin/layouts/admin');
    }

    public function update(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $article = Article::findById($id);

        if (!$article) {
            $response->redirect('/admin/articles?error=notfound');
            return;
        }

        $title = trim((string)$request->input('title', ''));
        $slug = trim((string)$request->input('slug', ''));
        $directAnswer = trim((string)$request->input('direct_answer', ''));
        $summary = trim((string)$request->input('summary', ''));
        $content = trim((string)$request->input('content', ''));
        $schemaType = trim((string)$request->input('schema_type', 'TechArticle'));
        $readingTime = (int)$request->input('reading_time', 5);
        $featuredImage = trim((string)$request->input('featured_image', ''));

        // Handle File Upload if provided
        if (!empty($_FILES['featured_image_file']['name']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->handleImageUpload($_FILES['featured_image_file']);
            if ($uploadedPath) {
                $featuredImage = $uploadedPath;
            }
        }

        if (empty($featuredImage) && !empty($article['featured_image']) && $request->input('featured_image') === null) {
            $featuredImage = $article['featured_image'];
        }

        $seoTitle = trim((string)$request->input('seo_title', ''));
        $seoDescription = trim((string)$request->input('seo_description', ''));

        $faqQuestions = (array)($request->input('faq_questions') ?? []);
        $faqAnswers = (array)($request->input('faq_answers') ?? []);
        $faqs = [];
        foreach ($faqQuestions as $i => $q) {
            $q = trim((string)$q);
            $a = trim((string)($faqAnswers[$i] ?? ''));
            if (!empty($q) && !empty($a)) {
                $faqs[] = [
                    'question' => $q,
                    'answer'   => $a,
                ];
            }
        }
        $faqData = !empty($faqs) ? json_encode($faqs, JSON_UNESCAPED_UNICODE) : '[]';

        Article::update($id, [
            'title'           => $title,
            'slug'            => $slug,
            'direct_answer'   => $directAnswer,
            'summary'         => !empty($summary) ? $summary : mb_substr(strip_tags($content), 0, 150),
            'content'         => $content,
            'featured_image'  => !empty($featuredImage) ? $featuredImage : null,
            'reading_time'    => $readingTime,
            'seo_title'       => !empty($seoTitle) ? $seoTitle : $title,
            'seo_description' => !empty($seoDescription) ? $seoDescription : (!empty($summary) ? $summary : $directAnswer),
            'faq_data'        => $faqData,
            'schema_type'     => $schemaType,
            'status'          => $request->input('status', 'published')
        ]);

        // پاکسازی هوشمند کش کلودفلر برای تغییرات این مقاله
        try {
            $cf = new \App\Services\CloudflareService();
            if ($cf->isConfigured()) {
                $cf->purgeArticle($slug);
            }
        } catch (\Throwable) {}

        $response->redirect('/admin/articles?status=updated');
    }

    public function delete(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        Article::delete($id);

        // پاکسازی کش صفحات وبلاگ و صفحه اصلی پس از حذف مقاله
        try {
            $cf = new \App\Services\CloudflareService();
            if ($cf->isConfigured()) {
                $cf->purgeUrls(['/', '/articles', '/sitemap.xml']);
            }
        } catch (\Throwable) {}

        $response->redirect('/admin/articles?status=deleted');
    }

    private function handleImageUpload(array $file): ?string
    {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExtensions, true)) {
            return null;
        }

        $uploadDir = dirname(__DIR__, 3) . '/assets/images/uploads/';
        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 0755, true);
        }

        $filename = 'art_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $target = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return '/assets/images/uploads/' . $filename;
        }

        return null;
    }
}
