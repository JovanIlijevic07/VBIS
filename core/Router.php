<?php

namespace app\core;

class Router
{
    public array $routes = [];

    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function put($path, $callback)
    {
        $this->routes['put'][$path] = $callback;
    }

    public function delete($path, $callback)
    {
        $this->routes['delete'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->requestMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback) {
            http_response_code(404);
            var_dump("Not found!");
            exit;
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();

            return call_user_func($callback);
        }

        if (is_string($callback)) {
            var_dump($callback);

            exit;
        }
    }
}