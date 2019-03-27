<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Framework\Renderer;

use Psr\Container\ContainerInterface;

/**
 * Class TwigRendererFactory
 * @package Framework\Renderer
 */
class TwigRendererFactory
{

    /**
     * @param ContainerInterface $container
     * @return TwigRenderer
     */
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        $loader = new \Twig_Loader_Filesystem(ROOT."/views");
        $twig = new \Twig_Environment($loader, [
            'debug' => (ENV === 'development'),
            'cache' => (ENV === 'production')? ROOT."/cache/render" : false,
        ]);

        if (ENV === 'development') {
            $twig->addExtension(new \Twig_Extension_Debug());
        }

        foreach ((require ROOT . "/config/extensions.php") as $extension) {
            $twig->addExtension($container->get($extension));
        }

        return new TwigRenderer($twig);
    }
}
