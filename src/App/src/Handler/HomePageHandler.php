<?php

declare(strict_types=1);

namespace App\Handler;

use Zend\Expressive\Router;
use Zend\Expressive\Twig\TwigRenderer;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Zend\Expressive\Plates\PlatesRenderer;
use Zend\Expressive\Router\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Expressive\ZendView\ZendViewRenderer;
use Zend\Expressive\Template\TemplateRendererInterface;

class HomePageHandler implements RequestHandlerInterface
{
    /** @var string */
    private $containerName;

    /** @var Router\RouterInterface */
    private $router;

    /** @var null|TemplateRendererInterface */
    private $template;


    /**
     *
     * @param string $containerName
     * @param Router\RouterInterface $router
     * @param TemplateRendererInterface|null $template
     */
    public function __construct(string $containerName, Router\RouterInterface $router, ?TemplateRendererInterface $template = null) 
    {
        $this->containerName = $containerName;
        $this->router        = $router;
        $this->template      = $template;
    }


    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        if ($this->template === null) {
            return new JsonResponse([
                'welcome' => 'Congratulations! You have installed the zend-expressive skeleton application.',
                'docsUrl' => 'https://docs.zendframework.com/zend-expressive/',
            ]);
        }

        $data = [];
        $data['containerName'] = 'PHP-DI';
        $data['containerDocs'] = 'http://php-di.org';
        $data['routerName'] = 'FastRoute';
        $data['routerDocs'] = 'https://github.com/nikic/FastRoute';
        $data['templateName'] = 'Twig';
        $data['templateDocs'] = 'http://twig.sensiolabs.org/documentation';

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
