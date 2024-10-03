<?php

namespace OrionCore\Framework\Router;

use OrionCore\Framework\Controllers\ViewController;

class Router
{
    protected $routes = [], $publicDirs = [];

    public function new(string $method, string $url, ViewController $controller): void
    {
        $this->routes[$method][$url] = $controller;
    }

    public function group(string $urlBase, callable $handler, array $middlewares = []):void
    {
        $handler($this, $urlBase);
    }
    public function serveDir(string $path): void
    {
        array_push($this->publicDirs, $path);
    }

    public function exit404(): never
    {
        header("HTTP/1.0 404 Not Found");
        exit();
    }

    public function getContentType(string $filePath): string
    {
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $mimeTypes = [
            'css' => 'text/css',
            'js' => 'application/javascript',
            'html' => 'text/html',
            'png' => 'image/png',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'txt' => 'text/plain',
            'pdf' => 'application/pdf'
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream'; // Default binary stream if unknown
    }


    public function matchRoute(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = $_SERVER['REQUEST_URI'];
        $urlParts = parse_url($url);
        $path = $urlParts['path'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routeUrl => $controller) {
                $pattern = preg_replace('/\/:([^\/?]+)/', '/(?P<$1>[^/]+)', $routeUrl);

                if (preg_match('#^' . $pattern . '$#', $path, $matches)) {
                    $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    $controller->render();

                    return;
                }
            }
        }

        foreach ($this->publicDirs as $value) {
            if (preg_match("/^" . preg_quote(sprintf($value), '/') . "/", $path)) {
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $path;
                if (file_exists($filePath)) {
                    $contentType = $this->getContentType($filePath);
                    header('Content-Type: ' . $contentType);
                    readfile($filePath);
                    return;
                } else
                    $this->exit404();
                return;
            }
        }

        $this->exit404();
    }
}