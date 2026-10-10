<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\SEOManager;
use App\Models\Project;
use App\Models\Article;
use App\Models\Faq;

class HomeController extends Controller
{
    public function index(Request $request, Response $response): void
    {
        $projects = Project::all();
        $articles = Article::published();
        $faqs = Faq::active();

        $schemas = [
            SEOManager::getPersonSchema(),
            SEOManager::getWebSiteSchema(),
            SEOManager::getProfessionalServiceSchema(),
        ];

        if (!empty($projects)) {
            $schemas[] = SEOManager::getCaseStudiesSchema($projects);
        }

        if (!empty($faqs)) {
            $schemas[] = SEOManager::getFaqSchema($faqs);
        }

        $schemaJsonLd = SEOManager::renderJsonLd($schemas);

        $this->render('front/home', [
            'title'        => 'محمد مفتخری (Mohammad Moftakhari) | کارشناس و استراتژیست سئو',
            'description'  => 'وب‌سایت رسمی محمد مفتخری (Mohammad Moftakhari)، متخصص سئو و معمار هوش مصنوعی. استراتژی جامع سئو تکنیکال، رشد ارگانیک، CRO و هوش مصنوعی.',
            'schemaJsonLd' => $schemaJsonLd,
            'canonical'    => url('/'),
            'projects'     => $projects,
            'articles'     => $articles,
            'faqs'         => $faqs,
        ]);
    }
}
