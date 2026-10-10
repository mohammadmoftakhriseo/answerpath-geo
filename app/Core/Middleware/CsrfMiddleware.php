<?php
declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Request;
use App\Core\Response;

/**
 * Enterprise CSRF Protection Middleware
 * Guards state-changing POST requests against Cross-Site Request Forgery
 */
class CsrfMiddleware
{
    public function handle(Request $request, Response $response): void
    {
        if ($request->isPost()) {
            if (!$request->validateCsrf()) {
                $response->setStatusCode(403);

                if ($request->isAjax()) {
                    $response->json([
                        'status'     => 'error',
                        'error_code' => 'csrf_token_mismatch',
                        'message'    => 'اعتبارسنجی توکن امنیتی نشست با خطا مواجه شد. لطفاً صفحه را رفرش کنید.'
                    ]);
                    exit;
                }

                $response->send('
                    <div style="font-family:system-ui,sans-serif; text-align:center; padding:60px 20px; direction:rtl; max-width:550px; margin:50px auto; background:#fff1f2; border:1px solid #fecdd3; border-radius:16px; color:#9f1239; box-shadow:0 10px 25px rgba(0,0,0,0.05);">
                        <div style="font-size:48px; margin-bottom:12px;">🛡️</div>
                        <h2 style="margin:0 0 12px; font-weight:800; font-size:20px;">خطای امنیتی ۴۰۳: نشست نامعتبر (CSRF Mismatch)</h2>
                        <p style="font-size:14px; line-height:1.7; color:#881337; margin-bottom:20px;">توکن امنیتی فرم ارسال‌شده منقضی شده یا نامعتبر است. جهت حفظ امنیت اطلاعات، لطفاً صفحه را مجدداً بارگذاری نمایید.</p>
                        <a href="javascript:history.back()" style="display:inline-block; padding:10px 24px; background:#e11d48; color:#fff; border-radius:10px; text-decoration:none; font-weight:700; font-size:13px;">بازگشت و تلاش مجدد</a>
                    </div>
                ');
                exit;
            }
        }
    }
}
