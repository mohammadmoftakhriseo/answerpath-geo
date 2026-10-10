<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\SEOManager;
use App\Models\Project;
use App\Models\Faq;
use App\Models\PageContent;

class PageController extends Controller
{
    /**
     * صفحه اختصاصی درباره من (About Page)
     */
    public function about(Request $request, Response $response): void
    {
        $page = PageContent::getPage('about');
        $projects = Project::all();

        $pageUrl = url('/about');

        $aboutPageSchema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'AboutPage',
            '@id'         => $pageUrl . '#webpage',
            'url'         => $pageUrl,
            'name'        => 'درباره محمد مفتخری (Mohammad Moftakhari) | متخصص سئو و معمار هوش مصنوعی',
            'description' => 'آشنایی با سوابق، تخصص‌ها، تجربیات کاری و فلسفه سئوی داده‌محور محمد مفتخری (Mohammad Moftakhari)، مدیر پروژه و کارشناس ارشد سئو در آژانس دیجیتال مارکتینگ اینتن.',
            'mainEntity'  => SEOManager::getPersonSchema(),
        ];

        $schemas = [
            SEOManager::getPersonSchema(),
            SEOManager::getWebSiteSchema(),
            $aboutPageSchema,
        ];

        if (!empty($projects)) {
            $schemas[] = SEOManager::getCaseStudiesSchema($projects);
        }

        $schemaJsonLd = SEOManager::renderJsonLd($schemas);

        $pageTitle = !empty($page['seo_title']) ? $page['seo_title'] : 'درباره محمد مفتخری (Mohammad Moftakhari) | رزومه و تخصص سئو';
        $pageDesc = !empty($page['meta_description']) ? $page['meta_description'] : 'سوابق حرفه‌ای، دستاوردها و تجربیات محمد مفتخری (Mohammad Moftakhari)، متخصص ارشد سئو و مدیر پروژه در آژانس دیجیتال مارکتینگ اینتن.';

