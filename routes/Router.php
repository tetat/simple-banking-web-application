<?php

namespace Routes;

use App\Constants\HttpCode;
use App\Middleware\Middleware;

class Router
{
    private $routes = [];

    public function route(string $path, string $method)
    {
        if ($method === 'POST') {
            $method = $_POST['_method'] ?? $method;
        }

        $status = HttpCode::NOTFOUND;

        foreach ($this->routes as $route) {
            if ($path !== $route["path"]) continue;
            
            $status = HttpCode::FORBIDDEN;
            if ($method !== $route["method"]) continue;

            Middleware::resolve($route['middleware']);
            
            [$controller, $action] = $route['controller'];
            return (new $controller())->$action();
        }

        view($status);
    }

    public function get(string $path, array $controller)
    {
        return $this->add('GET', $path, $controller);
    }

    public function post(string $path, array $controller)
    {
        return $this->add('POST', $path, $controller);
    }

    public function patch(string $path, array $controller)
    {
        return $this->add('PATCH', $path, $controller);
    }

    public function delete(string $path, array $controller)
    {
        return $this->add('DELETE', $path, $controller);
    }

    public function middleware(string $method)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $method;

        // return $this;
    }

    private function add($method, $path, $controller)
    {
        $this->routes[] = [
            'path' => $path,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

}