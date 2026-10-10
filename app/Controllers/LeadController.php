<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Models\Lead;

/**
 * Enterprise Secure Lead & Contact Controller
 * Protected by Sliding-Window Rate Limiting, Anti-Spam Honeypots, and Input Sanitization
 */
class LeadController extends Controller
{
    private const MAX_LEAD_ATTEMPTS = 10;
    private const RATE_LIMIT_WINDOW = 3600; // 1 hour

    public function submit(Request $request, Response $response): void
    {
        $isAjax = $request->isAjax() || $request->header('X-REQUESTED-WITH') === 'XMLHttpRequest' || str_contains((string)$request->header('ACCEPT'), 'application/json');
        $ip = $request->ip();
        $rateLimitKey = 'lead_submit:' . $ip;

        // ۱. بررسی محدودیت نرخ ارسال درخواست (Rate Limiting)
        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_LEAD_ATTEMPTS, self::RATE_LIMIT_WINDOW)) {
            $secondsRemaining = RateLimiter::availableIn($rateLimitKey, self::RATE_LIMIT_WINDOW);
            $minutes = ceil($secondsRemaining / 60);

            if ($isAjax) {
                $response->setStatusCode(429);
                $response->json([
                    'status'      => 'error',
                    'error_code'  => 'rate_limit_exceeded',
                    'message'     => "تعداد فرم‌های ارسالی شما بیش از حد مجاز است. لطفاً {$minutes} دقیقه دیگر تلاش فرمایید."
                ]);
                return;
            }

            $response->redirect('/?error=rate_limited#contact');
            return;
        }

        // ۲. تله ضد اسپم ربات‌ها (Anti-spam Honeypot Check)
        if (!empty($request->input('honeypot_check'))) {
            // ربات‌های اسپمر فیلد هانی‌پات را پر می‌کنند؛ با پاسخ موفق صوری فریب داده می‌شوند
            if ($isAjax) {
                $response->json(['status' => 'success', 'message' => 'درخواست شما با موفقیت ثبت شد.']);
                return;
            }
            $response->redirect('/?status=success#contact');
            return;
        }

        // ۳. پاکسازی و ایمن‌سازی عمیق تمام ورودی‌ها (XSS & Injection Protection)
        $fullName = $request->clean('full_name');
        if (empty($fullName)) {
            $fullName = $request->clean('name');
        }
        if (empty($fullName)) {
            $firstName = $request->clean('first_name');
            $lastName = $request->clean('last_name');
            $fullName = trim($firstName . ' ' . $lastName);
        }

        $phone = $request->clean('phone');
        $websiteUrl = $request->clean('website_url') ?: $request->clean('website');
        
        $serviceRequested = $request->clean('service_requested');
        if (empty($serviceRequested)) {
            $serviceType = $request->clean('service_type');
            $serviceMap = [
                'technical_seo' => 'سئوی تکنیکال و سرعت',
                'seo_strategy'  => 'استراتژی و مشاوره کلان',
                'ai_automation' => 'اتوماسیون محتوا و MCP',
                'landing_cro'   => 'طراحی لندینگ و CRO',
                'local_seo'     => 'سئوی محلی و نقشه‌ها',
                'custom_dev'    => 'طراحی اختصاصی سایت'
            ];
            $serviceRequested = $serviceMap[$serviceType] ?? ($serviceType ?: 'مشاوره و بریف سئو');
        }

        $message = clean_xss((string)$request->input('message', ''));
        $sourceCta = $request->clean('source_cta') ?: $request->clean('source', 'smart_brief');

        // ۴. اعتبارسنجی فیلدهای ضروری
        if (empty($phone)) {
            if ($isAjax) {
                $response->setStatusCode(422);
                $response->json(['status' => 'error', 'message' => 'لطفاً شماره تماس معتبر خود را وارد نمایید.']);
                return;
            }
            $response->redirect('/?error=empty_fields#contact');
            return;
        }

        $assessmentScore = $request->clean('assessment_score');
        $assessmentSummary = clean_xss((string)$request->input('assessment_summary', ''));
        
        if (!empty($assessmentScore)) {
            $serviceRequested = "ارزیابی سلامت سئو (نمره: {$assessmentScore}/100)";
            if (!empty($assessmentSummary)) {
                $message = "نمره ارزیابی سئو: {$assessmentScore} از ۱۰۰\n\nجزئیات تحلیل:\n" . $assessmentSummary . (!empty($message) ? "\n\nپیام تکمیلی: " . $message : '');
            }
        }

        // ثبت تلاش در Rate Limiter
        RateLimiter::hit($rateLimitKey, self::RATE_LIMIT_WINDOW);

        $tracking = \App\Services\UserTracker::getTrackingData();
        $utm = $tracking['utm'] ?? [];

        // ۵. ثبت امن در دیتابیس با Prepared Statements
        Lead::create([
            'full_name'         => !empty($fullName) ? $fullName : 'کاربر متقاضی بریف',
            'phone'             => $phone,
            'website_url'       => !empty($websiteUrl) ? $websiteUrl : null,
            'service_requested' => $serviceRequested,
            'message'           => !empty($message) ? $message : null,
            'source_cta'        => $sourceCta,
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

        // ۶. ارسال نوتیفیکیشن لحظه‌ای به تلگرام و بله به همراه تحلیل هوشمند در صورت وجود وب‌سایت
        try {
            $aiReport = null;
            if (!empty($websiteUrl)) {
                $aiReport = \App\Services\TelegramNotifier::generateQuickRoadmap($websiteUrl, $message ?: $serviceRequested);
            }

            sendLeadToTelegram($serviceRequested ?: 'درخواست مشاوره و لید سئو', [
                'full_name'         => !empty($fullName) ? $fullName : 'کاربر سایت',
                'phone'             => $phone,
                'website_url'       => $websiteUrl,
                'message'           => $message,
                'service_requested' => $serviceRequested,
                'source_cta'        => $sourceCta,
                'current_page'      => $tracking['current_page'] ?? '/',
                'user_journey'      => $tracking['journey_formatted'] ?? '/',
                'user_journey_raw'  => $tracking['journey'] ?? [],
                'utm_source_data'   => $tracking['utm_formatted'] ?? '',
                'utm_data'          => $utm,
                'ip_address'        => $ip,
            ], $aiReport);
        } catch (\Throwable $e) {
            error_log('[LeadController] Notification Error: ' . $e->getMessage());
        }

        // ۷. ثبت ابری مستقیم در گیت‌هاب (GitHub Cloud Auto-Sync)
        try {
            $gitService = new \App\Services\GitHubSyncService();
            if ($gitService->isConfigured()) {
                $gitService->logLead([
                    'full_name'         => !empty($fullName) ? $fullName : 'کاربر سایت',
                    'phone'             => $phone,
                    'website_url'       => $websiteUrl,
                    'service_requested' => $serviceRequested,
                    'message'           => $message,
                    'source_cta'        => $sourceCta,
                    'current_page'      => $tracking['current_page'] ?? '/',
                    'user_journey'      => $tracking['journey_formatted'] ?? '/',
                    'ip_address'        => $ip,
                ], 'lead_controller');
            }
        } catch (\Throwable $ge) {
            error_log('[LeadController] GitHub Lead Sync Error: ' . $ge->getMessage());
        }

        if ($isAjax) {
            $response->json([
                'status'  => 'success', 
                'message' => 'اطلاعات بریف با موفقیت ثبت شد. به‌زودی با شما تماس خواهم گرفت.'
            ]);
            return;
        }

        $response->redirect('/?status=lead_received#contact');
    }
}
