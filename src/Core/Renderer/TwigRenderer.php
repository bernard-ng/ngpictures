<?php
namespace Ng\Core\Renderer;

class TwigRenderer implements RendererInterface
{


    /**
     * instance de twig
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct()
    {
        $loader = new \Twig_Loader_Filesystem(APP."/Views");
        $this->twig = new \Twig_Environment($loader, [
            'debug' => (ENV === 'developpment'),
            'cache' => (ENV === 'production')? ROOT."/cache/render" : false,
        ]);

        $this->twig->addExtension(new \Twig_Extension_Debug());
        $this->twig->addExtension(new TwigRendererExtension());
    }


    /**
     * rendre une vue
     * @param string $view
     * @param array $variables
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
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
