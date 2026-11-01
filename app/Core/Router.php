<?php
declare(strict_types=1);

namespace App\Core;

use Closure;

final class Router
{
    /** @param array<string, array{0:string,1:string,2:string[]}> $routes */
    public function __construct(private array $routes, private Closure $make) {}

    public function dispatch(string $method, string $uri): void
    {
        $path  = rtrim(parse_url($uri, PHP_URL_PATH) ?: '/', '/') ?: '/';
        $route = $this->routes["$method $path"] ?? null;

        if ($route === null) {
            http_response_code(404);
            echo 'No encontrado';
            return;
        }

        [$class, $action, $roles] = $route;

        if ($roles !== []) {
            if (!Auth::check()) {
                header('Location: /login');
                return;
            }
            if (!in_array(Auth::rol(), $roles, true)) {
                http_response_code(403);
                echo 'Prohibido';
                return;
            }
        }

        ($this->make)($class)->$action();
    }
}
