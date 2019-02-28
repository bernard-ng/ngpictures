<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Framework\Router;

/**
 * Class Route
 * @package Framework\Router
 */
class Route
{

    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $controller;

    /**
     * matched params for a route
     * @var array
     */
    private $matches = [];

    /**
     * match params with "with" method
     * @var array
     */
    private $params = [];

    /**
     * Route constructor.
     * @param string $path
     * @param array $controller
     */
    public function __construct(string $path, array $controller)
    {
        $this->path = trim($path, "/");
        $this->controller = $controller;
    }

    /**
     * @param string $param
     * @param string $regex
     * @return Route
     */
    public function with(string $param, string $regex): Route
    {
        $this->params[$param] = str_replace("(", "(?:", $regex);
        return $this;
    }

    /**
     * @param string $url
     * @return bool
     */
    public function match(string $url): bool
    {
        $url = trim($url, "/");
        $path = preg_replace_callback("#:([\w]+)#", [$this,'paramMatch'], $this->path);
        $regex = "#^{$path}$#i";

        if (!preg_match($regex, $url, $matches)) {
            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    /**
     * @param $match
     * @return string
     */
    private function paramMatch($match): string
    {
        if (isset($this->params[$match[1]])) {
            return "(".$this->params[$match[1]].")";
        }
        return '([^/]+)';
    }

    /**
     * @param array $params
     * @return string
     */
    public function generateUri(array $params): string
    {
        $path = $this->path;
        foreach ($params as $k => $v) {
            $path = str_replace(":$k", "$v", $path);
        }
        return $path;
    }

    /**
     * @return array
     */
    public function getMatches()
    {
        return $this->matches;
    }

    /**
     * @return array
     */
    public function getController()
    {
        return $this->controller;
    }
}
