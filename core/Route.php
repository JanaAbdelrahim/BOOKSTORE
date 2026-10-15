<?php
class Route
{
    private static array $routes = [];

    //* get method
    public static function get(string $url, string $controller, string $action, array $middleWares = []): void
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'GET',
            'controller' => $controller,
            'action' => $action,
            'middlewares' => $middleWares
        ];
    }

    //* post method 
    public static function post(string $url, string $controller, string $action, array $middleWares = []): void
    {
        self::$routes[] = [
            'url' => $url,
            'method' => 'POST',
            'controller' => $controller,
            'action' => $action,
            'middlewares' => $middleWares
        ];
    }

    //* get All routes
    public static function  getRoutes(): array
    {
        return self::$routes;
    }

    //* show the page 
    public static function  dispatch()
    {
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = rtrim($url, '/');
        $method = $_SERVER['REQUEST_METHOD'];
        $flag = false;
        foreach (self::$routes as $route) {
            $arge = self::matchRoute(BASE_URL . $route['url'], $url);
            if ($arge !== false) {
                if ($method !== $route['method']) {
                    $flag = true;
                    continue;
                }

                $flag = false;
                self::handelMiddleware($route['middlewares']);
                $controller = new $route['controller']();
                $controller->{$route['action']}(...$arge);
                return;
            }
        }

        if ($flag) {
            Response::error("405 {$method} Not Allowed", 405);
            return;
        }
        Response::error("404 Not Found", 404);
    }

    private static function matchRoute(string $route, string $url): false | array
    {
        $regex = "/\{[A-Za-z_][A-Za-z_0-9]*\}/";
        $pattren = preg_replace($regex, "([^/]+)", $route);
        $pattren = "#^$pattren$#i";

        if (!preg_match($pattren, $url, $mathes)) {
            return false;
        }

        unset($mathes[0]);
        return $mathes;
    }


    private static function handelMiddleware(array $middleWares): void
    {
        foreach ($middleWares as $middleWare) {
            $args = [];
            if (str_contains($middleWare, ":")) {
                [$middleWare, $argsString] = explode(":", $middleWare, 2);
                $args = explode(",", $argsString);
            }
            (new $middleWare())->handle(...$args);
        }
    }
}