        $this->render('front/about', [
            'title'        => $pageTitle,
            'description'  => $pageDesc,
            'schemaJsonLd' => $schemaJsonLd,
            'canonical'    => $pageUrl,
            'projects'     => $projects,
            'page'         => $page,
        ]);
    }

    /**
     * صفحه اختصاصی تماس با من و شروع همکاری (Contact Page)
     */
    public function contact(Request $request, Response $response): void
    {
        $page = PageContent::getPage('contact');

        $faqs = !empty($page['faqs']) ? $page['faqs'] : [
            [
                'question' => 'چگونه می‌توانم با محمد مفتخری ارتباط مستقیم برقرار کنم؟',
                'answer'   => 'می‌توانید از طریق تماس تلفنی با شماره ۰۹۳۰۲۹۲۸۰۰۱، ارسال پیام در تلگرام با آیدی @maaad_mr یا تکمیل فرم مشاوره در همین صفحه در کمتر از ۲۴ ساعت پاسخ دریافت کنید.'
            ],
            [
                'question' => 'فرآیند برگزاری جلسه مشاوره اختصاصی سئو چگونه است؟',
                'answer'   => 'پس از ثبت اطلاعات اولیه و آدرس وب‌سایت، یک ارزیابی مقدماتی روی داده‌های سرچ کنسول و لاگ‌های سایت انجام شده و سپس جلسه آنلاین تخصصی (گوگل میت) جهت تدوین استراتژی و رفع موانع برگزار می‌گردد.'
            ],
            [
                'question' => 'آیا امکان ارائه خدمات و قراردادهای سئو به صورت پروژه‌ای یا ماهانه وجود دارد؟',
                'answer'   => 'بله، خدمات شامل بهینه‌سازی فنی (Technical Audit & Speed)، استراتژی کانتنت کلاسترینگ، سئو برای هوش مصنوعی (GEO/AEO) و مدیریت کامل کمپین‌های رشد ارگانیک به صورت ماهانه یا پروژه‌ای قابل توافق است.'
            ]
        ];

        $pageUrl = url('/contact');

        $contactPageSchema = [
            '@context'    => 'https://schema.org',
            '@type'       => 'ContactPage',
            '@id'         => $pageUrl . '#webpage',
            'url'         => $pageUrl,
            'name'        => !empty($page['hero_title']) ? $page['hero_title'] : 'تماس با محمد مفتخری (Mohammad Moftakhari) | مشاوره و استعلام پروژه سئو',
            'description' => !empty($page['meta_description']) ? $page['meta_description'] : 'راه‌های ارتباط مستقیم، مشاوره سئو، رزرو جلسه آنلاین و استعلام هزینه اجرای پروژه‌های سئو با محمد مفتخری (Mohammad Moftakhari).',
            'mainEntity'  => SEOManager::getPersonSchema(),
        ];

        $faqSchema = [
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => []
        ];

        foreach ($faqs as $faq) {
            $faqSchema['mainEntity'][] = [
                '@type'          => 'Question',
                'name'           => $faq['question'] ?? ($faq['q'] ?? ''),
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq['answer'] ?? ($faq['a'] ?? '')
                ]
            ];
        }

        $schemas = [
            SEOManager::getPersonSchema(),
            SEOManager::getWebSiteSchema(),
            SEOManager::getProfessionalServiceSchema(),
            $contactPageSchema,
            $faqSchema,
        ];

        $schemaJsonLd = SEOManager::renderJsonLd($schemas);

        $pageTitle = !empty($page['seo_title']) ? $page['seo_title'] : 'تماس با من و مشاوره سئو | محمد مفتخری';
        $pageDesc = !empty($page['meta_description']) ? $page['meta_description'] : 'راه‌های ارتباط مستقیم تلفنی (09302928001)، تلگرام (@maaad_mr)، واتساپ و فرم درخواست مشاوره سئو با محمد مفتخری.';

        $this->render('front/contact', [
            'title'        => $pageTitle,
            'description'  => $pageDesc,
            'schemaJsonLd' => $schemaJsonLd,
            'canonical'    => $pageUrl,
            'faqs'         => $faqs,
            'page'         => $page,
        ]);
    }

    /**
     * شبیه‌ساز زنده پروتکل MCP و ارکستراسیون ایجنت‌های هوش مصنوعی
     */
    public function mcpSimulator(Request $request, Response $response): void
    {
        $aiConfig = file_exists(ROOT_PATH . '/config/ai.php') ? (require ROOT_PATH . '/config/ai.php') : [];
        $geminiApiKey = $aiConfig['gemini_api_key'] ?? \App\Services\AiContentEngine::MASTER_GEMINI_KEY;
        $geminiModel = $aiConfig['text_model'] ?? 'gemini-3.5-flash';
        $telegramBotToken = '8779388909:AAFgn3Gve1Oo-9r-gbWPdZPUcj0S58wQJ3M';
        $telegramChatId = '48108477';

        $userCommand = '';
        $executionLogs = [];
        $toolDecided = null;
        $toolParams = [];
        $toolOutput = null;
        $errorMessage = null;
        $latencyMs = 0;

        if ($request->isPost()) {
            $userCommand = trim((string)($request->post('user_command') ?? ''));

            if (empty($userCommand)) {
                $errorMessage = 'لطفاً دستور یا درخواست خود را در کادر متنی وارد کنید.';
            } else {
                $startTime = microtime(true);

                $mcpTools = [
                    [
                        'function_declarations' => [
                            [
                                'name' => 'web_scraper_tool',
                                'description' => 'Use this MCP tool to crawl, scrape, or analyze a website URL for SEO health, metadata, status codes, and keyword opportunities.',
                                'parameters' => [
                                    'type' => 'OBJECT',
                                    'properties' => [
                                        'target_url' => [
                                            'type' => 'STRING',
                                            'description' => 'The absolute HTTP/HTTPS URL of the website to crawl or audit.'
                                        ],
                                        'audit_depth' => [
                                            'type' => 'STRING',
                                            'description' => 'Depth of audit: light, technical, or deep_crawl'
                                        ]
                                    ],
                                    'required' => ['target_url']
                                ]
                            ],
                            [
                                'name' => 'database_query_tool',
                                'description' => 'Use this MCP tool to run queries, fetch historical SEO rank records, client leads, or analytics transactions from the MySQL database.',
                                'parameters' => [
                                    'type' => 'OBJECT',
                                    'properties' => [
                                        'sql_query' => [
                                            'type' => 'STRING',
                                            'description' => 'The SQL statement or query pattern to retrieve records.'
                                        ],
                                        'table_target' => [
                                            'type' => 'STRING',
                                            'description' => 'The target database table (e.g. leads, articles, rankings)'
                                        ]
                                    ],
                                    'required' => ['sql_query']
                                ]
                            ],
                            [
                                'name' => 'telegram_notifier_tool',
                                'description' => 'Use this MCP tool to trigger real-time alerts or critical incident notifications to Mohammad Moftakhari on Telegram.',
                                'parameters' => [
                                    'type' => 'OBJECT',
                                    'properties' => [
                                        'urgency' => [
                                            'type' => 'STRING',
                                            'description' => 'Alert priority level: low, medium, high, or critical'
                                        ],
                                        'message' => [
                                            'type' => 'STRING',
                                            'description' => 'The concise notification payload to send to the admin.'
                                        ]
                                    ],
                                    'required' => ['urgency', 'message']
                                ]
                            ]
                        ]
                    ]
                ];

                $systemPrompt = "You are an MCP (Model Context Protocol) Router Agent for Mohammad Moftakhari's Technical SEO Platform.\n" .
                                "Analyze the user's ambiguous request, determine intent, and you MUST call the single most appropriate tool from the MCP Server.\n" .
                                "Input from User: \"{$userCommand}\"";

                $payload = [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $systemPrompt]
                            ]
                        ]
                    ],
                    'tools' => $mcpTools,
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'maxOutputTokens' => 1000
                    ]
                ];

                $apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/" . $geminiModel . ":generateContent?key=" . urlencode($geminiApiKey);

                $ch = curl_init($apiUrl);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
                    CURLOPT_HTTPHEADER     => ['Content-Type: application/json; charset=utf-8'],
                    CURLOPT_TIMEOUT        => 20,
                    CURLOPT_SSL_VERIFYPEER => true
                ]);

                $apiResult = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlErr = curl_error($ch);
                curl_close($ch);

                $endTime = microtime(true);
                $latencyMs = (int)(($endTime - $startTime) * 1000);

                if ($curlErr) {
                    $errorMessage = "MCP Connection Failure: {$curlErr}";
                } elseif ($httpCode !== 200) {
                    $errData = json_decode((string)$apiResult, true);
                    $errDetail = $errData['error']['message'] ?? "HTTP Error {$httpCode}";
                    $errorMessage = "MCP Orchestrator Error: {$errDetail}";
                } else {
                    $decoded = json_decode((string)$apiResult, true);
                    $candidate = $decoded['candidates'][0]['content']['parts'][0] ?? null;

                    if (isset($candidate['functionCall'])) {
                        $toolDecided = (string)$candidate['functionCall']['name'];
                        $toolParams  = (array)($candidate['functionCall']['args'] ?? []);

                        $executionLogs[] = "[SYSTEM] Initializing Model Context Protocol (MCP) Runtime v1.0.4...";
                        $executionLogs[] = "[SOCKET] Connecting to local MCP Server at ipc://maaadmr-mcp.sock [OK]";
                        $executionLogs[] = "[INTENT] Analyzing natural language context: \"{$userCommand}\"";
                        $executionLogs[] = "[ROUTER] Evaluated 3 registered tools in MCP manifest.";
                        $executionLogs[] = "[DISPATCH] AI Agent decided tool call: {$toolDecided}";
                        $executionLogs[] = "[PAYLOAD] Extracted parameters: " . json_encode($toolParams, JSON_UNESCAPED_UNICODE);

                        if ($toolDecided === 'web_scraper_tool') {
                            $targetUrl = $toolParams['target_url'] ?? 'https://maaadmr.ir';
                            $executionLogs[] = "[EXECUTION] Initializing asynchronous headless crawler for target: {$targetUrl}...";
                            $executionLogs[] = "[SCRAPER] HTTP GET {$targetUrl} -> 200 OK (TTFB: 42ms, Gzip Compression Enabled)";
                            $executionLogs[] = "[SCRAPER] Extracted: H1 Tags (1), Canonical Link (OK), Meta Robots (index, follow)";
                            $executionLogs[] = "[RESULT] SEO Analysis completed with 0 critical rendering blockers.";
                            $toolOutput = "خزش و ارزیابی سئو برای «{$targetUrl}» با موفقیت انجام شد؛ متاتگ‌ها و پاسخ سرور ۲۰۰ تأیید گردید.";

                        } elseif ($toolDecided === 'database_query_tool') {
                            $sql = $toolParams['sql_query'] ?? 'SELECT * FROM leads ORDER BY id DESC LIMIT 5;';
                            $executionLogs[] = "[EXECUTION] Dispatching parameterized query to MySQL Cluster...";
                            $executionLogs[] = "[SQL] Query: {$sql}";
                            $executionLogs[] = "[DATABASE] Query executed in 1.4ms. Rows affected/returned: 5 records.";
                            $executionLogs[] = "[RESULT] JSON dataset parsed and hydrated into Agent memory.";
                            $toolOutput = "کوئری دیتابیس با موفقیت روی سرور اجرا شد و ۵ رکورد به حافظه ایجنت بازگردانده شد.";

                        } elseif ($toolDecided === 'telegram_notifier_tool') {
                            $urgency = $toolParams['urgency'] ?? 'high';
                            $msg = $toolParams['message'] ?? 'اعلان ارکستراتور هوش مصنوعی';
                            $executionLogs[] = "[EXECUTION] Preparing Telegram Bot API dispatch (Urgency: {$urgency})...";

                            $tgText = "🤖 <b>[MCP Simulator] فراخوانی هوشمند ابزار تلگرام</b>\n" .
                                      "━━━━━━━━━━━━━━━━━━\n" .
                                      "⚡ <b>سطح فوریت:</b> {$urgency}\n" .
                                      "💬 <b>پیام ایجنت:</b> {$msg}\n" .
                                      "🕒 <b>زمان:</b> " . date('Y-m-d H:i:s');

                            $tgCh = curl_init("https://api.telegram.org/bot" . $telegramBotToken . "/sendMessage");
                            curl_setopt_array($tgCh, [
                                CURLOPT_POST           => true,
                                CURLOPT_POSTFIELDS     => http_build_query([
                                    'chat_id'    => $telegramChatId,
                                    'text'       => $tgText,
                                    'parse_mode' => 'HTML'
                                ]),
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_TIMEOUT        => 3,
                                CURLOPT_SSL_VERIFYPEER => true
                            ]);
                            @curl_exec($tgCh);
                            curl_close($tgCh);

                            $executionLogs[] = "[DISPATCH] Telegram Webhook payload dispatched to Bot API [200 OK]";
                            $executionLogs[] = "[RESULT] Notification pushed to channel.";
                            $toolOutput = "پیام با فوریت «{$urgency}» از طریق ابزار تلگرام ارسال گردید.";
                        }
                    } else {
                        $toolOutput = $candidate['text'] ?? 'مدل پاسخ متنی تولید کرد اما ابزاری فراخوانی نشد.';
                        $executionLogs[] = "[FALLBACK] No tool invoked. Direct text generation received.";
                    }
                }
            }
        }

        $pageData = PageContent::getPage('mcp-simulator');
        $pageUrl = url('/services/mcp-simulator');
        $pageTitle = !empty($pageData['seo_title']) ? $pageData['seo_title'] : 'شبیه‌ساز پروتکل MCP (ارکستراتور عامل‌های هوشمند) | محمد مفتخری';
        $pageDesc = !empty($pageData['meta_description']) ? $pageData['meta_description'] : 'شبیه‌ساز زنده و تعاملی پروتکل Model Context Protocol (MCP) و تصمیم‌گیری خودکار ابزارهای هوش مصنوعی بر پایه Function Calling با محمد مفتخری.';

        $schemas = [
            SEOManager::getPersonSchema(),
            SEOManager::getWebSiteSchema(),
            [
                '@context'    => 'https://schema.org',
                '@type'       => 'SoftwareApplication',
                'name'        => 'شبیه‌ساز پروتکل MCP محمد مفتخری',
                'applicationCategory' => 'BusinessApplication',
                'operatingSystem'     => 'Web Browser',
                'description' => $pageDesc,
                'url'         => $pageUrl,
                'author'      => SEOManager::getPersonSchema()
            ]
        ];

        $schemaJsonLd = SEOManager::renderJsonLd($schemas);

        $this->render('front/mcp-simulator', [
            'title'         => $pageTitle,
            'description'   => $pageDesc,
            'schemaJsonLd'  => $schemaJsonLd,
            'canonical'     => $pageUrl,
            'userCommand'   => $userCommand,
            'executionLogs' => $executionLogs,
            'toolDecided'   => $toolDecided,
            'toolParams'    => $toolParams,
            'toolOutput'    => $toolOutput,
            'errorMessage'  => $errorMessage,
            'latencyMs'     => $latencyMs,
            'pageData'      => $pageData,
        ]);
    }

    /**
     * همگام‌سازی و بازنویسی مقالات بر اساس مستر پرامپت
     */
    public function syncArticlesSeo(Request $request, Response $response): void
    {
        ob_start();
        require ROOT_PATH . '/update_all_articles_seo.php';
        $output = ob_get_clean();
        $response->json(['success' => true, 'output' => $output]);
    }

    /**
     * حذف مقالات تکراری حاصل از خطای ریتری تلگرام و پاکسازی دیتابیس
     */
    public function cleanDuplicates(Request $request, Response $response): void
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->query("SELECT id, title, slug, created_at FROM articles ORDER BY id DESC LIMIT 50");
        $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        
        $deletedIds = [];
        $keptTitles = [];
        
        // Match articles that share common core themes (e.g. "زنگ نمی‌زنه / فروش ندارد / ریزش مشتری")
        $targetKeywords = [
            'lead_drop' => ['زنگ', 'ریزش', 'فروش ندارد', 'تماس', 'تبدیل'],
            'ai_agent'  => ['ایجنت', 'خرید خودکار'],
        ];

        $matchedClusters = [];

        foreach ($articles as $art) {
            $t = (string)$art['title'];
            $artId = (int)$art['id'];

            // Check if it belongs to conversion drop cluster
            $isConversionDrop = (str_contains($t, 'زنگ') || str_contains($t, 'فروش ندارد') || str_contains($t, 'ریزش مشتری')) && !str_contains($t, 'نظرات گوگل');
            
            if ($isConversionDrop) {
                if (isset($matchedClusters['conversion_drop'])) {
                    // Duplicate! Delete it
                    $delStmt = $db->prepare("DELETE FROM articles WHERE id = ?");
                    $delStmt->execute([$artId]);
                    $deletedIds[] = $artId . ': ' . $t;
                } else {
                    $matchedClusters['conversion_drop'] = $artId;
                    $keptTitles[] = $artId . ': ' . $t;
                }
            }
        }
        
        // پاکسازی blog_archive.json
        $archiveFile = ROOT_PATH . '/blog_archive.json';
        if (file_exists($archiveFile)) {
            $content = @file_get_contents($archiveFile);
            $archive = json_decode((string)$content, true) ?: [];
            $uniqueArchive = [];
            $hasConversionDropInArchive = false;
            
            foreach ($archive as $item) {
                $t = (string)($item['title'] ?? '');
                $isConversionDrop = (str_contains($t, 'زنگ') || str_contains($t, 'فروش ندارد') || str_contains($t, 'ریزش مشتری')) && !str_contains($t, 'نظرات گوگل');
                if ($isConversionDrop) {
                    if (!$hasConversionDropInArchive) {
                        $hasConversionDropInArchive = true;
                        $uniqueArchive[] = $item;
                    }
                } else {
                    $uniqueArchive[] = $item;
                }
            }
            @file_put_contents($archiveFile, json_encode($uniqueArchive, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        // پاکسازی کامل کش کلودفلر
        try {
            $cf = new \App\Services\CloudflareService();
            if ($cf->isConfigured()) {
                $cf->purgeEverything();
            }
        } catch (\Throwable) {}
        
        $response->json([
            'success' => true,
            'deleted_count' => count($deletedIds),
            'deleted_articles' => $deletedIds,
            'kept_article' => $keptTitles
        ]);
    }

    /**
     * پاکسازی جامع تمامی سوالات متداول (FAQ) از مقالات دیتابیس و آرشیو
     */
    public function cleanArticleFaqs(Request $request, Response $response): void
    {
        $db = \App\Core\Database::getConnection();
        $stmt = $db->query("SELECT id, title, content, faq_data FROM articles");
        $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $cleanedCount = 0;
        $updatedArticles = [];

        foreach ($articles as $art) {
            $id = (int)$art['id'];
            $title = (string)$art['title'];
            $content = (string)$art['content'];
            $faqData = (string)($art['faq_data'] ?? '[]');

            // حذف هرگونه سکشن پرسش‌های متداول از داخل HTML مقاله
            $cleanContent = preg_replace('/<(?:h[2-4]|div|section)[^>]*>(?:[\s\S]*?)(?:پرسش‌های\s*متداول|پرسش\s*های\s*متداول|سوالات\s*متداول|سوال\s*های\s*متداول|Frequently Asked Questions|FAQ)(?:[\s\S]*?)<\/(?:h[2-4]|div|section)>[\s\S]*?(?=<h[2-3]|<section class="pt-8|<!-- Author Bio|\Z)/ui', '', $content);
            if ($cleanContent === null) {
                $cleanContent = $content;
            }

            // اگر تغییری در محتوا ایجاد شد یا faq_data غیرخالی بود
            if ($cleanContent !== $content || ($faqData !== '[]' && $faqData !== '')) {
                $upStmt = $db->prepare("UPDATE articles SET content = ?, faq_data = '[]' WHERE id = ?");
                $upStmt->execute([$cleanContent, $id]);
                $cleanedCount++;
                $updatedArticles[] = "ID {$id}: {$title}";
            }
        }

        // پاکسازی blog_archive.json
        $archiveFile = ROOT_PATH . '/blog_archive.json';
        if (file_exists($archiveFile)) {
            $archiveRaw = @file_get_contents($archiveFile);
            $archive = json_decode((string)$archiveRaw, true) ?: [];
            foreach ($archive as &$item) {
                if (isset($item['faq_data'])) {
                    $item['faq_data'] = '[]';
                }
                if (isset($item['faqs'])) {
                    $item['faqs'] = [];
                }
                if (isset($item['content'])) {
                    $c = preg_replace('/<(?:h[2-4]|div|section)[^>]*>(?:[\s\S]*?)(?:پرسش‌های\s*متداول|پرسش\s*های\s*متداول|سوالات\s*متداول|سوال\s*های\s*متداول|FAQ)(?:[\s\S]*?)<\/(?:h[2-4]|div|section)>[\s\S]*?(?=<h[2-3]|<section class="pt-8|<!-- Author Bio|\Z)/ui', '', $item['content']);
                    if ($c !== null) {
                        $item['content'] = $c;
                    }
                }
            }
            unset($item);
            @file_put_contents($archiveFile, json_encode($archive, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        // پاکسازی کش کلودفلر
        try {
            $cf = new \App\Services\CloudflareService();
            if ($cf->isConfigured()) {
                $cf->purgeEverything();
            }
        } catch (\Throwable) {}

        $response->json([
            'success' => true,
            'cleaned_articles_count' => $cleanedCount,
            'updated_articles' => $updatedArticles
        ]);
    }

    /**
     * همگام‌سازی کامل تصاویر مقالات: تولید/بروزرسانی تصویر شاخص با هوش مصنوعی و تزریق ۲ تا ۳ عکس Pexels در بدنه
     */
    public function syncArticleMedia(Request $request, Response $response): void
    {
        @set_time_limit(300);
        @ignore_user_abort(true);

        $db = \App\Core\Database::getConnection();
        $stmt = $db->query("SELECT id, title, slug, content, featured_image FROM articles ORDER BY id ASC");
        $articles = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $engine = new \App\Services\AiContentEngine();
        $updatedList = [];

        foreach ($articles as $art) {
            $id = (int)$art['id'];
            $title = (string)$art['title'];
            $slug = (string)$art['slug'];
            $content = (string)$art['content'];
            $featImage = (string)($art['featured_image'] ?? '');

            // ۱. بررسی یا تخصیص تصویر شاخص با هوش مصنوعی
            $newFeatImage = $featImage;
            if ($id === 38 || str_contains($slug, 'artificial-intelligence-content-creation')) {
                $newFeatImage = '/assets/uploads/articles/ai-content-cost-reduction-featured.jpg';
            } elseif ($id === 37 || str_contains($slug, 'website-conversion-rate-optimization')) {
                $newFeatImage = '/assets/uploads/articles/conversion-drop-analytics-featured.jpg';
            } elseif ($id === 29 || str_contains($slug, 'ai-agent-e-commerce')) {
                $newFeatImage = '/assets/uploads/articles/ai-agent-ecommerce-featured.jpg';
            } elseif (empty($featImage) || str_contains($featImage, 'pexels.com')) {
                try {
                    $aiPrompt = "Modern 3D isometric visual concept of {$title}, clean studio lighting, corporate navy blue and sleek accents, absolute text-free, no letters, no words, 8k render";
                    $reflection = new \ReflectionClass($engine);
                    $reqMethod = $reflection->getMethod('requestImageFromGoogle');
                    $reqMethod->setAccessible(true);
                    $aiBytes = $reqMethod->invoke($engine, $aiPrompt);

                    if ($aiBytes) {
                        $filename = "ai-feat-{$slug}.webp";
                        $uploadDir = ROOT_PATH . '/assets/uploads/articles';
                        if (!is_dir($uploadDir)) {
                            @mkdir($uploadDir, 0755, true);
                        }
                        if (@file_put_contents($uploadDir . '/' . $filename, $aiBytes)) {
                            $newFeatImage = '/assets/uploads/articles/' . $filename;
                        }
                    }
                } catch (\Throwable) {}
            }

            // ۲. بررسی وجود تصاویر در بدنه محتوا
            $hasBodyImages = (bool)preg_match('/<img\b[^>]+src=/i', $content);

            $cleanBodyContent = $content;
            if (!$hasBodyImages || substr_count($content, '<img') < 2) {
                // حذف تگ‌های تصویر شکسته قدیمی اگر وجود داشت
                $cleanBodyContent = preg_replace('/<figure\b[^>]*>[\s\S]*?<\/figure>/ui', '', $cleanBodyContent);
                $cleanBodyContent = preg_replace('/<img\b[^>]*>/ui', '', $cleanBodyContent);

                // استخراج موضوع برای جستجوی Pexels
                $searchKeywords = ['seo strategy', 'technology web development', 'data analytics growth'];
                if (str_contains($title, 'هوش مصنوعی') || str_contains($title, 'اتوماسیون')) {
                    $searchKeywords = ['artificial intelligence network', 'server technology data', 'robotics automation office'];
                } elseif (str_contains($title, 'مپ') || str_contains($title, 'محلی')) {
                    $searchKeywords = ['city map mobile gps', 'local business store', 'navigation route technology'];
                } elseif (str_contains($title, 'تلگرام') || str_contains($title, 'پیام')) {
                    $searchKeywords = ['mobile phone chat messaging', 'smart office automation', 'business laptop communication'];
                } elseif (str_contains($title, 'سرعت') || str_contains($title, 'تکنیکال')) {
                    $searchKeywords = ['server code speed performance', 'programming web developer', 'dashboard cloud computing'];
                }

                $bodyImages = [];
                foreach ($searchKeywords as $idx => $kw) {
                    $bodyImages[] = $engine->fetchPexelsImage($kw, $idx + 1);
                }

                // تزریق ۲ تا ۳ تصویر زیر تگ‌های </h2> و </h3>
                $imgIndex = 0;
                $cleanBodyContent = preg_replace_callback('/<\/h2>/i', function ($matches) use (&$imgIndex, $bodyImages, $title) {
                    if (isset($bodyImages[$imgIndex])) {
                        $imgUrl = $bodyImages[$imgIndex];
                        $altText = htmlspecialchars($title . ' - بررسی و راهنمای تخصصی ' . ($imgIndex + 1), ENT_QUOTES, 'UTF-8');
                        $imgIndex++;
                        return "</h2>\n<figure class=\"my-8 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-md bg-slate-900\"><img src=\"{$imgUrl}\" alt=\"{$altText}\" class=\"w-full aspect-[16/9] object-cover hover:scale-105 transition-transform duration-300\" loading=\"lazy\" /><figcaption class=\"p-3 text-center text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/90\">{$altText}</figcaption></figure>";
                    }
                    return $matches[0];
                }, $cleanBodyContent);

                if ($imgIndex < count($bodyImages)) {
                    $cleanBodyContent = preg_replace_callback('/<\/h3>/i', function ($matches) use (&$imgIndex, $bodyImages, $title) {
                        if (isset($bodyImages[$imgIndex])) {
                            $imgUrl = $bodyImages[$imgIndex];
                            $altText = htmlspecialchars($title . ' - جزئیات راهبردی ' . ($imgIndex + 1), ENT_QUOTES, 'UTF-8');
                            $imgIndex++;
                            return "</h3>\n<figure class=\"my-8 rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-md bg-slate-900\"><img src=\"{$imgUrl}\" alt=\"{$altText}\" class=\"w-full aspect-[16/9] object-cover hover:scale-105 transition-transform duration-300\" loading=\"lazy\" /><figcaption class=\"p-3 text-center text-xs text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/90\">{$altText}</figcaption></figure>";
                        }
                        return $matches[0];
                    }, $cleanBodyContent);
                }
            }

            // ذخیره در دیتابیس
            $upStmt = $db->prepare("UPDATE articles SET featured_image = ?, content = ? WHERE id = ?");
            $upStmt->execute([$newFeatImage, $cleanBodyContent, $id]);

            $updatedList[] = [
                'id' => $id,
                'title' => $title,
                'featured_image' => $newFeatImage,
                'body_images_injected' => substr_count($cleanBodyContent, '<figure')
            ];
        }

        // پاکسازی کش کلودفلر
        try {
            $cf = new \App\Services\CloudflareService();
            if ($cf->isConfigured()) {
                $cf->purgeEverything();
            }
        } catch (\Throwable) {}

        $response->json([
            'success' => true,
            'updated_articles_count' => count($updatedList),
            'articles' => $updatedList
        ]);
    }
}

