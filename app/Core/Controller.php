<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    protected function json(Response $response, mixed $data, int $status = 200): void
    {
        $response->json($data, $status);
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
