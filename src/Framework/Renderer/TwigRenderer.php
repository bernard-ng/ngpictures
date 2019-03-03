<?php
namespace Framework\Renderer;

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

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(ROOT."/views");
        $this->twig = new \Twig_Environment($loader, [
            'debug' => (ENV === 'development'),
            'cache' => (ENV === 'production')? ROOT."/cache/render" : false,
        ]);

        if (ENV === 'development') {
            $this->twig->addExtension(new \Twig_Extension_Debug());
        }

        foreach ((require ROOT . "/config/extensions.php") as $extension) {
            $this->twig->addExtension(new $extension());
        }
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
