<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Core\Env;
use App\Core\Database;
use App\Models\Lead;
use App\Services\UserTracker;

class ChatController extends Controller
{
    /**
     * Strict Rate Limiting Rules (Cloudflare & Host Security)
     * - Cooldown: 1 message per 10 seconds
     * - 24-Hour cap: 20 messages per 24 hours per user
     */
    public const MESSAGE_COOLDOWN_SECONDS = 10;
    public const MAX_MESSAGES_24H = 20;

    /**
     * Direct browser access handler for GET /api/chat:
     * Gracefully redirect to homepage so users never encounter a 404 error page
     */
    public function showIndex(Request $request, Response $response): void
    {
        $response->redirect('/', 302);
    }

    /**
     * Handle incoming chat message from widget
     */
    public function chat(Request $request, Response $response): void
    {
        // 1. Ensure Session is Active for Conversation Memory
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Strict Rate Limiting: 1 message every 10 seconds
        $currentTime = time();
        $lastMessageTime = (int)($_SESSION['ai_chat_last_time'] ?? 0);
        $timeDiff = $currentTime - $lastMessageTime;
        if ($lastMessageTime > 0 && $timeDiff < self::MESSAGE_COOLDOWN_SECONDS) {
            $remaining = self::MESSAGE_COOLDOWN_SECONDS - $timeDiff;
            $response->json([
                'success' => false,
                'error'   => "لطفاً برای ارسال پیام بعدی {$remaining} ثانیه صبور باشید."
            ], 429);
            return;
        }

        // 3. Strict 24-Hour Rolling Window: Max 20 messages per 24 hours per user
        $windowStart = (int)($_SESSION['ai_chat_24h_start'] ?? 0);
        if ($windowStart === 0 || ($currentTime - $windowStart) > 86400) {
            $_SESSION['ai_chat_24h_start'] = $currentTime;
            $_SESSION['ai_chat_24h_count'] = 0;
        }
        $count24h = (int)($_SESSION['ai_chat_24h_count'] ?? 0);

        if ($count24h >= self::MAX_MESSAGES_24H) {
            // Do NOT call API, return cached error
            $limitMessage = "شما به سقف مجاز گفتگو رسیده‌اید، لطفاً <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم مشاوره</a> را پر کنید یا مستقیماً با شماره <a href=\"tel:09120638548\" class=\"text-blue-500 font-bold underline\">09120638548</a> تماس بگیرید.";
            $response->json([
                'success'        => false,
                'error'          => 'شما به سقف مجاز گفتگو رسیده‌اید، لطفاً فرم مشاوره را پر کنید.',
                'reply'          => $limitMessage,
                'limit_reached'  => true,
                'messages_left'  => 0,
                'max_messages'   => self::MAX_MESSAGES_24H
            ]);
            return;
        }

        // 4. Parse Incoming Message (Support JSON & Form-encoded)
        $rawInput = file_get_contents('php://input');
        $jsonData = json_decode($rawInput, true);
        $userMessage = '';

        if (is_array($jsonData) && isset($jsonData['message'])) {
            $userMessage = trim((string)$jsonData['message']);
        } else {
            $userMessage = trim((string)$request->input('message', ''));
        }

        if (empty($userMessage)) {
            $response->json([
                'success' => false,
                'error'   => 'لطفاً پیام خود را وارد کنید.'
            ], 400);
            return;
        }

        // Token Optimization: Limit character count to 400 chars per message
        if (mb_strlen($userMessage) > 400) {
            $userMessage = mb_substr($userMessage, 0, 400);
        }

        // Update rate limiting state
        $_SESSION['ai_chat_last_time'] = $currentTime;
        $count24h++;
        $_SESSION['ai_chat_24h_count'] = $count24h;
        $messagesLeft = self::MAX_MESSAGES_24H - $count24h;
        $isLimitReached = ($messagesLeft <= 0);

        // 5. Initialize or Retrieve Session History
        if (!isset($_SESSION['ai_chat_history']) || !is_array($_SESSION['ai_chat_history'])) {
            $_SESSION['ai_chat_history'] = [];
        }

        // Keep at most 10 recent messages (5 user + 5 bot) to keep tokens tight
        if (count($_SESSION['ai_chat_history']) > 10) {
            $_SESSION['ai_chat_history'] = array_slice($_SESSION['ai_chat_history'], -10);
        }

        // 6. Generate AI Response using Gemini API (with Grok & Intent fallbacks)
        $botReply = $this->generateAiReply($userMessage, $_SESSION['ai_chat_history'], $count24h);

        // If this is the final allowed message, append an elegant conclusion card
        if ($isLimitReached) {
            $botReply .= "\n\n<div class=\"mt-3 p-3 rounded-xl bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-800/80 border border-blue-200/80 dark:border-blue-900/50 text-[11px] text-slate-700 dark:text-slate-300 space-y-1.5 shadow-xs\">"
                . "<div class=\"font-bold text-blue-700 dark:text-blue-300 flex items-center gap-1.5\"><span>✨</span><span>سقف مشاوره آنلاین این جلسه تکمیل شد (۶ از ۶ پیام)</span></div>"
                . "<div>برای ادامه مکالمه و آنالیز اختصاصی کسب‌وکار خود، همین حالا فرم همکاری را ثبت کنید:</div>"
                . "<a href=\"/start\" class=\"inline-flex items-center justify-center gap-1 w-full mt-1.5 px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg text-xs transition-colors shadow-sm\">رزرو وقت در فرم شروع همکاری 🚀</a>"
                . "</div>";
        }

        // 7. Update Session Memory
        $_SESSION['ai_chat_history'][] = [
            'role' => 'user',
            'parts' => [['text' => $userMessage]]
        ];
        $_SESSION['ai_chat_history'][] = [
            'role' => 'model',
            'parts' => [['text' => $botReply]]
        ];

        if (count($_SESSION['ai_chat_history']) > 10) {
            $_SESSION['ai_chat_history'] = array_slice($_SESSION['ai_chat_history'], -10);
        }

        $responseData = [
            'success'       => true,
            'reply'         => $botReply,
            'limit_reached' => $isLimitReached,
            'messages_left' => $messagesLeft,
            'user_count'    => $count24h,
            'max_messages'  => self::MAX_MESSAGES_24H
        ];

        // Cloudflare Edge Cache Prevention: Dynamic AI chat must never be cached
        $response->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Pragma', 'no-cache');
        $response->header('X-Accel-Buffering', 'no');

        // High-Performance Instant Delivery: Close connection to user immediately, run notifications in background
        if (function_exists('fastcgi_finish_request')) {
            http_response_code(200);
            header('Content-Type: application/json; charset=utf-8');
            header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
            header('Pragma: no-cache');
            header('X-Accel-Buffering: no');
            echo json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            if (ob_get_level() > 0) {
                ob_end_flush();
            }
            flush();
            fastcgi_finish_request();
            if (session_status() === PHP_SESSION_ACTIVE) {
                session_write_close();
            }

            // Background async tasks: Lead recording, Telegram & Bale alerts (0 impact on user speed)
            try {
                $this->recordLeadAndNotify($request, $userMessage, $botReply, $count24h, $isLimitReached);
            } catch (\Throwable $e) {
                error_log('[ChatController] Lead & Notification error: ' . $e->getMessage());
            }
            exit;
        }

        // Standard execution fallback
        try {
            $this->recordLeadAndNotify($request, $userMessage, $botReply, $count24h, $isLimitReached);
        } catch (\Throwable $e) {
            error_log('[ChatController] Lead & Notification error: ' . $e->getMessage());
        }

        $response->json($responseData);
    }

