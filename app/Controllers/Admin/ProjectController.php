<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $projects = Project::all();
        $this->render('admin/projects/index', [
            'title'    => 'مدیریت کیس‌استادی‌ها و پروژه‌ها',
            'projects' => $projects,
        ], 'admin/layouts/admin');
    }

    public function create(Request $request, Response $response): void
    {
        $this->render('admin/projects/create', [
            'title' => 'افزودن کیس‌استادی جدید',
        ], 'admin/layouts/admin');
    }

    public function store(Request $request, Response $response): void
    {
        $title = trim((string)$request->input('title', ''));
        $slug = trim((string)$request->input('slug', ''));
        $clientName = trim((string)$request->input('client_name', ''));
        $category = trim((string)$request->input('category', 'سئو تکنیکال و استراتژی محتوا'));
        $shortSummary = trim((string)$request->input('short_summary', ''));
        $description = trim((string)$request->input('description', ''));
        $featuredImage = trim((string)$request->input('featured_image', ''));

        if (!empty($_FILES['featured_image_file']['name']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->handleImageUpload($_FILES['featured_image_file']);
            if ($uploadedPath) {
                $featuredImage = $uploadedPath;
            }
        }
        
        $metrics = [
            'traffic_growth'  => $request->input('metric_traffic', '+100%'),
            'lcp_speed'       => $request->input('metric_lcp', '1.2s'),
            'keyword_top3'    => $request->input('metric_keywords', '20+'),
            'conversion_rate' => $request->input('metric_conversion', '+30%'),
        ];

        if (empty($title) || empty($slug)) {
            $response->redirect('/admin/projects/create?error=required');
            return;
        }

        Project::create([
            'title'           => $title,
            'slug'            => $slug,
            'client_name'     => $clientName,
            'category'        => $category,
            'short_summary'   => $shortSummary,
            'description'     => $description,
            'featured_image'  => !empty($featuredImage) ? $featuredImage : null,
            'results_metrics' => json_encode($metrics, JSON_UNESCAPED_UNICODE),
            'is_featured'     => 1,
            'display_order'   => (int)$request->input('display_order', 0),
            'status'          => $request->input('status', 'published')
        ]);

        $response->redirect('/admin/projects?status=created');
    }

    public function edit(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $project = Project::findById($id);

        if (!$project) {
            $response->redirect('/admin/projects?error=notfound');
            return;
        }

        $this->render('admin/projects/edit', [
            'title'   => 'ویرایش کیس‌استادی: ' . $project['title'],
            'project' => $project,
        ], 'admin/layouts/admin');
    }

    public function update(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        $project = Project::findById($id);

        if (!$project) {
            $response->redirect('/admin/projects?error=notfound');
            return;
        }

        $title = trim((string)$request->input('title', ''));
        $slug = trim((string)$request->input('slug', ''));
        $clientName = trim((string)$request->input('client_name', ''));
        $category = trim((string)$request->input('category', 'سئو تکنیکال'));
        $shortSummary = trim((string)$request->input('short_summary', ''));
        $description = trim((string)$request->input('description', ''));
        $featuredImage = trim((string)$request->input('featured_image', ''));

        if (!empty($_FILES['featured_image_file']['name']) && $_FILES['featured_image_file']['error'] === UPLOAD_ERR_OK) {
            $uploadedPath = $this->handleImageUpload($_FILES['featured_image_file']);
            if ($uploadedPath) {
                $featuredImage = $uploadedPath;
            }
        }

        if (empty($featuredImage) && !empty($project['featured_image']) && $request->input('featured_image') === null) {
            $featuredImage = $project['featured_image'];
        }

        $metrics = [
            'traffic_growth'  => $request->input('metric_traffic', '+100%'),
            'lcp_speed'       => $request->input('metric_lcp', '1.2s'),
            'keyword_top3'    => $request->input('metric_keywords', '20+'),
            'conversion_rate' => $request->input('metric_conversion', '+30%'),
        ];

        Project::update($id, [
            'title'           => $title,
            'slug'            => $slug,
            'client_name'     => $clientName,
            'category'        => $category,
            'short_summary'   => $shortSummary,
            'description'     => $description,
            'featured_image'  => !empty($featuredImage) ? $featuredImage : null,
            'results_metrics' => json_encode($metrics, JSON_UNESCAPED_UNICODE),
            'is_featured'     => 1,
            'display_order'   => (int)$request->input('display_order', 0),
            'status'          => $request->input('status', 'published')
        ]);

        $response->redirect('/admin/projects?status=updated');
    }

    public function delete(Request $request, Response $response): void
    {
        $id = (int)$request->param('id');
        Project::delete($id);
        $response->redirect('/admin/projects?status=deleted');
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

        $filename = 'proj_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
        $target = $uploadDir . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            return '/assets/images/uploads/' . $filename;
        }

        return null;
    }
}
