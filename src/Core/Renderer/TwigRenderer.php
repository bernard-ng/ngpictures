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
            'debug' => true,
            'cache' => false, //ROOT."/cache",
        ]);

        $this->twig->addExtension(new \Twig_Extension_Debug());
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
    public function render(string $view, array $variables = [])
    {
        echo $this->twig->render("$view.twig", $variables);
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
