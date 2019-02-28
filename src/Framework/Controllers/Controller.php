<?php
namespace Framework\Controllers;

use Framework\Http\ServerRequest;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use Application\Traits\Util\RequestTrait;
use Application\Traits\Util\ResolverTrait;
use Application\Traits\Util\ValidationErrorTrait;

/**
 * Class Controller
 * @package Framework\Controllers
 */
class Controller
{
    use ValidationErrorTrait;

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
     * @var ServerRequest|mixed
     */
    protected $request;


    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $this->container->get(RendererInterface::class);
        $this->request = $this->container->get(ServerRequest::class);
    }


    /**
     * @param string $view
     * @param array $variables
     * @return mixed
     */
    public function view(string $view, array $variables = [])
    {
        return $this->renderer->render($view, $variables);
    }
}
