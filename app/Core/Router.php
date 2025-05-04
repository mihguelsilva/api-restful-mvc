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
     * Método responsável por registrar rota em PUT
     * @param string $path
     * @param callable|array $callback
     */
    public function put(string $path, callable|array $callback): void
    {
        $this->addRoute('PUT', $path, $callback);
    }

    /**
     * Método responsável por registrar rota em DELETE
     * @param string $path
     * @param callable|array $callback
     */
    public function delete(string $path, callable|array $callback): void
    {
        $this->addRoute('DELETE', $path, $callback);
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
    public function middleware(string $uri, string $method, callable|array $callback): void
    {
        $this->middlewares[$method][$uri] = $callback;
    }

    private function matchDynamicRoute(array $routes, string $uri): ?array
    {
        foreach($routes as $path => $callback) {
            $pattern = preg_replace('#\{[\w]+\}#', '([\w-]+)', $path);
            $pattern = "#^{$pattern}$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);  // remove o full match
                // Se quiser passar $matches depois, pode guardar aqui
                return ['callback' => $callback, 'params' => $matches];
            }
        }

        return null;
    }

    public function resolve(): void
    {
        $uri = $this->request->uri();
        $method = $this->request->method();

        $route = $this->matchDynamicRoute($this->routes[$method] ?? [], $uri);
        $middleware = $this->matchDynamicRoute($this->middlewares[$method] ?? [] , $uri);

        if ($middleware) {
            [$class, $methodName, $role] = $middleware['callback'];

            if (class_exists($class) && method_exists($class, $methodName) && is_array($role)) {
                call_user_func([$class, $methodName], $this->request, $role);
            } else {
                throw new \Exception('Middleware inválido: Classe, método ou perfil não encontrado');
            }
        }

        if (is_array($route)) {
            [$class, $methodName] = $route['callback'];
            [$param] = $route['params'];

            if (!is_object($class) && !class_exists($class)) {
                Response::json(["error" => "Classe '$class' não existe"], 500);
            }

            $controller = (is_object($class)) ? $class : new $class();

            if (!method_exists($controller, $methodName)) {
                Response::json(["error" => "Método '$methodName' não existe"], 500);
            }

            call_user_func([$controller, $methodName], $this->request, $param);
            exit();
        }
        Response::json(['error' => 'Rota não registrada para método'], 500);
    }
}
?>