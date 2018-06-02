<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class HomeController extends Controller
{
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel(['blog', 'posts', 'categories', 'gallery']);
    }


    /**
     * homepage
     *
     * @return void
     */
    public function index()
    {
        $last           =   $this->blog->latest(1, 4);
        $photos         =   $this->gallery->latest();
        $article        =   $this->blog->last();
        $categories     =   $this->loadModel('categories')->orderBy('title', 'DESC', 0, 5);
        $sliderTitle    =   ["Deep Shooting", "See the beauty", "Discover More", "Share feelings"];

        $this->app::turbolinksLocation("/");
        $this->pageManager::setName('Ngpictures');
        $this->viewRender(
            "front_end/index",
            compact('last', 'article', 'photos', 'categories', 'sliderTitle')
        );
    }
}
