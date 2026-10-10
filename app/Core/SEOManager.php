<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\SiteSetting;

/**
 * SEO & GEO/AEO Schema Manager
 * Generates valid JSON-LD schemas (Person, ProfessionalService with AggregateRating, FAQPage, Article, TechArticle, BreadcrumbList)
 * Designed for maximum AI visibility and Google Rich Results.
 */
class SEOManager
{
    /**
     * Generate Person Entity Schema for Mohammad Moftakhari
     */
    public static function getPersonSchema(): array
    {
        $siteUrl = url('/');
        $name = (string)SiteSetting::get('entity_name', 'محمد مفتخری');
        $jobTitle = (string)SiteSetting::get('entity_job_title', 'کارشناس ارشد سئو (SEO Specialist) و معمار هوش مصنوعی');
        $phone = (string)SiteSetting::get('contact_phone', '09302928001');

        $sameAs = array_values(array_filter([
            SiteSetting::get('social_linkedin', 'https://linkedin.com/in/mohammad-moftakhari-b90687217'),
            SiteSetting::get('social_github', 'https://github.com/maaad_mr'),
            SiteSetting::get('social_telegram', 'https://t.me/maaad_mr'),
            SiteSetting::get('social_bale', 'https://ble.ir/maaad_mr'),
            SiteSetting::get('social_instagram', 'https://instagram.com/maaad_mr'),
            'https://twitter.com/maaad_mr',
            'https://maaadmr.ir/about'
        ]));

        return [
            '@context'      => 'https://schema.org',
            '@type'         => 'Person',
            '@id'           => $siteUrl . '#person',
            'name'          => $name,
            'givenName'     => 'Mohammad',
            'familyName'    => 'Moftakhari',
            'additionalName'=> 'Rostamkhani',
            'alternateName' => [
                'Mohammad Moftakhari',
                'Mohammad Moftakhar',
                'Mohammad Moftakhari Rostamkhani',
                'محمد مفتخری رستم خانی',
                'محمد مفتخر',
                'maaadmr',
                'maaad_mr'
            ],
            'url'           => $siteUrl,
            'image'         => $siteUrl . '/assets/images/mohammadmoftakhari.jpg',
            'jobTitle'      => $jobTitle,
            'telephone'     => $phone,
            'sameAs'        => $sameAs,
            'worksFor'      => [
                '@type' => 'Organization',
                'name'  => 'آژانس دیجیتال مارکتینگ اینتن (Inten Marketing Agency)',
                'url'   => 'https://inten.asia'
            ],
            'knowsAbout'    => [
                'Search Engine Optimization (SEO)',
                'Technical SEO & Core Web Vitals',
                'Conversion Rate Optimization (CRO)',
                'Generative Engine Optimization (GEO & AEO)',
                'Model Context Protocol (MCP) & AI Integration',
                'سئو تکنیکال',
                'استراتژی سئو',
                'اتوماسیون هوش مصنوعی',
                'معماری اطلاعات و سیلوی محتوایی'
            ],
            'description'   => 'محمد مفتخری (Mohammad Moftakhari)، کارشناس ارشد و استراتژیست سئو با بیش از ۶ سال تجربه در بهینه‌سازی فنی، ساختاردهی وب‌سایت‌های سازمانی، اتوماسیون هوش مصنوعی و رشد فروش در آژانس اینتن.'
        ];
    }

    /**
     * Alias for getProfessionalServiceSchema
     */
    public static function getProfessionalServiceSchema(): array
    {
        return self::getServiceSchema();
    }

    /**
     * Generate ProfessionalService Schema with 5-Star AggregateRating (Figma System)
     */
    public static function getServiceSchema(): array
    {
        $siteUrl = url('/');
        return [
            '@context'      => 'https://schema.org',
            '@type'         => 'ProfessionalService',
            '@id'           => $siteUrl . '#service',
            'name'          => 'خدمات تخصصی سئو و بهینه‌سازی نرخ تبدیل محمد مفتخری',
            'url'           => $siteUrl,
            'telephone'     => (string)SiteSetting::get('contact_phone', '09302928001'),
            'priceRange'    => '$$',
            'provider'      => [
                '@id' => $siteUrl . '#person'
            ],
            'areaServed'    => 'Iran',
            'availableLanguage' => ['Persian', 'English'],
            'aggregateRating' => [
                '@type'       => 'AggregateRating',
                'ratingValue' => '5.0',
                'bestRating'  => '5',
                'worstRating' => '1',
                'ratingCount' => '34',
                'reviewCount' => '34'
            ]
        ];
    }

