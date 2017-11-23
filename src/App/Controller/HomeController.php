<?php 
namespace Ngpic\Controller;
use \Ngpic;

class HomeController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('ngarticles');
    }

    public function index()
    {
        $article = $this->ngarticles->last();
        $verse = $this->callController('verses')->index();

        Ngpic::setPageName('Accueil | Ngpictures');
        $this->viewRender("home/index",compact('article','verse'));
    }
}
