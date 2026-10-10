<?php
declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;

/**
 * Rate Limit Middleware
 * Restricts excessive traffic per IP address to protect server resources
 */
class RateLimitMiddleware
{
    private int $maxAttempts;
    private int $decaySeconds;

    public function __construct(int $maxAttempts = 30, int $decaySeconds = 60)
    {
        $this->maxAttempts = $maxAttempts;
        $this->decaySeconds = $decaySeconds;
    }

    public function handle(Request $request, Response $response): void
    {
        $ip = $request->ip();
        $uri = $request->getUri();
        $key = 'route_' . md5($uri) . ':' . $ip;

        if (RateLimiter::tooManyAttempts($key, $this->maxAttempts, $this->decaySeconds)) {
            $retryAfter = RateLimiter::availableIn($key, $this->decaySeconds);

            header('HTTP/1.1 429 Too Many Requests');
            header("Retry-After: {$retryAfter}");
            header("X-RateLimit-Limit: {$this->maxAttempts}");
            header("X-RateLimit-Remaining: 0");

            $response->setStatusCode(429);

            if ($request->isAjax()) {
                $response->json([
                    'status'      => 'error',
                    'error_code'  => 'rate_limit_exceeded',
                    'message'     => 'تعداد درخواست‌های ارسالی شما بیش از حد مجاز است. لطفاً ' . ceil($retryAfter / 60) . ' دقیقه دیگر تلاش نمایید.',
                    'retry_after' => $retryAfter
                ]);
                exit;
            }

            $response->send('
                <div style="font-family:system-ui,sans-serif; text-align:center; padding:60px 20px; direction:rtl; max-width:600px; margin:50px auto; background:#fff1f2; border:1px solid #fecdd3; border-radius:16px; color:#9f1239; box-shadow:0 10px 25px rgba(0,0,0,0.05);">
                    <div style="font-size:48px; margin-bottom:12px;">🛡️</div>
                    <h2 style="margin:0 0 12px; font-weight:800; font-size:22px;">محدودیت موقت ارسال درخواست (Rate Limit 429)</h2>
                    <p style="font-size:14px; line-height:1.7; color:#881337; margin-bottom:20px;">به دلیل ارسال تعداد درخواست‌های مکرر از سمت شما، دسترسی به این بخش به مدت <strong>' . ceil($retryAfter / 60) . ' دقیقه</strong> موقتاً محدود شده است.</p>
                    <a href="/" style="display:inline-block; padding:10px 24px; background:#e11d48; color:#fff; border-radius:10px; text-decoration:none; font-weight:700; font-size:13px;">بازگشت به صفحه اصلی</a>
                </div>
            ');
            exit;
        }

        RateLimiter::hit($key, $this->decaySeconds);

        $remaining = RateLimiter::retriesLeft($key, $this->maxAttempts, $this->decaySeconds);
        header("X-RateLimit-Limit: {$this->maxAttempts}");
        header("X-RateLimit-Remaining: {$remaining}");
    }
}
