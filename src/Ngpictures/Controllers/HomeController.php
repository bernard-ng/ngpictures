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
        $last = $this->blog->latest(1, 4);
        $article = $this->blog->last();
        $categories = $this->categories->orderBy('title', 'ASC', 0, 5);
        $this->pageManager::setName('Accueil');
        $this->viewRender("front_end/index", compact('last', 'article', 'categories'));
    }
}
