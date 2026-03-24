<?php

namespace Core;

/**
 * Simple Router
 * 
 * Maps URI patterns to Controller@method pairs.
 * Supports GET and POST methods, and dynamic {id} parameters.
 * 
 * Usage:
 *   $router->get('/users',        'UserController@index');
 *   $router->get('/users/{id}',   'UserController@show');
 *   $router->post('/users/store', 'UserController@store');
 */
class Router
{
    private array $routes = [];
    private string $controllerNamespace = 'App\\Controllers\\';

    /**
     * Register a GET route.
     */
    public function get(string $uri, string $action): self
    {
        return $this->addRoute('GET', $uri, $action);
    }

    /**
     * Register a POST route.
     */
    public function post(string $uri, string $action): self
    {
        return $this->addRoute('POST', $uri, $action);
    }

    /**
     * Add a route definition.
     */
    private function addRoute(string $method, string $uri, string $action): self
    {
        $uri = trim($uri, '/');

        // Convert {param} to regex named group
        $pattern = preg_replace('/\{([a-zA-Z_]+)\}/', '(?P<$1>[0-9]+)', $uri);
        $pattern = '#^' . $pattern . '$#';

        $this->routes[] = [
            'method'  => $method,
            'pattern' => $pattern,
            'action'  => $action,
        ];

        return $this;
    }

    /**
     * Dispatch the request.
     * Matches the current URI and HTTP method against registered routes.
     */
    public function dispatch(): void
    {
        $uri    = $this->getUri();
        $method = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            if (preg_match($route['pattern'], $uri, $matches)) {
                // Extract only named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $this->callAction($route['action'], $params);
                return;
            }
        }

        // No route matched
        http_response_code(404);
        require BASE_PATH . '/app/views/errors/404.php';
    }

    /**
     * Parse URI from the request.
     */
    private function getUri(): string
    {
        $uri = $_GET['url'] ?? '';
        return trim($uri, '/');
    }

    /**
     * Instantiate the controller and call the method.
     */
    private function callAction(string $action, array $params): void
    {
        [$controllerName, $method] = explode('@', $action);

        $controllerClass = $this->controllerNamespace . $controllerName;

        if (!class_exists($controllerClass)) {
            throw new \RuntimeException("Controller [{$controllerClass}] not found.");
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $method)) {
            throw new \RuntimeException("Method [{$method}] not found in [{$controllerClass}].");
        }

        // Call the controller method with extracted parameters
        call_user_func_array([$controller, $method], $params);
    }
}
