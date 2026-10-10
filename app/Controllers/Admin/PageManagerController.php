<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\PageContent;

class PageManagerController extends Controller
{
    /**
     * لیست تمام صفحات و پیلارها در پنل مدیریت
     */
    public function index(Request $request, Response $response): void
    {
        $pages = PageContent::allPages();

        $this->render('admin/pages/index', [
            'title' => 'مدیریت پیلارها و صفحات سایت',
            'pages' => $pages,
            'success' => $_SESSION['flash_success'] ?? null,
            'error'   => $_SESSION['flash_error'] ?? null,
        ], 'admin/layouts/admin');

        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    /**
     * فرم ویرایش یک صفحه یا پیلار
     */
    public function edit(Request $request, Response $response): void
    {
        $slug = (string)$request->param('slug', '');
        $defaultPages = PageContent::getDefaultPages();

        if (!isset($defaultPages[$slug])) {
            $_SESSION['flash_error'] = 'صفحه مورد نظر یافت نشد.';
            $response->redirect('/admin/pages');
            return;
        }

        $pageData = PageContent::getPage($slug);

        // Decode FAQs if JSON
        $faqs = [];
        if (!empty($pageData['faqs_json'])) {
            $faqs = json_decode($pageData['faqs_json'], true) ?: [];
        }

        $this->render('admin/pages/edit', [
            'title'    => 'ویرایش: ' . ($pageData['name'] ?? $slug),
            'slug'     => $slug,
            'page'     => $pageData,
            'faqs'     => $faqs,
            'success'  => $_SESSION['flash_success'] ?? null,
            'error'    => $_SESSION['flash_error'] ?? null,
        ], 'admin/layouts/admin');

        unset($_SESSION['flash_success'], $_SESSION['flash_error']);
    }

    /**
     * ذخیره تغییرات صفحه
     */
    public function update(Request $request, Response $response): void
    {
        $slug = (string)$request->param('slug', '');
        $defaultPages = PageContent::getDefaultPages();

        if (!isset($defaultPages[$slug])) {
            $_SESSION['flash_error'] = 'صفحه نامعتبر است.';
            $response->redirect('/admin/pages');
            return;
        }

        $post = $request->post();

        // Process FAQs from form
        $faqQuestions = $post['faq_questions'] ?? [];
        $faqAnswers   = $post['faq_answers'] ?? [];
        $faqsList     = [];

        if (is_array($faqQuestions)) {
            foreach ($faqQuestions as $i => $q) {
                $q = trim((string)$q);
                $a = trim((string)($faqAnswers[$i] ?? ''));
                if (!empty($q) && !empty($a)) {
                    $faqsList[] = [
                        'question' => $q,
                        'answer'   => $a,
                    ];
                }
            }
        }

        $saveData = [
            'name'             => trim((string)($post['name'] ?? '')),
            'seo_title'        => trim((string)($post['seo_title'] ?? '')),
            'meta_description' => trim((string)($post['meta_description'] ?? '')),
            'h1_title'         => trim((string)($post['h1_title'] ?? '')),
            'badge_text'       => trim((string)($post['badge_text'] ?? '')),
            'subtitle'         => trim((string)($post['subtitle'] ?? '')),
            'content_html'     => trim((string)($post['content_html'] ?? '')),
            'faqs'             => $faqsList,
            'cta_title'        => trim((string)($post['cta_title'] ?? '')),
            'cta_button'       => trim((string)($post['cta_button'] ?? '')),
        ];

        PageContent::savePage($slug, $saveData);

        $_SESSION['flash_success'] = 'صفحه «' . ($saveData['name'] ?: $slug) . '» با موفقیت به‌روزرسانی شد.';
        $response->redirect('/admin/pages/edit/' . $slug);
    }
}
