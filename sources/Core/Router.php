<?php

namespace App\Core;

class Router
{
  private array $routes;

  public function __construct()
  {
    $this->routes = [];
  }

  public function get(string $path, string $controllerName, string $methodName = 'index'): void
  {
    $this->routes[] = [
      "method" => "GET",
      "path" => $path,
      "controllerName" => $controllerName,
      "methodName" => $methodName
    ];
  }

  public function post(string $path, string $controllerName, string $methodName = 'index'): void
  {
    $this->routes[] = [
      "method" => "POST",
      "path" => $path,
      "controllerName" => $controllerName,
      "methodName" => $methodName
    ];
  }

  public function delete(string $path, string $controllerName, string $methodName = 'index'): void
  {
    $this->routes[] = [
      "method" => "DELETE",
      "path" => $path,
      "controllerName" => $controllerName,
      "methodName" => $methodName
    ];
  }

  public function start(): void
  {
    $method = $_SERVER["REQUEST_METHOD"];
    $path = rtrim($_SERVER["REQUEST_URI"], '/');

    if (!strlen($path)) {
      $path = '/';
    }

    foreach ($this->routes as $route) {
      $routePath = preg_replace('/\{[^\}]+\}/', '([^/]+)', $route["path"]);
      $routePath = str_replace('/', '\/', $routePath);
      $pattern = '/^' . $routePath . '$/';

      if ($method === $route["method"] && preg_match($pattern, $path, $matches)) {
        array_shift($matches); // Remove the full match
        $methodName = $route["methodName"];
        $controllerName = $route["controllerName"];

        $controller = new $controllerName();

        call_user_func_array([$controller, $methodName], $matches);
        return;
      }
    }

    // Handle 404 Not Found
    http_response_code(404);

    die('404 not found');
  }
}
