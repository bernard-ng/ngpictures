<?php
namespace Ngpictures\Traits\Controllers;

use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;

trait ShowPostTrait
{

    /**
    * affichage d'un article
    */
    public function show($slug, $id)
    {
        if (!empty($slug) && !empty($id)) {
            $article = $this->loadModel($this->table)->find(intval($id));
            $verse = $this->callController("verses")->index();

            $user = $this->loadModel('users');
            $comments = $this->loadModel('comments')->findWith($this->table, $id, false);

            $session = $this->session;

            if ($article) {
                if ($article->slug === $slug) {
                    PageManager::setName("{$article->title}");
                    PageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table.'/'."{$article->SI}"]);

                    $this->setLayout("articles/show");
                    $this->viewRender(
                        "front_end/{$this->table}/show",
                        compact("article", "verse", "comments", "user", "session")
                    );
                } else {
                    Ngpictures::redirect("/error-404");
                }
            } else {
                Ngpictures::redirect("/error-404");
            }
        } else {
            $this->flash->set("danger", $this->msg['indefined_error']);
            $this->index();
        }
    }
}
