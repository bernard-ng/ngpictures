<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Framework\Controllers;

use Framework\Http\ServerRequest;
use Framework\Router\RouterAwareAction;
use League\Event\EmitterInterface;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;

/**
 * Class Controller
 * @package Framework\Controllers
 */
class Controller
{

    use RouterAwareAction;

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
     * @var EmitterInterface|mixed
     */
    protected $emitter;


    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->renderer = $this->container->get(RendererInterface::class);
        $this->request = $this->container->get(ServerRequest::class);
        $this->emitter = $this->container->get(EmitterInterface::class);
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
