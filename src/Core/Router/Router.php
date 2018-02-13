<?php

namespace Ng\Core\Router;

use Ng\Core\Exception\RouterException;
use Ngpictures\Ngpictures;

class Router
{
    private $url;
    private $routes = [];
    private $namedRoute = [];

    public function __construct($url)
    {
        $this->url = $url;
    }


    /*
     * permet d'ajouter une url, registrer une route
     * @param string $path
     * @param mixed $controller
     * @param string $name
     * @param string $method
     * @return Route 
     */
    private function add(string $path, $controller, string $name = null, string $method): Route
    {
        $route = new Route($path, $controller);
        $this->routes[$method][] = $route;

        if ($name) {
            $this->namedRoute[$name] = $route;
        }
        return $route;
    }


    public function get(string $path, $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "GET");
    }


    public function post(string $path, $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "POST");
    }


    public function run(): bool
    {
        if (!isset($_SERVER['REQUEST_METHOD'])) {
            throw new RouterException("undefinied Request method");
        }

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                $route->call();
                return true;
            }
        }
        (Ngpictures::hasDebug())? var_dump($route) : Ngpictures::redirect("/error-404");
        return false;
    }


    private function url(string $name, array $params = [])
    {
        if (!isset($this->namedRoute[$name])) {
            Ngpictures::redirect("/error-404");
        }
        return $this->namedRoute[$name]->getUrl($params);
    }
}
