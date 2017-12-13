<?php
namespace Ngpictures\Controllers;


use Ngpictures\Ngpic;
use Ngpictures\Util\Page;


class ArticlesController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('articles');
        $this->loadModel('categories');
    }

    


    public function index()
    {
        $articles = $this->articles->lastOnline();
        $verse = $this->callController('verses')->index();
        $categories = $this->categories->orderBy('title', 'ASC', 0, 5);

        Page::setName('Actualités | Ngpictures');
        Page::setMeta(['property' => 'og:url', 'content' => '//larytech.com/articles']);
        
        $this->setLayout("articles/default");
        $this->viewRender("articles/index", compact('articles', 'verse', 'categories'));
    }



    public function show(string $slug, int $id, string $page = null)
    {
        if ($id !== null) {
            $article = $this->articles->find($id);

            if ($article && $article->slug === $slug) {
                Page::setName("$article->title | Ngpictures"); 
                $this->viewRender("articles/show", compact('article'));
            } else {
                Ngpic::redirect('/e404');
            }
        } else {
            $this->index();
        }
    }



    public function edit(sting $slug, int $id, string $token)
    {
        if ($slug || $id || $user_id || $token !== null) {
            $article = $this->articles->find($id);
            if ($article && $article->slug === $slug) {


                Page::setName('Edition | Ngpictures');
                $this->setLayout("articles/default");
                $this->viewRender("articles/edit");
            } 
        }
        
    }



    public function post()
    {
        if ($this->session->read("Auth") !== null) {

            Page::setName('Publication | Ngpictures');
            $this->setLayout("articles/default");
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