<?php

namespace BabeRuka\SystemRoles\Services;

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/**
 * Class SystemRouteScanner
 *
 * This class provides a utility to scan and list all registered routes
 * in a Laravel application, similar to the `php artisan route:list` command.
 */
class SystemRouteScanner
{
    /**
     * The Laravel Router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Create a new SystemRouteScanner instance.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function __construct()
    {
        $this->router = Route::getFacadeRoot();
    }

    /**
     * Get a list of all registered routes in the application.
     *
     * @return array<int, array<string, mixed>>
     */
    public function scanRoutes(): array
    {
        $routes = $this->router->getRoutes();
        $routeList = []; 
        foreach ($routes as $route) { 
            $uri = $route->uri();
            $methods = implode('|', $route->methods());
            $name = $route->getName() ?: '';

            $action = 'Closure'; 
            if ($route->getActionName() !== 'Closure') {
                $action = $route->getActionName();
            }
            $routeAction = $route->getAction(); 
            if (isset($routeAction['uses'])) {
                // If the 'uses' key exists, it's typically a controller@method string or a Closure object
                if (is_string($routeAction['uses'])) {
                    $action = $routeAction['uses']; // It's a controller@method string
                }
                // If $routeAction['uses'] is a Closure object, $action remains 'Closure' (our default)
            } elseif (isset($routeAction[0]) && is_object($routeAction[0]) && $routeAction[0] instanceof \Closure) {
                // Handle cases where the closure is directly at index 0 of the action array
                $action = 'Closure';
            } elseif (is_string($route->getActionName())) {
                // Fallback to getActionName() if it returns a string and wasn't handled above.
                // This covers cases where getActionName() might already return 'Closure' string
                // or other string representations.
                $action = $route->getActionName();
            }
            $prefix = $routeAction['prefix'] ?? '';
            $controller = $routeAction['controller'] ?? '';
            $route_name = $routeAction['as'] ?? '';
           // Extract the middleware applied to the route
            $middleware = $route->gatherMiddleware(); 
            $middleware_f = $this->format_data($middleware); 
            $routeList[] = [
                'uri' => $uri,
                'methods' => $methods,
                'name' => $name,
                'action' => $action,
                'middleware' => $middleware,
                'prefix' => $prefix,
                'controller' => $controller,
                'route_name' => $route_name
            ];
        }
        return $routeList;
    }

    /**
     * Get a formatted string representation of all registered routes.
     * This mimics the output of `php artisan route:list`.
     *
     * @return string
     */
    public function getFormattedRouteList(): string
    {
        $routes = $this->scanRoutes();
        $output = '';

        if (empty($routes)) {
            return "No routes defined.\n";
        }

        $maxMethodLen = max(array_map(fn($r) => strlen($r['methods']), $routes));
        $maxUriLen = max(array_map(fn($r) => strlen($r['uri']), $routes));
        $maxNameLen = max(array_map(fn($r) => strlen($r['name']), $routes));
        $maxActionLen = max(array_map(fn($r) => strlen($r['action']), $routes));

        $output .= sprintf(
            "%-{$maxMethodLen}s | %-{$maxUriLen}s | %-{$maxNameLen}s | %-{$maxActionLen}s | %s\n",
            'Method', 'URI', 'Name', 'Action', 'Middleware'
        );
        $output .= sprintf(
            "%s | %s | %s | %s | %s\n",
            str_repeat('-', $maxMethodLen),
            str_repeat('-', $maxUriLen),
            str_repeat('-', $maxNameLen),
            str_repeat('-', $maxActionLen),
            str_repeat('-', 10) // Arbitrary length for middleware, as it can be long
        );

        // Add route data
        foreach ($routes as $route) {
            $output .= sprintf(
                "%-{$maxMethodLen}s | %-{$maxUriLen}s | %-{$maxNameLen}s | %-{$maxActionLen}s | %s\n",
                
                $route['methods'],
                $route['controller'],
                $route['prefix'],  
                $route['uri'],
                $route['name'],
                $route['action'],
                $route['middleware']
            );
        }

        return $output;
    }
    function format_data($all_data){
        $result = [];
        foreach($all_data as $key => $value){
            $result[$key] = $value;
        }
        return $result;
    }
    
}
