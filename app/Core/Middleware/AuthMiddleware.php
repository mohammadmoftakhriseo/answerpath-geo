<?php
declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;

class AuthMiddleware
{
    public function handle(Request $request, Response $response): void
    {
        if (!Auth::check()) {
            $response->redirect('/admin/login');
        }
    }
}
