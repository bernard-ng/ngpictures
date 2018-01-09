<?php
namespace Ngpictures\Traits;

use Ngpictures\Util\Page;
use Ngpictures\Ngpic;


trait ShowPostTrait {

	/**
    * affichage d'un article
    */
    public function show($slug, $id)
    {
        if (is_string($slug) && !empty($slug) && !empty($id)) {
            $article = $this->loadModel($this->table)->find(intval($id));
            $verse = $this->callController("verses")->index();

            $user = $this->loadModel('users');
            $comments = $this->loadModel('comments')->findWith($this->table, $id);
            $session = $this->session;

            if ($article) {
                if ($article->slug === $slug) {

                    Page::setName("$article->title | Ngpictures");
                    Page::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table.'/'."{$article->SI}"]);

                    $this->setLayout("articles/show");
                    $this->viewRender("{$this->table}/show", 
                        compact(
                            "article","verse","comments","user","session"
                        )
                    );
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