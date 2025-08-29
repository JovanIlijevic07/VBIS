<?php

namespace App\Core;

class Router
{
    private $routes = [];
    
    public function get($path, $controller, $method)
    {
        $this->routes['GET'][$path] = ['controller' => $controller, 'method' => $method];
    }
    
    public function post($path, $controller, $method)
    {
        $this->routes['POST'][$path] = ['controller' => $controller, 'method' => $method];
    }
    
    public function dispatch()
{
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    $basePath = dirname($_SERVER['SCRIPT_NAME']);
    if ($basePath !== '/') {
        $requestUri = substr($requestUri, strlen($basePath));
    }

    if (!$requestUri) {
        $requestUri = '/';
    }

    if (isset($this->routes[$requestMethod][$requestUri])) {
        // tačan match (bez parametara)
        $route = $this->routes[$requestMethod][$requestUri];
        $controller = new $route['controller']();
        $method = $route['method'];
        $controller->$method();
        return;
    }

    // match sa parametrom {id}
    foreach ($this->routes[$requestMethod] as $path => $route) {
        if (strpos($path, '{id}') !== false) {
            $pattern = str_replace('{id}', '(\d+)', $path);
            if (preg_match("#^{$pattern}$#", $requestUri, $matches)) {
                $controller = new $route['controller']();
                $method = $route['method'];
                $controller->$method($matches[1]); // prosleđuje ID
                return;
            }
        }
    }

    http_response_code(404);
    echo "404 - Page Not Found";
}
}