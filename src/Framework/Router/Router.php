<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Framework\Router;

use Framework\Exception\RouterException;

/**
 * Class Router
 * @package Framework\Router
 */
class Router
{

    /**
     * @var string
     */
    private $url;

    /**
     * registered routes
     * @var array
     */
    private $routes = [];

    /**
     * registered named routes
     * @var Route[]
     */
    private $namedRoutes = [];


    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->url = $_GET['url'] ?? parse_url($_SERVER['REQUEST_URI'])['path'] ?? '/';

        // trailing slash
        if (strlen($this->url) > 1 && $this->url[-1] === '/') {
            $url = substr($this->url, 0, -1);
            header("Location: /{$url}", true, 301);
        }
    }

    /**
     * register a route
     * @param string $path
     * @param $controller
     * @param string|null $name
     * @param string $method
     * @return Route
     */
    private function add(string $path, array $controller, ?string $name = null, string $method): Route
    {
        $route = new Route($path, $controller);
        $this->routes[$method][] = $route;

        if (!is_null($name)) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * register a route for http method
     * @param string $path
     * @param array $controller
     * @param string|null $name
     * @return Route
     */
    public function any(string $path, array $controller, ?string $name = null): Route
    {
        $route = new Route($path, $controller);
        $this->routes['GET'][] = $route;
        $this->routes['POST'][] = $route;

        if (!is_null($name)) {
            $this->namedRoutes[$name] = $route;
        }
        return $route;
    }

    /**
     * register a route for GET http method
     * @param string $path
     * @param array $controller
     * @param string|null $name
     * @return Route
     */
    public function get(string $path, array $controller, ?string $name = null): Route
    {
        return $this->add($path, $controller, $name, "GET");
    }

    /**
     * register a route for POST http method
     * @param string $path
     * @param array $controller
     * @param string|null $name
     * @return Route
     */
    public function post(string $path, array $controller, string $name = null): Route
    {
        return $this->add($path, $controller, $name, "POST");
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws RouterException
     */
    public function url(string $name, array $params = [])
    {
        if (!isset($this->namedRoutes[$name])) {
            throw new RouterException(sprintf("No matched routes for : %s", $name));
        }
        return $this->namedRoutes[$name]->generateUri($params);
    }

    /**
     * @return Route|null
     */
    public function run(): ?Route
    {
        if (isset($_SERVER['REQUEST_METHOD']) && isset($this->routes[$_SERVER['REQUEST_METHOD']])) {

            /** @var Route $route */
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                if ($route->match($this->url)) {
                    return $route;
                }
            }
            return null;
        }
    }
    
    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
