<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\SEOManager;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $projects = Project::all();
        $this->render('front/projects/index', [
            'title'       => 'نمونه‌کارها و نتایج سئو | محمد مفتخری',
            'description' => 'مشاهده پروژه‌ها و کیس‌استادی‌های موفق سئو محمد مفتخری در حوزه‌های B2B، فروشگاهی و شرکتی.',
            'projects'    => $projects,
            'schemas'     => [SEOManager::getPersonSchema()]
        ]);
    }

    public function show(Request $request, Response $response): void
    {
        $slug = (string)$request->param('slug');
        $project = Project::findBySlug($slug);

        if (!$project) {
            $response->setStatusCode(404);
            $this->render('errors/404', ['title' => 'پروژه یافت نشد']);
            return;
        }

        $this->render('front/projects/show', [
            'title'       => $project['title'] . ' | کیس استادی سئو',
            'description' => $project['results_summary'] ?? $project['title'],
            'project'     => $project,
            'schemas'     => [
                SEOManager::getPersonSchema(),
                SEOManager::getBreadcrumbSchema([
                    ['name' => 'صفحه اصلی', 'url' => url('/')],
                    ['name' => 'پروژه‌ها', 'url' => url('/projects')],
                    ['name' => $project['title'], 'url' => url('/project/' . $project['slug'])],
                ])
            ]
        ]);
    }
}
