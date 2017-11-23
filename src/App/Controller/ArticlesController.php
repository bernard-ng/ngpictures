<?php
namespace Ngpic\Controller;
use \Ngpic;


class ArticlesController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('articles');
    }

    
    public function index()
    {
        $articles = $this->articles->orderBy('date_created','DESC');
        $verse = $this->callController('verses')->index();
        Ngpic::setPageName('Actualités | Ngpictures');
        $this->setTemplate("articles/default");
        $this->viewRender("articles/index", compact('articles','verse'));
    }

    public function show(string $slug, int $id, string $page = null)
    {
        if ($id !== null) {
            $article = $this->articles->find($id);

            if ($article && $article->slug === $slug) {
                Ngpic::setPageName("$article->title | Ngpictures"); 
                $this->viewRender("articles/show", compact('article'));
            } else {
                Ngpic::redirect('/e404');
            }
        } else {
            $this->index();
        }
    }

    public function edit(sting $slug, int $id, int $user_id, string $token)
    {
        if ($slug || $id || $user_id || $token !== null) {
            $article = $this->articles->find($id);
            if ($article && $article->slug === $slug) {


                Ngpic::setPageName('Edition | Ngpictures');
                $this->setTemplate("articles/default");
                $this->viewRender("articles/edit");
            } 
        }
        
    }

    public function post()
    {
        if ($this->session->read("Auth") !== null) {

            Ngpic::setPageName('Publication | Ngpictures');
            $this->setTemplate("articles/default");
            $this->viewRender("articles/post");
        } else {
            $this->session->setFlash("Warning","Vous devez vous connecter avant de publier");
            Ngpic::redirect('/login');
            exit();    
        }
        
    }

    public function delete()
    {
        
    }

    

}