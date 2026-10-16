<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Env;
use RuntimeException;
use JsonException;

/**
 * Class AiOrchestrator
 *
 * Multi-LLM Orchestration Service for maaadmr.ir
 * 
 * Strategic Model Division:
 * 1. Live Chat (Fast Conversational Sales): Gemini (via Cloudflare AI Gateway) -> Fallback: DeepSeek
 * 2. Technical SEO Auditing (Deep Logic & Code): DeepSeek (Reasoning & Strict JSON Schema)
 * 3. Competitor In-Depth Content Analysis (Massive Context): Kimi Moonshot (128k-200k Token Window)
 *
 * Network Hardening:
 * - IPv4 resolution forced (CURL_IPRESOLVE_V4) for Iranian hosting stability.
 * - HTTP/1.1 forced to avoid broken HTTP/2 streams across Iranian gateways.
 * - Granular cURL connect and execution timeouts.
 */
class AiOrchestrator
{
    private string $cfAccountId;
    private string $cfGatewaySlug;
    private string $cfApiToken;
    private string $geminiApiKey;
    private string $deepseekApiKey;
    private string $kimiApiKey;
    private string $deepseekEndpoint;
    private string $kimiEndpoint;

    public function __construct()
    {
        // Load configuration securely from Env helper, $_ENV, or getenv()
        $this->cfAccountId      = (string)($this->resolveEnv('CF_AI_GATEWAY_ACCOUNT_ID') ?? '');
        $this->cfGatewaySlug    = (string)($this->resolveEnv('CF_AI_GATEWAY_SLUG') ?? 'default');
        $this->cfApiToken       = (string)($this->resolveEnv('CF_AI_GATEWAY_TOKEN') ?? '');
        
        $this->geminiApiKey     = (string)($this->resolveEnv('GEMINI_API_KEY') ?? '');
        $this->deepseekApiKey   = (string)($this->resolveEnv('DEEPSEEK_API_KEY') ?? '');
        $this->kimiApiKey       = (string)($this->resolveEnv('KIMI_API_KEY') ?? '');

        $this->deepseekEndpoint = (string)($this->resolveEnv('DEEPSEEK_ENDPOINT') ?? 'https://api.deepseek.com/v1/chat/completions');
        $this->kimiEndpoint     = (string)($this->resolveEnv('KIMI_ENDPOINT') ?? 'https://api.moonshot.ai/v1/chat/completions');
    }

    /**
     * Resolve environment variable across multiple PHP runtimes.
     */
    private function resolveEnv(string $key): ?string
    {
        if (class_exists(Env::class)) {
            $val = Env::get($key);
            if (!empty($val)) {
                return (string)$val;
            }
        }
        if (!empty($_ENV[$key])) {
            return (string)$_ENV[$key];
        }
        $env = getenv($key);
        return ($env !== false && $env !== '') ? (string)$env : null;
    }

    // =========================================================================
    // TASK 1: Live Chat Widget (Gemini -> DeepSeek via Cloudflare Universal Gateway)
    // =========================================================================

