<?php
namespace Framework\Renderer;

use Framework\Managers\CacheBustingManager;

class TwigRendererExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cacheBusting', [$this, 'cacheBusting']),
            new \Twig_SimpleFunction('html', [$this, 'html'], ['is_safe' => ['html']])
        ];
    }


    public function getFilters()
    {
        return [
            new \Twig_Filter('snipet', [$this, 'snipet'], ['is_safe' => ['html']])
        ];
    }


    /**
     * cache busting for twig
     *
     * @param string $filename
     * @return string
     */
    public function cacheBusting(string $filename): string
    {
        return CacheBustingManager::get($filename);
    }


    public function html($code)
    {
        return $code;
    }

    /**
     * permet de ne pas echaper l'html
     *
     * @param [type] $text
     * @return string
     */
    public function snipet($text)
    {
        return $text;
    }
}
