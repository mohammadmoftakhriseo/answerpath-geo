<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\Project;
use App\Models\Article;

class SitemapController extends Controller
{
    public function sitemap(Request $request, Response $response): void
    {
        $projects = Project::all();
        $articles = Article::published();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        // Home
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . htmlspecialchars(url('/')) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '    <changefreq>daily</changefreq>' . "\n";
        $xml .= '    <priority>1.0</priority>' . "\n";
        $xml .= '  </url>' . "\n";

        // SEO Roadmap
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . htmlspecialchars(url('/seo-roadmap')) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '    <changefreq>daily</changefreq>' . "\n";
        $xml .= '    <priority>0.9</priority>' . "\n";
        $xml .= '  </url>' . "\n";

        // Projects
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . htmlspecialchars(url('/projects')) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '    <changefreq>weekly</changefreq>' . "\n";
        $xml .= '    <priority>0.8</priority>' . "\n";
        $xml .= '  </url>' . "\n";

        foreach ($projects as $p) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars(url('/project/' . $p['slug'])) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . date('Y-m-d', strtotime($p['created_at'])) . '</lastmod>' . "\n";
            $xml .= '    <changefreq>monthly</changefreq>' . "\n";
            $xml .= '    <priority>0.7</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        // Articles
        $xml .= '  <url>' . "\n";
        $xml .= '    <loc>' . htmlspecialchars(url('/articles')) . '</loc>' . "\n";
        $xml .= '    <lastmod>' . date('Y-m-d') . '</lastmod>' . "\n";
        $xml .= '    <changefreq>weekly</changefreq>' . "\n";
        $xml .= '    <priority>0.8</priority>' . "\n";
        $xml .= '  </url>' . "\n";

        foreach ($articles as $a) {
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars(url('/article/' . $a['slug'])) . '</loc>' . "\n";
            $xml .= '    <lastmod>' . date('Y-m-d', strtotime($a['published_at'] ?? $a['created_at'])) . '</lastmod>' . "\n";
            $xml .= '    <changefreq>monthly</changefreq>' . "\n";
            $xml .= '    <priority>0.7</priority>' . "\n";
            $xml .= '  </url>' . "\n";
        }

        $xml .= '</urlset>';

        $response->header('Content-Type', 'application/xml; charset=utf-8');
        $response->send($xml);
    }

    public function robots(Request $request, Response $response): void
    {
        $txt = "User-agent: *\n";
        $txt .= "Allow: /\n";
        $txt .= "Disallow: /admin\n";
        $txt .= "Disallow: /admin/\n\n";
        $txt .= "Sitemap: " . url('/sitemap.xml') . "\n";

        $response->header('Content-Type', 'text/plain; charset=utf-8');
        $response->send($txt);
    }
}
