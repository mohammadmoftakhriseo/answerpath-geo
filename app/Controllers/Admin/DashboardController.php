<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Project;
use App\Models\Article;
use App\Models\Lead;
use App\Models\Faq;

class DashboardController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $projects = Project::all();
        $articles = Article::all();
        $leads = Lead::all();
        $faqs = Faq::all();

        $this->render('admin/dashboard/index', [
            'title'        => 'داشبورد مدیریت | محمد مفتخری',
            'projectCount' => count($projects),
            'articleCount' => count($articles),
            'leadCount'    => count($leads),
            'faqCount'     => count($faqs),
            'recentLeads'  => array_slice($leads, 0, 5),
        ]);
    }
}
