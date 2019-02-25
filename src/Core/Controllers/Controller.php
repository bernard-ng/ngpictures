<?php
namespace Ng\Core\Controllers;

use Psr\Container\ContainerInterface;
use Ng\Core\Renderer\RendererInterface;
use Ngpictures\Traits\Util\RequestTrait;
use Ngpictures\Traits\Util\ResolverTrait;
use Ngpictures\Traits\Util\ValidationErrorTrait;

/**
 * Class Controller
 * @package Ng\Core\Controllers
 */
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

    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $this->container->get(RendererInterface::class);
    }


    /**
     * @param $name
     * @return mixed
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
     * @return Object
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
