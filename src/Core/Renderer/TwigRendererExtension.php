<?php
namespace Ng\Core\Renderer;

use Ng\Core\Managers\CacheBustingManager;

class TwigRendererExtension extends \Twig_Extension
{

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('cacheBusting', [$this, 'cacheBusting']),
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
