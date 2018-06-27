<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Util\ResolverTrait;



class HomeController extends Controller
{

    use ResolverTrait;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->blog         =   $this->container->get($this->model('blog'));
        $this->posts        =   $this->container->get($this->model('posts'));
        $this->gallery      =   $this->container->get($this->model('gallery'));
        $this->categories   =   $this->container->get($this->model('categories'));
    }


    /**
     * homepage
     *
     * @return void
     */
    public function index()
    {
        $last           =   $this->gallery->latest();
        $article        =   $this->blog->last();
        $categories     =   $this->categories->orderBy('title', 'DESC', 0, 5);
        $sliderTitle    =   ["Deep Shooting", "See the beauty", "Discover More", "Share feelings"];

        $this->turbolinksLocation("/");
        $this->pageManager::setName('Ngpictures');
        $this->viewRender(
            "frontend/index",
            compact('last', 'article', 'categories', 'sliderTitle')
        );
    }
}
