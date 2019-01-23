<?php

declare(strict_types=1);

namespace App\Handler;

use App\Repositories\PostsRepository;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\JsonResponse;

/**
 * Class HomePageHandler
 * @package App\Handler
 */
class HomePageHandler implements RequestHandlerInterface
{

    /**
     * @var PostsRepository|mixed
     */
    private $posts;

    /**
     * HomePageHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->posts = $container->get(PostsRepository::class);
    }


    /**
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        echo "<pre>";
        var_dump($this->posts->all());

        die();
    }
}
