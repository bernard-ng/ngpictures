<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class HomeController extends Controller
{
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('blog');
        $this->loadModel('articles');
        $this->loadModel('categories');
        $this->loadModel('gallery');
    }

    public function index()
    {
        $last = $this->blog->latest(1, 3);
        $article = $this->blog->last();
        $photos = $this->gallery->latest(0, 6);
        $categories = $this->categories->orderBy('title', 'ASC', 0, 5);
        $verse = $this->callController('verses')->index();

        $this->pageManager::setName('Accueil');
        $this->pageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/home']);
        $this->viewRender("front_end/index", compact('photos', 'last', 'article', 'verse', 'categories'));
    }
}
