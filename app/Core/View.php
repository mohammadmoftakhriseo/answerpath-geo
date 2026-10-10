<?php
declare(strict_types=1);

namespace App\Core;

/**
 * View Renderer with Layout Support
 */
class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = VIEWS_PATH . '/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View file not found: {$viewFile}");
        }

        // Render the inner view
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Check if front layout should be used (including front error pages)
        if (str_starts_with($view, 'front/') || str_starts_with($view, 'errors/')) {
            $layoutFile = VIEWS_PATH . '/front/layouts/main.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
        }

        // Check if admin layout should be used (excluding standalone auth login view)
        if (str_starts_with($view, 'admin/') && $view !== 'admin/auth/login') {
            $layoutFile = VIEWS_PATH . '/admin/layouts/admin.php';
            if (file_exists($layoutFile)) {
                require $layoutFile;
                return;
            }
        }

        echo $content;
    }
}
