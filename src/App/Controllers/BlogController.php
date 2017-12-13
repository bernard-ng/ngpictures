<?php
namespace Ngpictures\Controllers;


use Ngpictures\Ngpic;

use Ngpictures\Util\Page;


class BlogController extends NgpicController
{
    public function __construct()
    {
        parent::__construct();
        $this->loadModel("blog");
        $this->loadModel("users");
        $this->loadModel("comments");
        $this->loadModel("categories");
    }

    public function index()
    {
        $articles = $this->blog->lastOnline();
        $verse = $this->callController("verses")->index();
        $categories = $this->categories->orderBy('title','ASC', 0, 5);
        
        Page::setName("Blog | Ngpictures");
        Page::setMeta(['property' => 'og:url', 'content' => '//larytech.com/blog']);

        $this->setLayout("articles/default");
        $this->viewRender("blog/index", compact("articles","verse","categories"));
    }

    public function show($slug, $id)
    {
        if (is_string($slug) && !empty($slug) && !empty($id)) {
            $article = $this->blog->find(intval($id));
            $verse = $this->callController("verses")->index();

            $user = $this->users;
            $comments = $this->comments->findWith("blog", $id);
            $session = $this->session;

            if ($article) {
                if ($article->slug === $slug) {
                    Page::setName("$article->title | Ngpictures");
                    $this->setLayout("articles/show");
                    $this->viewRender("blog/show", compact(
                        "article","verse","nb_comment","comments","user","session"
                    ));
                } else {
                    Ngpic::redirect("/e404");
                }
            } else {
                Ngpic::redirect("/e404");
            }
        } else {
            $this->flash->set("danger", $this->msg['indefined_error']);
            $this->index();
        }
    }


}
