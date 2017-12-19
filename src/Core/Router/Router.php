<?php

namespace Ng\Core\Router;
use Ng\Core\Exception\RouterException;
use Ngpictures\Ngpic;

class Router
{
	private $url,
			$routes = [],
			$namedRoute = [];

	public function __construct($url)
	{
		$this->url = $url;
	}


	private function add(string $path, $controller, string $name = null, string $method): Route
	{
		$route = new Route($path,$controller);
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
			if (Ngpic::hasDebug()) {
				throw new RouterException("undefinied Request method");
			} else {
				Ngpic::redirect('/error-500');
				return false;
			}
		}

		foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
			if ($route->match($this->url)) {
				$route->call();
				return true;
			}
		}
		(Ngpic::hasDebug())? var_dump($route) : Ngpic::redirect("/e404");
		return false;
	}


	private function url(string $name, array $params = [])
	{
		if (!isset($this->namedRoute[$name])) {
			Ngpic::redirect("/error-404");
		}
		return $this->namedRoute[$name]->getUrl($params);
	}
}
