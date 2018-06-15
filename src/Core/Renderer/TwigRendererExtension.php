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
}
