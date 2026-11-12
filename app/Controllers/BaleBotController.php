<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\SiteSetting;
use App\Models\Article;
use App\Services\BaleNotifier;

class BaleBotController extends Controller
{
    public function handle(Request $request, Response $response): void
    {
        // هدایت مستقیم و اجرای کامل وب‌هوک تعاملی بازوی بله
        $webhookFile = ROOT_PATH . '/bale-webhook.php';
        if (file_exists($webhookFile)) {
            require $webhookFile;
            exit;
        }

        $response->json(['ok' => false, 'error' => 'bale-webhook.php not found']);
    }
}
