<?php

namespace App\Core;

class Router
{
    private $routes = [];

    /**
     * Add a GET route
     * 
     * @param string $uri The URI pattern
     * @param string $controller The controller class
     * @param string $method The method to call
     * @return void
     */
    public function get($uri, $controller, $method)
    {
        $this->addRoute('GET', $uri, $controller, $method);
    }

    /**
     * Add a POST route
     * 
     * @param string $uri The URI pattern
     * @param string $controller The controller class
     * @param string $method The method to call
     * @return void
     */
    public function post($uri, $controller, $method)
    {
        $this->addRoute('POST', $uri, $controller, $method);
    }

    /**
     * Add a route
     * 
     * @param string $method The HTTP method
     * @param string $uri The URI pattern
     * @param string $controller The controller class
     * @param string $method The method to call
     * @return void
     */
    private function addRoute($method, $uri, $controller, $methodCall)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'methodCall' => $methodCall
        ];
    }

    /**
     * Dispatch the request to the appropriate controller
     * 
     * @param string $uri The requested URI
     * @param string $method The HTTP method
     * @return void
     */
    public function dispatch($uri, $method)
    {
        // Remove query string from URI
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Remove trailing slash
        $uri = rtrim($uri, '/');
        
        // Handle exact matches first
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            // Exact match
            if ($route['uri'] === $uri) {
                $this->executeController($route);
                return;
            }
        }
        
        // Handle dynamic routes (simple pattern matching)
        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }
            
            // Simple pattern matching for routes with parameters
            if ($this->matchRoute($route['uri'], $uri, $params)) {
                $this->executeController($route, $params);
                return;
            }
        }
        
        $this->handleNotFound();
    }

    /**
     * Match route with simple pattern matching
     * 
     * @param string $routeUri The route pattern
     * @param string $requestUri The requested URI
     * @param array $params The extracted parameters
     * @return bool True if route matches
     */
    private function matchRoute($routeUri, $requestUri, &$params = [])
    {
        // Split URIs into segments
        $routeSegments = explode('/', trim($routeUri, '/'));
        $requestSegments = explode('/', trim($requestUri, '/'));
        
        // Must have same number of segments
        if (count($routeSegments) !== count($requestSegments)) {
            return false;
        }
        
        $params = [];
        
        // Check each segment
        for ($i = 0; $i < count($routeSegments); $i++) {
            $routeSegment = $routeSegments[$i];
            $requestSegment = $requestSegments[$i];
            
            // If it's a parameter placeholder
            if (preg_match('/^\{(.+?)\}$/', $routeSegment, $matches)) {
                $paramType = $matches[1];
                
                // Validate parameter based on type
                if ($paramType === 'id') {
                    if (!is_numeric($requestSegment)) {
                        return false;
                    }
                }
                // For {any} or other parameters, accept any value
                
                $params[] = $requestSegment;
            } elseif ($routeSegment !== $requestSegment) {
                // Static segment must match exactly
                return false;
            }
        }
        
        return true;
    }

    /**
     * Execute the controller
     * 
     * @param array $route The route information
     * @param array $params The parameters
     * @return void
     */
    private function executeController($route, $params = [])
    {
        // Create controller instance
        $controllerClass = "App\\Controllers\\" . $route['controller'];
        if (!class_exists($controllerClass)) {
            $controllerClass = "App\\Controllers\\Admin\\" . $route['controller'];
        }
        
        if (!class_exists($controllerClass)) {
            $this->handleNotFound();
            return;
        }
        
        $controller = new $controllerClass();
        
        // Call the method with parameters
        call_user_func_array([$controller, $route['methodCall']], $params);
    }

    /**
     * Handle 404 Not Found
     * 
     * @return void
     */
    private function handleNotFound()
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}