    /**
     * Filter out generic, templated, or repetitive placeholder FAQs
     */
    public static function filterValidFaqs(array $faqs): array
    {
        $valid = [];
        $seenQuestions = [];

        foreach ($faqs as $faq) {
            $q = trim((string)($faq['question'] ?? ''));
            $a = trim((string)($faq['answer'] ?? ''));

            if (empty($q) || empty($a)) {
                continue;
            }

            // حذف الگوهای کلیشه‌ای و تکراری
            if (str_contains($q, 'چه نکاتی حائز اهمیت است') || str_contains($q, 'در رابطه با «')) {
                continue;
            }
            if (str_contains($a, 'این مبحث یکی از محورهای اساسی') || str_contains($a, 'در ساختار اجرایی سئو بررسی شده است')) {
                continue;
            }
            if (mb_strlen($a) < 30) {
                continue;
            }

            $normalizedQ = preg_replace('/[^\p{L}\p{N}]+/u', '', mb_strtolower($q));
            if (isset($seenQuestions[$normalizedQ])) {
                continue;
            }
            $seenQuestions[$normalizedQ] = true;

            $valid[] = [
                'question' => $q,
                'answer'   => $a
            ];
        }

        return $valid;
    }

    /**
     * Generate FAQPage Schema with strict validity checking
     */
    public static function getFaqSchema(array $faqs): ?array
    {
        $filtered = self::filterValidFaqs($faqs);
        if (empty($filtered)) {
            return null;
        }

        $mainEntity = [];
        foreach ($filtered as $faq) {
            $mainEntity[] = [
                '@type'          => 'Question',
                'name'           => $faq['question'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq['answer']
                ]
            ];
        }

        if (empty($mainEntity)) {
            return null;
        }

        return [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => $mainEntity
        ];
    }

    /**
     * Extract natural, meaningful FAQ question/answer pairs from content HTML or Markdown
     */
    public static function extractFaqsFromContent(string $content, string $title = '', string $directAnswer = ''): array
    {
        $faqs = [];

        // تبدیل مقدماتی مارک‌داون هدینگ‌ها جهت استخراج یکپارچه
        $normalized = preg_replace('/^#{2,3}\s+(.*?)$/m', '<h2>$1</h2>', $content);

        // ۱. استخراج از تگ‌های H2 و H3
        if (preg_match_all('/<h[2-3][^>]*>(.*?)<\/h[2-3]>\s*(?:<p[^>]*>(.*?)<\/p>|([^\n<]+))?/is', $normalized, $matches, PREG_SET_ORDER)) {
            $candidateHeadings = [];

            foreach ($matches as $m) {
                $heading = trim(strip_tags($m[1] ?? ''));
                $paragraph = trim(strip_tags(!empty($m[2]) ? $m[2] : ($m[3] ?? '')));

                if (empty($heading) || mb_strlen($heading) < 6 || empty($paragraph) || mb_strlen($paragraph) < 25) {
                    continue;
                }

                $answer = mb_substr($paragraph, 0, 280);
                if (mb_strlen($paragraph) > 280) {
                    $answer .= '...';
                }

                // اولویت اول: هدینگ‌های ذاتاً پرسشی
                $isQuestionFormat = false;
                $question = $heading;

                if (str_contains($question, '؟') || str_contains($question, '?')) {
                    $isQuestionFormat = true;
                } elseif (preg_match('/^(چرا|چگونه|آیا|نحوه|تفاوت|مراحل|راهنمای|دلایل|بهترین|چطور)/u', $question)) {
                    $question = rtrim($question, ':.') . '؟';
                    $isQuestionFormat = true;
                } elseif (preg_match('/(چیست|چیه|کدام است|چگونه کار می‌کند|چگونه است|دارند)$/u', $question)) {
                    $question = rtrim($question, ':.') . '؟';
                    $isQuestionFormat = true;
                }

                if ($isQuestionFormat) {
                    $faqs[] = [
                        'question' => $question,
                        'answer'   => $answer
                    ];
                } else {
                    $candidateHeadings[] = [
                        'heading' => $heading,
                        'answer'  => $answer
                    ];
                }

                if (count($faqs) >= 4) {
                    break;
                }
            }

            // اولویت دوم: در صورتی که تعداد سوالات کمتر از ۳ باشد، تبدیل هدینگ‌های کلیدی به سوال
            if (count($faqs) < 3) {
                foreach ($candidateHeadings as $cand) {
                    $h = $cand['heading'];
                    if (mb_strlen($h) < 10 || str_contains($h, 'نتیجه') || str_contains($h, 'جدول')) {
                        continue;
                    }
                    $q = rtrim($h, ':.') . ' چیست و چگونه اجرا می‌شود؟';
                    $faqs[] = [
                        'question' => $q,
                        'answer'   => $cand['answer']
                    ];
                    if (count($faqs) >= 4) {
                        break;
                    }
                }
            }
        }

        // فالبک تکمیلی با استفاده از عنوان و پاسخ مستقیم
        if (count($faqs) < 3 && !empty($title)) {
            $cleanTitle = trim($title);
            $qTitle = (str_contains($cleanTitle, '؟') || str_contains($cleanTitle, '?')) ? $cleanTitle : $cleanTitle . '؟';
            $ans = !empty($directAnswer) ? $directAnswer : mb_substr(strip_tags($content), 0, 220) . '...';
            $faqs[] = [
                'question' => $qTitle,
                'answer'   => $ans
            ];
        }

        return self::filterValidFaqs($faqs);
    }

