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
        $this->loadModel('gallery');
    }

    public function index()
    {
        $last = $this->blog->latest(0,3);
        $photos = $this->gallery->latest(0,6);
        $categories = $this->categories->orderBy('title','ASC',0,5);
        $verse = $this->callController('verses')->index();

        Page::setName('Accueil | Ngpictures');
        Page::setMeta(['property' => 'og:url', 'content' => '//larytech.com/home']);
        $this->setLayout("blank");
        $this->viewRender("production/index", compact('photos','last','blog','verse','categories'));
    }
}
