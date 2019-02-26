<?php

namespace Framework\Router;

use Framework\Exception\RouterException;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{

    /**
     * l'url entre par le user
     * @var string
     */
    private $url;

    /**
     * les routes enregister
     * @var Route[]
     */
    private $routes = [];

    /**
     * les routes nommee enregister
     * @var array
     */
    private $namedRoute = [];


    /**
     * Router constructor.
     */
    public function __construct()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $this->url = $_GET['url'] ?? $uri ?? '/';
        if (strlen($this->url) > 1 && $this->url[-1] === '/') {
            $url = substr($this->url, 0, -1);
            header("Location: /{$url}", true, 301);
        }
    }


    /**
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


    /**
     * registration de route en GET et POST
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function any(string $path, $controller, string $name = null): Route
    {
        $route = new Route($path, $controller);
        $this->routes['GET'][] = $route;
        $this->routes['POST'][] = $route;

        if ($name) {
            $this->namedRoute[$name] = $route;
        }
        return $route;
    }


    /**
     * registration url en GET
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function get(string $path, $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "GET");
    }


    /**
     * registration en POST
     * @param string $path
     * @param callable|string $controller
     * @param string $name
     * @return Route
     */
    public function post(string $path, $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "POST");
    }


    /**
     * lance le router apartir du nom d'une route
     * @param string $name
     * @param array $params
     * @return mixed
     */
    private function url(string $name, array $params = [])
    {
        if (!isset($this->namedRoute[$name])) {
            http_response_code(404);
            throw new RouterException('no routes matched', 404);
        }
        return $this->namedRoute[$name]->getUrl($params);
    }


    /**
     * lancement du routing
     * le router fait un trailing Slash cad si l'url
     * termine par un "/", il redirige vers l'url sans "/" a la fin
     * @return bool
     * olean
     * @throws RouterException
     */
    public function run()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                if ($route->match($this->url)) {
                    return $route;
                }
            }
            http_response_code(404);
        }
    }

    /**
     * Get l'url entre par le user
     *
     * @return  string
     */
    public function getUrl()
    {
        return $this->url;
    }
}