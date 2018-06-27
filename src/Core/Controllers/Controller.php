<?php
namespace Ng\Core\Controllers;

use Psr\Container\ContainerInterface;
use Ng\Core\Renderer\RendererInterface;
use Ngpictures\Traits\Util\ResolverTrait;
use Ngpictures\Traits\Util\RequestTrait;


class Controller
{
    use ResolverTrait;
    use RequestTrait;

    /**
     * le renderer
     * @var RendererInterface
     */
    protected $renderer;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $this->container->get(RendererInterface::class);
    }


    /**
     * le nom du model
     * @param string|array $model
     * @return void
     */
    public function loadModel($name)
    {
        if (is_array($name)) {
            foreach($name as $n) {
                $this->$n = $this->container->get($this->model($n));
                return $this->$n;
            }
        } else {
            $this->$name = $this->container->get($this->model($name));
            return $this->$name;
        }
    }


    /**
     * le nom du controlle
     * @param string $name
     * @return void
     */
    public function callController(string $name)
    {
        return $this->container->get($this->controller($name));
    }


    /**
     * rendu de la vue
     * @param string $view
     * @param array $variables
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function viewRender(string $view, array $variables = [])
    {
        return $this->renderer->render($view, $variables);
    }
}
