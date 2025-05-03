<?php
namespace App\Core;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private string $groupPrefix = '';

    /**
     * Método responsável por iniciar o roteador
     * @param Request $request (Injeção de dependência através da classe Request)
     */
    public function __construct(private Request $request) {}

    /**
     * Método responsável por registrar rota em GET
     * @param string $path
     * @param callable|array $callback
     */
    public function get(string $path, callable|array $callback): void
    {
        $this->addRoute('GET', $path, $callback);
    }

    /**
     * Método responsável por registrar rota em POST
     * @param string $path
     * @param callable|array $callback
     */
    public function post(string $path, callable|array $callback): void
    {
        $this->addRoute('POST', $path, $callback);
    }

    /**
     * Método responsável por adicionar e registrar novas rotas
     * @param string $method (método da requisição)
     * @param string $path (uri da requisição)
     */
    private function addRoute(string $method, string $path, callable|array $callback): void
    {
        $this->routes[$method][$path] = $callback;
    }

    /**
     * Método responsável por registrar rotas supervisionadas por middlewares
     * @param string $method (Método da requisição)
     * @param string $uri (URI da requisição)
     * @param callable $callback (callback do método a ser executado)
     */
    public function middleware(string $uri, string $method, callable $callback): void
    {
        $this->middlewares[$method][$uri] = $callback;
    }

    public function resolve(): void
    {
        $uri = $this->request->uri();
        $method = $this->request->method();

        $route = $this->routes[$method][$uri] ?? null;
        $middleware = $this->middlewares[$method][$uri] ?? null;

        if ($middleware) {
            call_user_func($middleware, $this->request);
        }

        if (is_array($route)) {
            [$class, $methodName] = $route;

            if (!is_object($class) && !class_exists($class)) {
                Response::json(["error" => "Classe '$class' não existe"], 500);
            }

            $controller = (is_object($class)) ? $class : new $class();

            if (!method_exists($controller, $methodName)) {
                Response::json(["error" => "Método '$methodName' não existe"], 500);
            }

            call_user_func([$controller, $methodName], $this->request);
            exit();
        }

        call_user_func($route, $this->request);
    }
}
?>