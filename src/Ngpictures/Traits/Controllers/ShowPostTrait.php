<?php
namespace Ngpictures\Traits\Controllers;


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
                    $this->pageManager::setName("{$article->title}");

                    $this->setLayout("posts/show");
                    $this->viewRender(
                        "front_end/{$this->table}/show",
                        compact("article", "verse", "comments", "user", "session")
                    );
                } else {
                   $this->app::redirect("/error-404");
                }
            } else {
               $this->app::redirect("/error-404");
            }
        } else {
            $this->flash->set("danger", $this->msg['undefined_error']);
            $this->index();
        }
    }
}
