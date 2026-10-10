<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\RateLimiter;
use App\Core\Request;
use App\Core\Response;
use App\Core\Session;

/**
 * Enterprise Secure Admin Authentication Controller
 * Protected by Sliding-Window Rate Limiting, CSRF Verification & Brute-Force Lockout
 */
class AuthController extends Controller
{
    private const MAX_LOGIN_ATTEMPTS = 5;
    private const LOCKOUT_DURATION = 900; // 15 minutes

    public function showLogin(Request $request, Response $response): void
    {
        if (Auth::check()) {
            $response->redirect('/admin');
            return;
        }

        $this->render('admin/auth/login', [
            'title' => 'ورود به پنل مدیریت | محمد مفتخری',
            'csrf_token' => Session::csrfToken()
        ]);
    }

    public function login(Request $request, Response $response): void
    {
        $ip = $request->ip();
        $rateLimitKey = 'login_attempt:' . $ip;

        // ۱. بررسی محدودیت نرخ ارسال درخواست (Rate Limiting & Brute-Force Protection)
        if (RateLimiter::tooManyAttempts($rateLimitKey, self::MAX_LOGIN_ATTEMPTS, self::LOCKOUT_DURATION)) {
            $secondsRemaining = RateLimiter::availableIn($rateLimitKey, self::LOCKOUT_DURATION);
            $minutes = ceil($secondsRemaining / 60);

            $this->render('admin/auth/login', [
                'title' => 'ورود به پنل مدیریت',
                'error' => "به دلیل تلاش‌های ناموفق متعدد، حساب شما موقتاً مسدود شده است. لطفاً {$minutes} دقیقه دیگر تلاش فرمایید.",
                'csrf_token' => Session::csrfToken()
            ]);
            return;
        }

        // ۲. اعتبارسنجی توکن ضد جعل CSRF
        $token = $request->input('_csrf_token');
        if (!Session::validateCsrfToken((string)$token)) {
            $this->render('admin/auth/login', [
                'title' => 'ورود به پنل مدیریت',
                'error' => 'توکن امنیتی نشست شما منقضی شده است. لطفاً صفحه را مجدداً بارگذاری کنید.',
                'csrf_token' => Session::csrfToken()
            ]);
            return;
        }

        $username = trim((string)$request->input('username', ''));
        $password = (string)$request->input('password', '');

        if (empty($username) || empty($password)) {
            $this->render('admin/auth/login', [
                'title' => 'ورود به پنل مدیریت',
                'error' => 'لطفاً نام کاربری و رمز عبور را وارد نمایید.',
                'csrf_token' => Session::csrfToken()
            ]);
            return;
        }

        // ۳. بررسی اطلاعات کاربری
        if (Auth::attempt($username, $password)) {
            // پاکسازی شمارنده تلاش‌های ناموفق پس از ورود صحیح
            RateLimiter::clear($rateLimitKey);
            $response->redirect('/admin');
            return;
        }

        // ۴. ثبت تلاش ناموفق در سیستم Rate Limiter
        RateLimiter::hit($rateLimitKey, self::LOCKOUT_DURATION);
        $attemptsLeft = RateLimiter::retriesLeft($rateLimitKey, self::MAX_LOGIN_ATTEMPTS, self::LOCKOUT_DURATION);

        $errorMsg = 'نام کاربری یا کلمه عبور اشتباه است.';
        if ($attemptsLeft > 0 && $attemptsLeft <= 3) {
            $errorMsg .= " (تعداد تلاش باقی‌مانده: {$attemptsLeft})";
        } elseif ($attemptsLeft === 0) {
            $errorMsg = 'تعداد تلاش‌های مجاز شما به پایان رسید. دسترسی موقتاً به مدت ۱۵ دقیقه مسدود شد.';
        }

        $this->render('admin/auth/login', [
            'title' => 'ورود به پنل مدیریت',
            'error' => $errorMsg,
            'csrf_token' => Session::csrfToken()
        ]);
    }

    public function logout(Request $request, Response $response): void
    {
        Auth::logout();
        $response->redirect('/admin/login');
    }
}
