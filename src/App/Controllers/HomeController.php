<?php 
namespace Ngpictures\Controllers;

use Ngpictures\Util\Page;



class HomeController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('blog');
        $this->loadModel('articles');
        $this->loadModel('categories');
    }

    public function index()
    {
        $article = $this->blog->last();
        $last = $this->blog->latest(1,3);
        $categories = $this->categories->orderBy('title','ASC',0,5);
        $verse = $this->callController('verses')->index();

        Page::setName('Accueil | Ngpictures');
        Page::setMeta(['property' => 'og:url', 'content' => '//larytech.com/home']);
        $this->viewRender("home/index", compact('article','last','blog','verse','categories'));
    }
}
