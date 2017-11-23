<?php

namespace Core\Router;
use \Ngpic;

class Route
{
	private $path,
			$controller,
			$matches = [],
			$params = [];

	public function __construct(string $path, $controller)
	{
		$this->path = trim($path,"/");
		$this->controller = $controller;
	}

	public function with(string $param,string $regex): Route
	{
		$this->params[$param] = str_replace("(","(?:",$regex);
		return $this;
	}

	public function match(string $url)
	{
		$url = trim($url,"/");
		$path = preg_replace_callback("#:([\w]+)#",[$this,'paramMatch'],$this->path);
		$regex = "#^$path$#i";

		if (!preg_match($regex,$url,$matches)) {
			return false;
		}

		array_shift($matches);
		$this->matches = $matches;
		return true;
	}

	private function paramMatch($match): string
	{
		if (isset($this->params[$match[1]])) {
			return "(".$this->params[$match[1]].")";
		}
		return '([^/]+)';
	}

	public function call()
	{
		if (is_string($this->controller)) {
			$url = explode("#", $this->controller);
			$controller = Ngpic::getInstance()->getController($url[0]);
			$action = $url[1] ?? 'index';
			
			return call_user_func_array([$controller, $action], $this->matches);
		}
		return call_user_func_array($this->controller,$this->matches);
	}

	public function getUrl(array $params): string 
	{
		$path = $this->path;
		foreach ($params as $k => $v) {
			$path = str_replace(":$k","$v", $path);
		}
		return $path;
	}
}
