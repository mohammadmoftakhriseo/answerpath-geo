<?php
declare(strict_types=1);

namespace App\Core;

/**
 * Enterprise Fast Lightweight Regex-based MVC Router with Middleware Pipeline
 */
class Router
{
    private array $routes = [];
    private array $middlewares = [
        'auth'        => \App\Core\Middleware\AuthMiddleware::class,
        'guest'       => \App\Core\Middleware\GuestMiddleware::class,
        'csrf'        => \App\Core\Middleware\CsrfMiddleware::class,
        'rate_limit'  => \App\Core\Middleware\RateLimitMiddleware::class,
        'throttle'    => \App\Core\Middleware\RateLimitMiddleware::class,
    ];

    public function get(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    public function put(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('PUT', $path, $handler, $middlewares);
    }

    public function delete(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('DELETE', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, array $handler, array $middlewares): void
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'      => $method,
            'path'        => $path,
            'pattern'     => $pattern,
            'controller'  => $handler[0],
            'action'      => $handler[1],
            'middlewares' => $middlewares,
        ];
    }

    public function dispatch(Request $request, Response $response): void
    {
        $reqMethod = $request->getMethod();
        $reqUri = $request->getUri();

        foreach ($this->routes as $route) {
            if ($route['method'] === $reqMethod && preg_match($route['pattern'], $reqUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $request->setParams($params);

                // Execute Middlewares in sequential pipeline
                foreach ($route['middlewares'] as $midKey) {
                    $midName = $midKey;
                    $args = [];

                    // Support parameter passing like 'rate_limit:10,60'
                    if (str_contains($midKey, ':')) {
                        [$midName, $paramStr] = explode(':', $midKey, 2);
                        $args = array_map('intval', explode(',', $paramStr));
                    }

                    if (isset($this->middlewares[$midName])) {
                        $middlewareClass = $this->middlewares[$midName];
                        $middleware = !empty($args) ? new $middlewareClass(...$args) : new $middlewareClass();
                        $middleware->handle($request, $response);
                    }
                }

                $controllerClass = $route['controller'];
                $action = $route['action'];

                if (!class_exists($controllerClass)) {
                    throw new \RuntimeException("Controller {$controllerClass} not found.");
                }

                $controller = new $controllerClass();
                if (!method_exists($controller, $action)) {
                    throw new \RuntimeException("Action {$action} not found in {$controllerClass}.");
                }

                $controller->$action($request, $response);
                return;
            }
        }

        // 404 Not Found
        http_response_code(404);
        $response->setStatusCode(404);
        View::render('errors/404', [
            'title'       => 'صفحه پیدا نشد (خطای ۴۰۴) | محمد مفتخری',
            'description' => 'صفحه مورد نظر شما در وب‌سایت محمد مفتخری یافت نشد.',
            'canonical'   => url('/404')
        ]);
    }
}