    /**
     * Reset Chat Memory and Message Counter
     */
    public function reset(Request $request, Response $response): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['ai_chat_history'] = [];
        $_SESSION['ai_chat_user_count'] = 0;
        unset($_SESSION['ai_chat_lead_id'], $_SESSION['ai_chat_phone_saved'], $_SESSION['ai_chat_last_time']);

        $response->json([
            'success' => true,
            'message' => 'تاریخچه گفتگو بازنشانی شد.'
        ]);
    }

    /**
     * Record Lead to MySQL Admin Panel and Send Telegram Alert
     */
    private function recordLeadAndNotify(Request $request, string $userMessage, string $botReply, int $messageNumber, bool $isLimitReached): void
    {
        $leadId = (int)($_SESSION['ai_chat_lead_id'] ?? 0);
        $tracking = UserTracker::getTrackingData();
        $utm = $tracking['utm'] ?? [];
        $ip = $request->ip();
        $detectedPhone = $this->extractPhone($userMessage);
        $detectedUrl = $this->extractUrl($userMessage);

        if ($leadId === 0 || $messageNumber === 1) {
            $phoneValue = $detectedPhone ?: 'چت آنلاین (بدون شماره)';
            $initialTranscript = "💬 پیام ۱ کاربر:\n" . $userMessage . "\n\n🤖 پاسخ هوش مصنوعی:\n" . strip_tags($botReply);

            Lead::create([
                'full_name'         => $detectedPhone ? 'کاربر چت آنلاین (' . $detectedPhone . ')' : 'کاربر چت آنلاین (IP: ' . $ip . ')',
                'phone'             => $phoneValue,
                'website_url'       => $detectedUrl,
                'service_requested' => 'گفتگو با دستیار هوشمند AI',
                'message'           => $initialTranscript,
                'source_cta'        => 'ai_sales_chat',
                'current_page'      => $tracking['current_page'] ?? '/',
                'user_journey'      => $tracking['journey_formatted'] ?? '/',
                'referrer'          => $utm['referrer'] ?? null,
                'utm_source'        => $utm['utm_source'] ?? null,
                'utm_medium'        => $utm['utm_medium'] ?? null,
                'utm_campaign'      => $utm['utm_campaign'] ?? null,
                'utm_term'          => $utm['utm_term'] ?? null,
                'utm_content'       => $utm['utm_content'] ?? null,
                'ip_address'        => $ip,
                'user_agent'        => mb_substr((string)$request->header('USER-AGENT', ''), 0, 500)
            ]);

            $newLeadId = (int)Database::lastInsertId();
            if ($newLeadId > 0) {
                $_SESSION['ai_chat_lead_id'] = $newLeadId;
            }

            // ارسال نوتیفیکیشن زنده به تلگرام و بله
            $actionTitle = !empty($detectedPhone) 
                ? '🔥 گفتگوی جدید چت‌بات + شماره تماس داغ' 
                : '💬 گفتگوی جدید کاربر با دستیار هوشمند AI';

            sendLeadNotification($actionTitle, [
                'full_name'         => $detectedPhone ? 'کاربر چت آنلاین (' . $detectedPhone . ')' : 'کاربر چت آنلاین',
                'phone'             => $detectedPhone ?: 'هنوز ثبت نشده (در حال چت)',
                'website_url'       => $detectedUrl,
                'message'           => "💬 پیام ۱ کاربر:\n" . $userMessage,
                'service_requested' => 'دستیار فروش هوشمند (پیام ۱ از ۶)',
                'source_cta'        => 'ai_sales_chat',
                'current_page'      => $tracking['current_page'] ?? '/',
                'user_journey'      => $tracking['journey_formatted'] ?? '/',
                'user_journey_raw'  => $tracking['journey'] ?? [],
                'utm_data'          => $utm,
                'ip_address'        => $ip,
            ]);

        } else {
            // در پیام‌های بعدی (۲ تا ۶): ترانسکریپت در پنل ادمین (دیتابیس) ذخیره و به روز می‌شود
            $cleanBotText = strip_tags($botReply);
            $chatChunk = "\n\n---\n💬 پیام {$messageNumber} کاربر:\n" . $userMessage . "\n\n🤖 پاسخ هوش مصنوعی:\n" . $cleanBotText;

            if ($leadId > 0) {
                Database::execute(
                    "UPDATE leads SET message = CONCAT(IFNULL(message, ''), ?) WHERE id = ?",
                    [$chatChunk, $leadId]
                );

                // اگر کاربر در پیام‌های بعدی شماره همراه ارسال کرد:
                if (!empty($detectedPhone) && empty($_SESSION['ai_chat_phone_saved'])) {
                    $_SESSION['ai_chat_phone_saved'] = $detectedPhone;
                    Database::execute(
                        "UPDATE leads SET phone = ?, full_name = CONCAT('کاربر چت آنلاین (', ?, ')') WHERE id = ?",
                        [$detectedPhone, $detectedPhone, $leadId]
                    );

                    // آلارم ویژه تلگرام برای دریافت شماره تماس
                    sendLeadNotification('🔥 شماره تماس جدید در چت‌بات دریافت شد!', [
                        'full_name'         => 'کاربر چت آنلاین (' . $detectedPhone . ')',
                        'phone'             => $detectedPhone,
                        'message'           => "پیام حاوی شماره:\n" . $userMessage,
                        'service_requested' => 'لید داغ چت‌بات (پیام ' . $messageNumber . ')',
                        'source_cta'        => 'ai_sales_chat',
                        'current_page'      => $tracking['current_page'] ?? '/',
                        'user_journey'      => $tracking['journey_formatted'] ?? '/',
                        'ip_address'        => $ip,
                    ]);
                }
            }
        }
    }

    /**
     * Extract Iranian mobile phone number from text (Supports Persian & English digits)
     */
    private function extractPhone(string $text): ?string
    {
        $persianDigits = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
        $arabicDigits  = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
        $englishDigits = ['0','1','2','3','4','5','6','7','8','9'];
        $normalized = str_replace($persianDigits, $englishDigits, $text);
        $normalized = str_replace($arabicDigits, $englishDigits, $normalized);

        if (preg_match('/(09\d{9}|(?:\+98|0098)9\d{9})/', $normalized, $matches)) {
            $p = $matches[1];
            if (str_starts_with($p, '+98')) {
                $p = '0' . substr($p, 3);
            } elseif (str_starts_with($p, '0098')) {
                $p = '0' . substr($p, 4);
            }
            return $p;
        }
        return null;
    }

    /**
     * Extract website URL from text if mentioned by user
     */
    private function extractUrl(string $text): ?string
    {
        if (preg_match('/(?:https?:\/\/)?(?:www\.)?([a-zA-Z0-9-]+\.[a-zA-Z]{2,}(?:\/[^\s]*)?)/u', $text, $matches)) {
            $url = $matches[0];
            if (!str_starts_with($url, 'http')) {
                $url = 'https://' . $url;
            }
            return $url;
        }
        return null;
    }

    /**
     * Core AI Engine: Calls Gemini API with fallback mechanisms
     */
    private function generateAiReply(string $userMessage, array $history, int $messageNumber = 1): string
    {
        $aiConfig = file_exists(ROOT_PATH . '/config/ai.php') ? (require ROOT_PATH . '/config/ai.php') : [];
        $geminiApiKey = $aiConfig['gemini_api_key'] ?? Env::get('GEMINI_API_KEY');

        // Master Sales Assistant System Instruction (Optimized for Multi-turn & Conversion)
        $systemInstruction = "شما مشاور و دستیار فروش هوشمند و اختصاصی در وب‌سایت مهندس محمد مفتخری (Mohammad Moftakhari - استراتژیست ارشد سئو، بهینه‌سازی نرخ تبدیل و برنامه‌نویس وب با معماری اختصاصی PHP MVC) هستید.\n\n"
            . "🎯 هدف اصلی:\n"
            . "پاسخ‌گویی بسیار کوتاه (حداکثر ۱ تا ۲ پاراگراف فشرده)، دقیق، بدون حاشیه و هدایت هوشمندانه مخاطب به خدمات سایت یا فرم مشاوره.\n\n"
            . "⚠️ قوانین حیاتی و خط قرمز (CRITICAL RULES):\n"
            . "۱. قانون تداوم مکالمه و عدم تکرار سلام:\n"
            . "   - فقط در پیام اول مکالمه مجاز به سلام و درود هستید.\n"
            . "   - از پیام دوم به بعد (ادامه مکالمه)، به هیچ وجه دوباره سلام، احوال‌پرسی یا تعارفات اولیه را تکرار نکنید! مستقیماً و بلافاصله به بررسی چالش کاربر بپردازید.\n"
            . "۲. پایگاه دانش خدمات محمد مفتخری:\n"
            . "   - سئوی تکنیکال، معماری تمیز و سرعت موشکی (Core Web Vitals) بدون افزونه‌های سنگین وردپرس\n"
            . "   - برنامه‌نویسی اختصاصی PHP MVC و رد کامل صفحه‌سازهای سنگین مثل المنتور\n"
            . "   - بهینه‌سازی نرخ تبدیل (CRO) و بازطراحی مسیر تبدیل مخاطب به تماس تلفنی و لید فروش\n"
            . "   - سئوی محلی (Local SEO) و رتبه‌های ۱ تا ۳ گوگل مپ، نشان و بلد\n"
            . "   - اتوماسیون محتوا و سیستم‌سازی هوش مصنوعی با Gemini API و اتصال پروتکل MCP\n\n"
            . "🧭 قوانین هدایت هدفمند (Intent Routing):\n"
            . "- اگر کاربر گفت «روی سایت کار می‌کنیم ولی تلفن زنگ نمی‌خوره / لید نداریم / فروش کمه / ورودی داریم ولی نتیجه نمی‌گیریم»:\n"
            . "  ریشه مشکل دقیقاً اصطکاک لندینگ‌پیج و ضعف در نرخ تبدیل (CRO) است؛ زیرا سئو ترافیک می‌آورد اما ساختار CRO ترافیک را به زنگخور تبدیل می‌کند. دقیقاً این لینک را بده: <a href=\"/services/landing-page-design-cro\" class=\"text-blue-500 font-bold underline\">خدمات بهینه‌سازی نرخ تبدیل (CRO)</a> یا <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم شروع همکاری</a>.\n"
            . "- اگر کاربر درباره برنامه، استراتژی سئو، یا از کجا شروع کنم پرسید -> بده: <a href=\"/seo-roadmap\" class=\"text-blue-500 font-bold underline\">ابزار رایگان تدوین نقشه راه سئو</a>\n"
            . "- اگر به سرعت سایت، کندی، یا خطاهای تکنیکال سرور اشاره کرد -> بده: <a href=\"/services/technical-seo\" class=\"text-blue-500 font-bold underline\">خدمات سئوی تکنیکال</a>\n"
            . "- اگر به گوگل مپ، کسب‌وکار محلی، نشان یا بلد اشاره کرد -> بده: <a href=\"/services/local-seo\" class=\"text-blue-500 font-bold underline\">خدمات سئوی محلی</a>\n"
            . "- برای سایر درخواست‌های خدمات، استعلام قیمت یا بررسی اختصاصی سایت -> کاربر را دعوت کن به: <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم شروع همکاری</a> یا تماس تلفنی با شماره 09120638548.";

        // Attempt 1: Call Google Gemini API (Via Cloudflare AI Gateway or Direct)
        if (!empty($geminiApiKey) && !str_starts_with($geminiApiKey, 'YOUR_')) {
            $reply = $this->callGeminiApi($userMessage, $history, $systemInstruction, $geminiApiKey);
            if (!empty($reply)) {
                return $reply;
            }
        }

        // Attempt 2: Fallback to Kimi AI (Moonshot) Engine
        $kimiKey = $aiConfig['kimi_api_key'] ?? Env::get('KIMI_API_KEY');
        if (!empty($kimiKey) && !str_starts_with($kimiKey, 'YOUR_')) {
            $reply = $this->callKimiApi($userMessage, $history, $systemInstruction, $kimiKey, $aiConfig);
            if (!empty($reply)) {
                return $reply;
            }
        }

        // Attempt 3: Fallback to xAI Grok if Gemini and Kimi are unavailable
        $xaiKey = $aiConfig['xai_api_key'] ?? Env::get('XAI_API_KEY');
        if (!empty($xaiKey) && !str_starts_with($xaiKey, 'YOUR_')) {
            $reply = $this->callXaiGrokApi($userMessage, $history, $systemInstruction, $xaiKey);
            if (!empty($reply)) {
                return $reply;
            }
        }

        // Attempt 4: High-Reliability Local Intent Matching Fallback
        return $this->fallbackIntentMatch($userMessage, $messageNumber);
    }

    /**
     * cURL call to Google Gemini API (With Cloudflare AI Gateway & Direct Resilience)
     */
    private function callGeminiApi(string $userMessage, array $history, string $systemInstruction, string $apiKey): ?string
    {
        // Verified active models in Google AI Studio
        $models = ['gemini-3.5-flash', 'gemini-3.5-flash-lite', 'gemini-flash-latest'];

        // Build Gemini conversation payload
        $contents = [];
        foreach ($history as $h) {
            $contents[] = [
                'role' => ($h['role'] === 'user' ? 'user' : 'model'),
                'parts' => [
                    ['text' => (string)($h['parts'][0]['text'] ?? '')]
                ]
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
                'maxOutputTokens' => 1000,
                'topP'            => 0.95
            ]
        ];

        $aiConfig = file_exists(ROOT_PATH . '/config/ai.php') ? (require ROOT_PATH . '/config/ai.php') : [];
        $cfAccountId = trim((string)($aiConfig['cf_ai_gateway_account_id'] ?? Env::get('CF_AI_GATEWAY_ACCOUNT_ID', '')));
        $cfSlug      = trim((string)($aiConfig['cf_ai_gateway_slug'] ?? Env::get('CF_AI_GATEWAY_SLUG', 'gemini-gateway')));
        $cfToken     = trim((string)($aiConfig['cf_ai_gateway_token'] ?? Env::get('CF_AI_GATEWAY_TOKEN', '')));
        $isCfEnabled = !empty($aiConfig['cf_ai_gateway_enabled']) && !empty($cfAccountId) && $cfAccountId !== 'a1b2c3d4e5f6g7h8i9j0';

        $encodedPayload = json_encode($payload, JSON_UNESCAPED_UNICODE);
        $encodedKey = urlencode($apiKey);

        foreach ($models as $model) {
            // Build candidate endpoints list: Try Cloudflare Gateway first if configured, then Direct Google
            $endpointsToTry = [];
            if ($isCfEnabled) {
                $cfHeaders = [
                    'Content-Type: application/json; charset=utf-8',
                    'Accept: application/json',
                    'x-goog-api-key: ' . $apiKey,
                    'cf-cache-ttl: 86400', // Cloudflare AI Gateway edge response caching (24h)
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ];
                if (!empty($cfToken)) {
                    $cfHeaders[] = 'Authorization: Bearer ' . $cfToken;
                    $cfHeaders[] = 'cf-aig-authorization: Bearer ' . $cfToken;
                }

                $endpointsToTry[] = [
                    'type'    => 'cloudflare',
                    'url'     => "https://gateway.ai.cloudflare.com/v1/{$cfAccountId}/{$cfSlug}/google-ai-studio/v1beta/models/{$model}:generateContent?key={$encodedKey}",
                    'headers' => $cfHeaders
                ];
            }

            // Always have direct Google AI Studio endpoint ready (as primary or automatic fallback)
            $endpointsToTry[] = [
                'type'    => 'direct',
                'url'     => "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$encodedKey}",
                'headers' => [
                    'Content-Type: application/json; charset=utf-8',
                    'Accept: application/json',
                    'x-goog-api-key: ' . $apiKey,
                    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36'
                ]
            ];

            foreach ($endpointsToTry as $target) {
                $ch = curl_init($target['url']);
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST           => true,
                    CURLOPT_POSTFIELDS     => $encodedPayload,
                    CURLOPT_HTTPHEADER     => $target['headers'],
                    CURLOPT_TIMEOUT        => 4,
                    CURLOPT_CONNECTTIMEOUT => 2,
                    CURLOPT_SSL_VERIFYPEER => false,
                ]);

                $responseBody = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($httpCode === 200 && $responseBody) {
                    $decoded = json_decode((string)$responseBody, true);
                    $parts = $decoded['candidates'][0]['content']['parts'] ?? [];
                    foreach ($parts as $p) {
                        if (!empty($p['text'])) {
                            return trim((string)$p['text']);
                        }
                    }
                } elseif ($target['type'] === 'cloudflare') {
                    // If Cloudflare AI Gateway was unreachable or unauthorized, disable for next model
                    $isCfEnabled = false;
                }
            }
        }

        return null;
    }

    /**
     * Fallback: Call xAI Grok API
     */
    private function callXaiGrokApi(string $userMessage, array $history, string $systemInstruction, string $apiKey): ?string
    {
        $messages = [
            ['role' => 'system', 'content' => $systemInstruction]
        ];

        foreach ($history as $h) {
            $role = ($h['role'] === 'user') ? 'user' : 'assistant';
            $messages[] = [
                'role'    => $role,
                'content' => (string)($h['parts'][0]['text'] ?? '')
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $payload = [
            'model'       => 'grok-beta',
            'messages'    => $messages,
            'temperature' => 0.6,
            'max_tokens'  => 800
        ];

        $ch = curl_init('https://api.x.ai/v1/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Bearer ' . $apiKey
            ],
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $responseBody) {
            $decoded = json_decode((string)$responseBody, true);
            if (isset($decoded['choices'][0]['message']['content'])) {
                return trim((string)$decoded['choices'][0]['message']['content']);
            }
        }

        return null;
    }

    /**
     * Fallback: Call Kimi AI (Moonshot) API
     */
    private function callKimiApi(string $userMessage, array $history, string $systemInstruction, string $apiKey, array $aiConfig = []): ?string
    {
        $endpoint = $aiConfig['kimi_endpoint'] ?? 'https://api.moonshot.ai/v1/chat/completions';
        $model = $aiConfig['kimi_model'] ?? 'kimi-k2.6';

        $messages = [
            ['role' => 'system', 'content' => $systemInstruction]
        ];

        foreach ($history as $h) {
            $role = ($h['role'] === 'user') ? 'user' : 'assistant';
            $messages[] = [
                'role'    => $role,
                'content' => (string)($h['parts'][0]['text'] ?? '')
            ];
        }
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        $payload = [
            'model'       => $model,
            'messages'    => $messages,
            'temperature' => 0.6,
            'max_tokens'  => 800
        ];

        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json; charset=utf-8',
                'Authorization: Bearer ' . $apiKey,
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ],
            CURLOPT_TIMEOUT        => 4,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);

        $responseBody = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $responseBody) {
            $decoded = json_decode((string)$responseBody, true);
            if (isset($decoded['choices'][0]['message']['content'])) {
                return trim((string)$decoded['choices'][0]['message']['content']);
            }
        }

        return null;
    }

    /**
     * Local Deterministic Intent Matcher (Instant Zero-Downtime Guarantee)
     */
    private function fallbackIntentMatch(string $msg, int $messageNumber = 1): string
    {
        $msgLower = mb_strtolower($msg);

        // CRO / Phone Calls / Leads / Low Sales
        if (preg_match('/(فروش|نرخ تبدیل|cro|لید|مشتری|درآمد|سفارش|تلفن|زنگ|تماس|ورودی|کار می|نتیجه)/u', $msgLower)) {
            return "اگر روی وب‌سایت کار می‌کنید اما تماس و زنگخور ندارید، مشکل دقیقاً در اصطکاک لندینگ‌پیج‌ها و نرخ تبدیل (CRO) است؛ زیرا سئو ترافیک می‌آورد اما ساختار اصولی لندینگ است که آن را به مشتری تبدیل می‌کند. برای بررسی این موضوع به <a href=\"/services/landing-page-design-cro\" class=\"text-blue-500 font-bold underline\">خدمات بهینه‌سازی نرخ تبدیل (CRO)</a> مراجعه فرمایید یا در <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم شروع همکاری</a> پیام بگذارید تا سایتتان آنالیز شود.";
        }

        // SEO Strategy & Roadmap
        if (preg_match('/(نقشه راه|برنامه|استراتژی|پلن|شروع|چیکار کنم|از کجا)/u', $msgLower)) {
            return "برای طراحی مسیر دقیق رشد سایتتان، پیشنهاد می‌کنم ابتدا از <a href=\"/seo-roadmap\" class=\"text-blue-500 font-bold underline\">ابزار رایگان تدوین نقشه راه سئو</a> استفاده کنید تا چالش‌ها و مراحل ارتقای وب‌سایت شما مرحله‌به‌مرحله مشخص شود.";
        }

        // Technical SEO & Speed
        if (preg_match('/(سرعت|کند|تکنیکال|کور وب|cwv|lcp|cls|هاست|کد)/u', $msgLower)) {
            return "سرعت لودینگ و سلامت زیرساخت فونداسیون اصلی سئو هستند. محمد مفتخری بدون نیاز به افزونه‌های سنگین سرعت سایت شما را بهبود می‌دهد. جزئیات بیشتر در: <a href=\"/services/technical-seo\" class=\"text-blue-500 font-bold underline\">خدمات سئوی تکنیکال</a>.";
        }

        // Local SEO & Maps
        if (preg_match('/(مپ|نقشه|لوکال|محلی|نشان|بلد|گوگل مپ|google map)/u', $msgLower)) {
            return "برای جذب مشتریان حضوری و تسخیر نتایج برتر گوگل مپ و اپلیکیشن‌های بومی، به صفحه <a href=\"/services/local-seo\" class=\"text-blue-500 font-bold underline\">خدمات سئوی محلی</a> مراجعه کنید تا راهکار اختصاصی کسب‌وکار شما را بررسی کنیم.";
        }

        // AI Automation & Content
        if (preg_match('/(هوش مصنوعی|ai|اتوماسیون|تولید محتوا|gemini|grok|جمینای)/u', $msgLower)) {
            return "ما سیستم‌های خودکار تولید محتوا و اتوماسیون مبتنی بر مدل‌های زبانی را به صورت اختصاصی پیاده‌سازی می‌کنیم. برای آشنایی با فرایند کار به <a href=\"/services/ai-automation\" class=\"text-blue-500 font-bold underline\">خدمات اتوماسیون هوش مصنوعی</a> سر بزنید.";
        }

        // Continuing Conversation Fallback (Never repeat greeting on message 2+)
        if ($messageNumber > 1) {
            return "متوجه چالش شما هستم. برای اینکه وب‌سایت شما را دقیقاً بررسی کنیم و ریشه عدم دریافت نتیجه دلخواه را مشخص کنیم، پیشنهاد می‌کنم اطلاعات سایتتان را در <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم شروع همکاری</a> ثبت کنید تا شخصاً بررسی شود، یا مستقیماً با شماره <a href=\"tel:09120638548\" class=\"text-blue-500 font-bold underline\">09120638548</a> تماس بگیرید.";
        }

        // First message default greeting
        return "سلام و درود! خوشحالم که در سایت محمد مفتخری همراه ما هستید. برای دریافت مشاوره متناسب با حوزه فعالیت خود، می‌توانید با پر کردن <a href=\"/start\" class=\"text-blue-500 font-bold underline\">فرم شروع همکاری</a> درخواست خود را ثبت کنید یا مستقیماً سؤالتان را همین‌جا مطرح نمایید تا راهنمایی‌تان کنم.";
    }
}