    /**
     * Handles live chat conversation with ultra-low latency.
     * Uses Cloudflare AI Gateway Universal Endpoint to attempt Gemini first,
     * and automatically failover to DeepSeek if rate-limited or degraded.
     *
     * @param string $userMessage The incoming message from visitor
     * @param array $sessionHistory Formatted conversation history [['role' => 'user'|'assistant', 'content' => '...']]
     * @return string Generated assistant reply
     */
    public function handleLiveChat(string $userMessage, array $sessionHistory = []): string
    {
        $systemInstruction = "شما مشاور فروش و دستیار هوشمند اختصاصی وب‌سایت مهندس محمد مفتخری (Mohammad Moftakhari - استراتژیست سئو تکنیکال و برنامه‌نویس وب) هستید.\n"
            . "هدف: پاسخ کوتاه (حداکثر ۱ تا ۲ پاراگراف فشرده)، لحن حرفه‌ای و هدایت طبیعی مخاطب به خدمات سایت یا فرم شروع همکاری (/start).\n"
            . "قانون مهم: در مکالمات پیوسته سلام را مجدداً تکرار نکنید و مستقیماً پاسخ کاربر را بدهید.";

        // If Cloudflare AI Gateway is configured, run via Universal Endpoint
        if (!empty($this->cfAccountId) && !empty($this->cfGatewaySlug)) {
            try {
                $cfResponse = $this->callCloudflareUniversalGateway($userMessage, $sessionHistory, $systemInstruction);
                if (!empty($cfResponse)) {
                    return $cfResponse;
                }
            } catch (\Throwable $e) {
                error_log('[AiOrchestrator] Cloudflare Gateway failed: ' . $e->getMessage());
            }
        }

        // Direct Failover 1: Google Gemini Direct API
        if (!empty($this->geminiApiKey)) {
            $geminiDirect = $this->callGeminiDirect($userMessage, $sessionHistory, $systemInstruction);
            if (!empty($geminiDirect)) {
                return $geminiDirect;
            }
        }

        // Direct Failover 2: DeepSeek Direct API
        if (!empty($this->deepseekApiKey)) {
            $deepseekDirect = $this->callDeepseekChat([
                ['role' => 'system', 'content' => $systemInstruction],
                ...$sessionHistory,
                ['role' => 'user', 'content' => $userMessage]
            ], 0.6, 500);

            if (!empty($deepseekDirect)) {
                return $deepseekDirect;
            }
        }

        // Final graceful fallback if all networks are offline
        return "درود! خوشحالم که در وب‌سایت محمد مفتخری همراه ما هستید. برای بررسی اختصاصی پروژه یا رزرو وقت مشاوره، لطفاً از بخش <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم شروع همکاری</a> اقدام فرمایید تا در کوتاه‌ترین زمان با شما تماس بگیریم.";
    }

    /**
     * Calls Cloudflare AI Gateway Universal Endpoint with sequential fallback array.
     */
    private function callCloudflareUniversalGateway(string $userMessage, array $sessionHistory, string $systemInstruction): ?string
    {
        $url = sprintf(
            'https://gateway.ai.cloudflare.com/v1/%s/%s',
            rawurlencode($this->cfAccountId),
            rawurlencode($this->cfGatewaySlug)
        );

        // 1. Prepare Gemini contents structure
        $geminiContents = [];
        foreach ($sessionHistory as $msg) {
            $geminiContents[] = [
                'role' => ($msg['role'] === 'user' ? 'user' : 'model'),
                'parts' => [['text' => (string)($msg['content'] ?? '')]]
            ];
        }
        $geminiContents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        // 2. Prepare DeepSeek messages structure
        $deepseekMessages = [
            ['role' => 'system', 'content' => $systemInstruction]
        ];
        foreach ($sessionHistory as $msg) {
            $deepseekMessages[] = [
                'role' => ($msg['role'] === 'user' ? 'user' : 'assistant'),
                'content' => (string)($msg['content'] ?? '')
            ];
        }
        $deepseekMessages[] = ['role' => 'user', 'content' => $userMessage];

        // 3. Construct Universal Endpoint Fallback Array
        // Cloudflare attempts Item 0 (Gemini). If it encounters 4xx/5xx or rate limit, it falls back to Item 1 (DeepSeek).
        $universalPayload = [
            [
                'provider' => 'google-ai-studio',
                'endpoint' => 'v1beta/models/gemini-2.5-flash:generateContent',
                'headers'  => [
                    'x-goog-api-key' => $this->geminiApiKey,
                    'Content-Type'   => 'application/json'
                ],
                'query'    => [
                    'key' => $this->geminiApiKey
                ],
                'body'     => [
                    'system_instruction' => [
                        'parts' => [['text' => $systemInstruction]]
                    ],
                    'contents' => $geminiContents,
                    'generationConfig' => [
                        'temperature'     => 0.6,
                        'maxOutputTokens' => 800,
                        'topP'            => 0.95
                    ]
                ]
            ],
            [
                'provider' => 'deepseek',
                'endpoint' => 'chat/completions',
                'headers'  => [
                    'Authorization' => 'Bearer ' . $this->deepseekApiKey,
                    'Content-Type'  => 'application/json'
                ],
                'body'     => [
                    'model'       => 'deepseek-chat',
                    'messages'    => $deepseekMessages,
                    'temperature' => 0.6,
                    'max_tokens'  => 800
                ]
            ]
        ];

        $headers = [
            'Content-Type: application/json; charset=utf-8',
            'Accept: application/json',
            'cf-cache-ttl: 86400', // Cache repeated questions at Cloudflare Edge
        ];

        if (!empty($this->cfApiToken)) {
            $headers[] = 'Authorization: Bearer ' . $this->cfApiToken;
            $headers[] = 'cf-aig-authorization: Bearer ' . $this->cfApiToken;
        }

        $rawResponse = $this->executeCurl($url, 'POST', $universalPayload, $headers, 7, 3);
        if (!$rawResponse) {
            return null;
        }

        $data = json_decode($rawResponse, true);
        if (!is_array($data)) {
            return null;
        }

        // If returned from Gemini schema
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            return trim((string)$data['candidates'][0]['content']['parts'][0]['text']);
        }

