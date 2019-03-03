<?php
namespace Framework\Twig;

use Framework\Router\RouterAwareAction;

/**
 * Class RouterTwigExtension
 * @package Framework\Twig
 */
class RouterTwigExtension extends \Twig_Extension
{
    
    use RouterAwareAction;

    /**
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('path', [$this, 'pathFor']),
            new \Twig_Function('asset', [$this, 'asset']),
            new \Twig_Function('method', [$this, 'requestMethod'], ['is_safe' => ['html']])
        ];
    }


    /**
     * @param string $path
     * @param array $param
     * @return string
     */
    public function pathFor(string $path, array $param = [])
    {
        $router = $this->getRouter();
        if (ENV === 'production') {
            return SITE_NAME . "/{$router->url($path, $param)}";
        }
        return "/{$router->url($path, $param)}";
    }


    /**
     * renvoi le fichier asset par rapport au nom du site
     * @param string $resource
     * @param string $cdn
     * @return string
     */
    public function asset(string $resource, string $cdn = '')
    {
        if (ENV === 'development' || empty($cdn)) {
            $resource = SITE_NAME . "/$resource";
            return $resource;
        } elseif (ENV === 'production' && !empty($cdn)) {
            return $cdn;
        }
    }


    /**
     * definit la method de la request
     * @param string $method
     * @return null|string
     */
    public function requestMethod(string $method)
    {
        $expectedMethods = [
            'PUT', 'DELETE', 'PATCH', 'POST', 'GET'
        ];

        $method = strtoupper($method);
        if (in_array($method, $expectedMethods)) {
            return "<input type='hidden' name='_method' value='{$method}' >";
        }
        return null;
    }
}
