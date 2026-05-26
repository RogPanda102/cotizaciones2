<?php

class Router
{
    public static array $routes = [];
    public static array $namedRoutes = []; // 👈 IMPORTANTE
    public static function get($uri, $action, $options = [])
    {
        self::$routes['GET'][$uri] = [
            'action' => $action,
            'name' => $options['as'] ?? null
        ];
        if (isset($options['as'])) {
        self::$namedRoutes[$options['as']] = $uri;
    }
    }

    public static function post($uri, $action, $options = [])
    {
        self::$routes['POST'][$uri] = [
            'action' => $action,
            'name' => $options['as'] ?? null
        ];
        if (isset($options['as'])) {
        self::$namedRoutes[$options['as']] = $uri;
    }
    }

    public static function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = '/' . trim($_GET['url'] ?? '', '/');

        if ($uri === '/') {
            $uri = '/';
        }
        $route = self::$routes[$method][$uri] ?? null;

        if (!$route) {
            die("404 Not Found");
        }

        $action = $route['action'];

        if (is_callable($action)) {
            return call_user_func($action);
        }

        // formato: Controller::method
        [$controller, $method] = explode('::', $action);

        require_once __DIR__ . "/../controllers/$controller/$method.php";
    }
    
}

/*
|--------------------------------------------------------------------------
| HELPER GLOBAL (ESTO ES LO IMPORTANTE)
|--------------------------------------------------------------------------
*/

function route($name)
{
    return '/cotizaciones2' . Router::$namedRoutes[$name];
}

function asset($ruta)
{
    return '/cotizaciones2/' . ltrim($ruta, '/');
}

function config($key)
{
    global $rutas;

    return $rutas[$key] ?? null;
}