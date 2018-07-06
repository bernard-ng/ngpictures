<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Util\ResolverTrait;



class HomeController extends Controller
{
    /**
     * homepage
     *
     * @return void
     */
    public function index()
    {
        $last           =   $this->loadModel('gallery')->latest();
        $article        =   $this->loadModel('blog')->last();
        $categories     =   $this->loadModel('categories')->orderBy('title', 'DESC', 0, 10);
        $sliderTitle    =   ["Deep Shooting", "See the beauty", "Discover More", "Share feelings"];

        $this->turbolinksLocation("/");
        $this->pageManager::setName('Ngpictures');
        $this->view(
            "frontend/index",
            compact('last', 'article', 'categories', 'sliderTitle')
        );
    }
}
