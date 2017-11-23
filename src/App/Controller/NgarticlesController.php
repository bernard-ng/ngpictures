<?php
namespace Ngpic\Controller;
use \Ngpic;

class NgarticlesController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('ngarticles');
        $this->loadModel('comments');
    }

    public function index()
    {
        $articles = $this->ngarticles->orderBy('date_created','DESC');
        $verse = $this->callController('verses')->index();
        Ngpic::setPageName('Blog | Ngpictures');
        
        $this->setTemplate("articles/default");
        $this->viewRender("ngarticles/index",compact('articles','verse'));
    }

    public function show(string $slug, int $id, string $page = null)
    {
        if ($id !== null) {
            $article = $this->ngarticles->find($id);
            $verse = $this->callController('verses')->index();
            $user = $this->loadModel('users');
            $comments = $this->comments->findWith('ngarticles', $id);
            $nb_comment = $this->comments->count('ngarticles', $id);
            $session = $this->session;

            if ($article) {
                if ($article->slug === $slug) {
                    Ngpic::setPageName("$article->title | Ngpictures");
                    $this->setTemplate('articles/show');
                    $this->viewRender("ngarticles/show", compact(
                        'article','verse','nb_comment',"comments","user",
                        "session"
                    ));
                } else {
                    Ngpic::redirect('/e404');
                }
            } else {
                Ngpic::redirect('/e404');
            }
        } else {
            $this->index();
        }
    }



    

}