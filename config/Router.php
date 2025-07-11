<?php

require_once __DIR__ . '/../utils/Response.php';

class Router
{
    private array $routes = [];
    private string $basePath = '';

    public function __construct(string $basePath = '')
    {
        $this->basePath = rtrim($basePath, '/'); // Remove trailing slash
    }

    public function add(string $method, string $pattern, callable $callback): void
    {
        $regex = $this->convertPatternToRegex($pattern);
        $this->routes[] = compact('method', 'regex', 'callback');
    }

    public function dispatch(string $method, string $uri): void
    {
        $path = parse_url($uri, PHP_URL_PATH); // removes query strings

        // Ensure base path is present at the beginning
        if ($this->basePath && strpos($path, $this->basePath) === 0) {
            $path = substr($path, strlen($this->basePath));
        }

        // Normalize to always start with slash
        $path = '/' . ltrim($path, '/');

        foreach ($this->routes as $route) {
            if (strtoupper($method) !== strtoupper($route['method'])) continue;

            if (preg_match($route['regex'], $path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                call_user_func_array($route['callback'], $params);
                return;
            }
        }

        // 404 response
        sendError("Endpoint not found", 404);
    }

    private function convertPatternToRegex(string $pattern): string
    {
        // Replace parameters like {id} or {file:.+}
        $regex = preg_replace_callback('#\{(\w+)(?::([^}]+))?\}#', function ($matches) {
            $name = $matches[1];
            $pattern = isset($matches[2]) ? $matches[2] : '[^/]+';
            return "(?P<{$name}>{$pattern})";
        }, $pattern);

        // Support optional trailing slash
        return "#^" . $regex . "/?$#";
    }
}