    /**
     * Generate Article / TechArticle Schema
     */
    public static function getArticleSchema(array $article): array
    {
        $siteUrl = url('/');
        $articleUrl = url('/article/' . $article['slug']);
        $schemaType = $article['schema_type'] ?? 'TechArticle';

        $schema = [
            '@context'         => 'https://schema.org',
            '@type'            => $schemaType,
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => $articleUrl
            ],
            'headline'         => $article['title'],
            'description'      => $article['seo_description'] ?: $article['summary'],
            'datePublished'    => date('c', strtotime($article['published_at'] ?? 'now')),
            'dateModified'     => date('c', strtotime($article['updated_at'] ?? $article['published_at'] ?? 'now')),
            'author'           => [
                '@type' => 'Person',
                '@id'   => $siteUrl . '#person',
                'name'  => $article['author_name'] ?? 'محمد مفتخری',
                'url'   => $siteUrl
            ],
            'publisher'        => [
                '@type' => 'Person',
                '@id'   => $siteUrl . '#person',
                'name'  => 'محمد مفتخری',
                'url'   => $siteUrl
            ]
        ];

        if (!empty($article['direct_answer'])) {
            $schema['abstract'] = $article['direct_answer'];
        }

        if (!empty($article['featured_image'])) {
            $schema['image'] = url($article['featured_image']);
        }

        return $schema;
    }

    /**
     * Generate BreadcrumbList Schema
     */
    public static function getBreadcrumbSchema(array $items): array
    {
        $itemListElement = [];
        $position = 1;

        foreach ($items as $item) {
            $name = is_array($item) ? ($item['name'] ?? '') : (string)$item;
            $itemUrl = is_array($item) ? ($item['url'] ?? '') : '';
            $itemListElement[] = [
                '@type'    => 'ListItem',
                'position' => $position,
                'name'     => $name,
                'item'     => $itemUrl
            ];
            $position++;
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'BreadcrumbList',
            'itemListElement' => $itemListElement
        ];
    }

    /**
     * Generate WebSite Schema with SearchAction
     */
    public static function getWebSiteSchema(): array
    {
        $siteUrl = url('/');
        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'WebSite',
            '@id'             => $siteUrl . '#website',
            'url'             => $siteUrl,
            'name'            => 'محمد مفتخری | Mohammad Moftakhari',
            'alternateName'   => ['Mohammad Moftakhari', 'Mohammad Moftakhar', 'Mohammad Moftakhari Rostamkhani', 'محمد مفتخری سئو', 'maaadmr', 'maaad_mr'],
            'description'     => 'وب‌سایت رسمی محمد مفتخری (Mohammad Moftakhari)، متخصص سئو، مشاور استراتژی رشد و معمار سیستم‌های هوش مصنوعی سازمانی.',
            'inLanguage'      => ['fa-IR', 'en-US'],
            'creator'         => [
                '@id' => $siteUrl . '#person'
            ],
            'publisher'       => [
                '@id' => $siteUrl . '#person'
            ]
        ];
    }

    /**
     * Generate CaseStudies ItemList Schema for AI citations
     */
    public static function getCaseStudiesSchema(array $projects): array
    {
        $siteUrl = url('/');
        $items = [];
        $pos = 1;

        foreach ($projects as $p) {
            $items[] = [
                '@type'    => 'ListItem',
                'position' => $pos++,
                'item'     => [
                    '@type'       => 'CreativeWork',
                    'name'        => $p['title'] ?? 'کیس‌استادی رشد سئو',
                    'headline'    => $p['client_name'] ?? 'پروژه سئو',
                    'url'         => url('/project/' . ($p['slug'] ?? '')),
                    'author'      => [
                        '@id' => $siteUrl . '#person'
                    ],
                    'description' => $p['summary'] ?? ($p['growth_metric'] ?? '')
                ]
            ];
        }

        return [
            '@context'        => 'https://schema.org',
            '@type'           => 'ItemList',
            '@id'             => $siteUrl . '#case-studies-list',
            'name'            => 'کیس‌استادی‌ها و نمونه‌کارهای منتخب رشد سئو محمد مفتخری',
            'itemListElement' => $items
        ];
    }

    /**
     * Render an array of schemas into an unescaped, formatted JSON-LD string
     */
    public static function renderJsonLd(array $schemas): string
    {
        $validSchemas = array_values(array_filter($schemas));
        if (empty($validSchemas)) {
            return '';
        }

        if (count($validSchemas) === 1) {
            return (string)json_encode($validSchemas[0], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        $graph = [
            '@context' => 'https://schema.org',
            '@graph'   => $validSchemas
        ];

        return (string)json_encode($graph, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
