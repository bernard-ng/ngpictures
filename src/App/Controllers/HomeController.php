<?php 
namespace Ngpictures\Controllers;


use Ngpictures\Ngpic;

use Ngpictures\Util\Page;



class HomeController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('blog');
        $this->loadModel('articles');
    }

    public function index()
    {
        $article = $this->blog->last();
        $blog = $this->blog->orderBy('date_created', 'DESC', 0,5);
        $articles = $this->articles->orderBy('date_created', 'DESC', 0,3);
        $verse = $this->callController('verses')->index();

        Page::setName('Accueil | Ngpictures');
        $this->viewRender("home/index", compact('article','articles','blog','verse'));
    }
}
