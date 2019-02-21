<?php
namespace Framework\Controllers;

use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use Application\Traits\Util\RequestTrait;
use Application\Traits\Util\ResolverTrait;
use Application\Traits\Util\ValidationErrorTrait;

class Controller
{
    use ValidationErrorTrait;
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
            foreach ($name as $n) {
                $this->$n = $this->container->get($this->model($n));
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
    public function view(string $view, array $variables = [])
    {
        return $this->renderer->render($view, $variables);
    }
}
