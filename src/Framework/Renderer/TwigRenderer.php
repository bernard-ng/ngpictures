<?php
namespace Framework\Renderer;

use Psr\Container\ContainerInterface;


/**
 * Class TwigRenderer
 * @package Framework\Renderer
 */
class TwigRenderer implements RendererInterface
{


    /**
     * instance de twig
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * TwigRenderer constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {

        $this->twig = $twig;
    }


    /**
     * rendre une vue
     * @param string $view
     * @param array $variables
     * @param bool $toString
     * @return mixed
     */
    public function render(string $view, array $variables = [], $toString = false)
    {
        if ($toString) {
            ob_start();
                echo $this->twig->render("$view.twig", $variables);
                $content = ob_get_clean();
            return html_entity_decode($content);
        } else {
            echo $this->twig->render("$view.twig", $variables);
        }
    }


    /**
     * ajouter des variables global pour une vue
     * @param string $key
     * @param $value
     * @return void
     */
    public function addGlobal(string $key, $value)
    {
        $this->twig->addGlobal($key, $value);
    }
}