        // If returned from DeepSeek / OpenAI schema
        if (isset($data['choices'][0]['message']['content'])) {
            return trim((string)$data['choices'][0]['message']['content']);
        }

        return null;
    }

    /**
     * Direct call to Google Gemini API (Backup for Cloudflare Gateway).
     */
    private function callGeminiDirect(string $userMessage, array $sessionHistory, string $systemInstruction): ?string
    {
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . urlencode($this->geminiApiKey);

        $contents = [];
        foreach ($sessionHistory as $msg) {
            $contents[] = [
                'role' => ($msg['role'] === 'user' ? 'user' : 'model'),
                'parts' => [['text' => (string)($msg['content'] ?? '')]]
            ];
        }
        $contents[] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];

        $payload = [
            'system_instruction' => [
                'parts' => [['text' => $systemInstruction]]
            ],
            'contents' => $contents,
            'generationConfig' => [
                'temperature'     => 0.6,
                'maxOutputTokens' => 800,
            ]
        ];

        $raw = $this->executeCurl($url, 'POST', $payload, [
            'Content-Type: application/json; charset=utf-8',
            'x-goog-api-key: ' . $this->geminiApiKey
        ], 6, 3);

        if (!$raw) {
            return null;
        }

        $res = json_decode($raw, true);
        return $res['candidates'][0]['content']['parts'][0]['text'] ?? null;
    }


    // =========================================================================
    // TASK 2: Technical SEO Audit (DeepSeek - Deep Logic & Strict JSON Schema)
    // =========================================================================

    /**
     * Audits raw HTML, server logs, or Lighthouse/CWV metrics using DeepSeek.
     * DeepSeek excels at logic verification, regex, code refactoring, and strict JSON output.
     *
     * @param string $htmlOrLogData Full HTML source, HTTP headers, or crawl log
     * @return array Structured audit report with score, critical issues, and actionable fixes
     * @throws RuntimeException If DeepSeek returns invalid JSON or fails
     */
    public function auditTechnicalSeo(string $htmlOrLogData): array
    {
        if (empty($this->deepseekApiKey)) {
            throw new RuntimeException('[AiOrchestrator] DeepSeek API key is not configured.');
        }

        $systemPrompt = <<<SYS
You are an Elite Technical SEO Auditor and Senior Web Architect.
Analyze the provided HTML source, server response, or performance metrics with surgical precision.

Inspect:
1. DOM Hygiene: Clean DOM, excessive DOM depth, text-to-HTML ratio.
2. Indexation & Canonical Integrity: Rel canonical self-referential vs cross-domain, robots meta tags, noindex leaks.
3. Structured Data: JSON-LD schema validity, syntax errors, missing required properties (Article, Organization, BreadcrumbList).
4. Performance & Core Web Vitals: Render-blocking assets, script defer/async, image dimensions, lazy loading.
5. AI Search Visibility (GEO/AEO): Entity anchoring, semantic heading hierarchy (H1-H4), BLUF answer density.

CRITICAL INSTRUCTION:
You MUST respond ONLY with a valid RFC8259 JSON object. Do not include markdown formatting, backticks, or conversational commentary.
Strict JSON Schema:
{
  "audit_timestamp": "ISO-8601 string",
  "technical_health_score": 0-100,
  "summary": "Brief executive summary in Persian",
  "critical_issues": [
    {
      "code": "ISSUE_CODE",
      "severity": "CRITICAL" | "HIGH" | "MEDIUM" | "LOW",
      "impact": "Explanation of ranking or indexing impact",
      "location": "Tag or line reference",
      "recommendation": "Concrete fix code snippet"
    }
  ],
  "schema_evaluations": {
    "detected_types": ["string"],
    "is_valid": true|false,
    "missing_opportunities": ["string"]
  },
  "action_plan_priority": [
    "Step 1: ...",
    "Step 2: ..."
  ]
}
SYS;

        // Truncate input if excessive to maintain optimal reasoning performance
        $sanitizedInput = mb_substr($htmlOrLogData, 0, 50000);

        $payload = [
            'model' => 'deepseek-chat', // or 'deepseek-reasoner' for ultra-deep chain-of-thought
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => "Audit this technical data:\n\n" . $sanitizedInput]
            ],
            'response_format' => [
                'type' => 'json_object' // Strict JSON mode guarantee
            ],
            'temperature' => 0.1, // Near-deterministic for reliable code audit
            'max_tokens'  => 3000
        ];

        $headers = [
            'Authorization: Bearer ' . $this->deepseekApiKey,
            'Content-Type: application/json; charset=utf-8'
        ];

        $rawResponse = $this->executeCurl($this->deepseekEndpoint, 'POST', $payload, $headers, 45, 10);
        if (!$rawResponse) {
            throw new RuntimeException('[AiOrchestrator] DeepSeek API returned an empty response.');
        }

        $decoded = json_decode($rawResponse, true);
        $content = $decoded['choices'][0]['message']['content'] ?? null;

        if (!$content) {
            throw new RuntimeException('[AiOrchestrator] DeepSeek failed to return choices content.');
        }

        // Clean potential markdown tags if present
        $cleanJson = trim(preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim((string)$content)));

        try {
            return json_decode($cleanJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('[AiOrchestrator] Failed to parse DeepSeek JSON response: ' . $e->getMessage() . "\nRaw: " . $cleanJson);
        }
    }


    // =========================================================================
    // TASK 3: Competitor Content Analysis (Kimi Moonshot - Massive 128k Context)
    // =========================================================================

    /**
     * Reads massive competitor articles (10,000+ words) and extracts semantic entities,
     * topical authority gaps, and LSI keyword structures using Kimi (Moonshot AI).
     *
     * @param string $massiveTextContent Scraped competitor text, multiple blog posts, or corpus
     * @return array Semantic entity map, competitor angles, and target keywords
     * @throws RuntimeException If Kimi API fails or account requires recharge
     */
    public function analyzeCompetitorContent(string $massiveTextContent): array
    {
        if (empty($this->kimiApiKey)) {
            throw new RuntimeException('[AiOrchestrator] Kimi (Moonshot) API key is not configured.');
        }

        $systemPrompt = <<<SYS
You are a Principal Information Retrieval and Semantic SEO Scientist.
You have been given a massive corpus of competitor content (10,000+ words).
Your job is to read the entire corpus exhaustively and extract high-value semantic intelligence.

Analyze:
1. Primary Entities & Knowledge Graph Nodes (Wikidata / Google Knowledge Graph equivalents).
2. LSI & Secondary Semantic Keyword Clusters (including search intent classification).
3. Topical Authority Gaps: Critical subtopics, questions, or statistics the competitors completely missed.
4. Content Angle Distribution: Dominant angles (Commercial, Educational, Case Study, Technical).
5. Actionable Content Blueprint: The ultimate outline needed to outperform this entire corpus in Google & AI Search (Perplexity/ChatGPT).

CRITICAL REQUIREMENT:
Output strictly valid JSON with no markdown wrapping or preamble.
JSON Schema:
{
  "corpus_word_count": 0,
  "primary_entities": [
    {"entity": "string", "relevance_score": 0.0-1.0, "context": "how competitor used it"}
  ],
  "lsi_keyword_clusters": {
    "cluster_name": ["keyword1", "keyword2"]
  },
  "content_gaps": [
    {"topic": "string", "opportunity": "why this will win in search"}
  ],
  "competitor_weaknesses": ["string"],
  "recommended_master_outline": [
    {"h2": "string", "h3_items": ["string"], "target_entities": ["string"]}
  ]
}
SYS;

        // Model options: kimi-k2.6 (or moonshot-v1-128k)
        $model = 'kimi-k2.6';

        $payload = [
            'model' => $model,
            'messages' => [
                ['role' => 'system', 'content' => $systemPrompt],
                ['role' => 'user', 'content' => "Here is the full competitor corpus to analyze:\n\n" . $massiveTextContent]
            ],
            'temperature' => 0.3,
            'max_tokens'  => 4000
        ];

        $headers = [
            'Authorization: Bearer ' . $this->kimiApiKey,
            'Content-Type: application/json; charset=utf-8'
        ];

        // 90s timeout for reading massive 10k-50k words corpus
        $rawResponse = $this->executeCurl($this->kimiEndpoint, 'POST', $payload, $headers, 90, 15);
        if (!$rawResponse) {
            throw new RuntimeException('[AiOrchestrator] Kimi API returned an empty response.');
        }

        $decoded = json_decode($rawResponse, true);

        // Check for Moonshot specific errors (e.g. Insufficient Balance)
        if (isset($decoded['error'])) {
            throw new RuntimeException(
                '[AiOrchestrator] Kimi API Error: ' . ($decoded['error']['message'] ?? json_encode($decoded['error']))
            );
        }

        $content = $decoded['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new RuntimeException('[AiOrchestrator] Kimi failed to return message content.');
        }

        $cleanJson = trim(preg_replace('/^```(?:json)?\s*|\s*```$/i', '', trim((string)$content)));

        try {
            return json_decode($cleanJson, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException('[AiOrchestrator] Failed to parse Kimi JSON response: ' . $e->getMessage() . "\nRaw: " . $cleanJson);
        }
    }


    // =========================================================================
    // Core Network Transport (Hardened cURL for Iranian Hosting)
    // =========================================================================

    /**
     * Executes robust HTTP cURL requests with domestic Iranian hosting resilience.
     *
     * @param string $url Target endpoint URL
     * @param string $method HTTP Method (POST / GET)
     * @param array|null $payload Data array to be JSON-encoded
     * @param array $headers List of HTTP header strings
     * @param int $timeout Max execution time in seconds
     * @param int $connectTimeout Max connection timeout in seconds
     * @return string|null Response body or null on failure
     */
    private function executeCurl(
        string $url,
        string $method = 'POST',
        ?array $payload = null,
        array $headers = [],
        int $timeout = 15,
        int $connectTimeout = 5
    ): ?string {
        $ch = curl_init($url);

        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => strtoupper($method),
            CURLOPT_TIMEOUT        => $timeout,
            CURLOPT_CONNECTTIMEOUT => $connectTimeout,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            // Iranian Hosting Network Directives:
            CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4,  // Avoid broken IPv6 routing to foreign APIs
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1, // Avoid broken HTTP/2 streams
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
        ];

        if ($payload !== null) {
            $curlOptions[CURLOPT_POSTFIELDS] = json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        if (!empty($headers)) {
            $curlOptions[CURLOPT_HTTPHEADER] = $headers;
        }

        curl_setopt_array($ch, $curlOptions);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log(sprintf('[AiOrchestrator cURL Error] %s -> %s', $url, $curlError));
            return null;
        }

        if ($httpCode >= 200 && $httpCode < 300) {
            return is_string($response) ? $response : null;
        }

        error_log(sprintf('[AiOrchestrator HTTP %d] %s -> %s', $httpCode, $url, substr((string)$response, 0, 300)));
        return null;
    }

    /**
     * Helper to call DeepSeek chat completions directly
     */
    private function callDeepseekChat(array $messages, float $temperature = 0.6, int $maxTokens = 800): ?string
    {
        $payload = [
            'model'       => 'deepseek-chat',
            'messages'    => $messages,
            'temperature' => $temperature,
            'max_tokens'  => $maxTokens
        ];

        $headers = [
            'Authorization: Bearer ' . $this->deepseekApiKey,
            'Content-Type: application/json; charset=utf-8'
        ];

        $res = $this->executeCurl($this->deepseekEndpoint, 'POST', $payload, $headers, 8, 3);
        if (!$res) {
            return null;
        }

        $decoded = json_decode($res, true);
        return $decoded['choices'][0]['message']['content'] ?? null;
    }
}
