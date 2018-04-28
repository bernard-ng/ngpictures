<?php
namespace Ngpictures\Traits\Controllers;

trait ShowPostTrait
{

    /**
     * affiche une publication
     *
     * @param string $slug
     * @param integer $id
     * @return void
     */
    public function show(string $slug, int $id)
    {
        if (!empty($slug) && !empty($id)) {
            $user       =   $this->loadModel('users');
            $article    =   $this->loadModel($this->table)->find(intval($id));
            $comments   =   $this->loadModel('comments')->findWith($this->table."_id", $id, false);


            if ($article) {
                if ($article->slug === $slug) {
                    $this->pageManager::setName("{$article->title}");

                    $this->setLayout("posts/show");
                    $this->viewRender(
                        "front_end/{$this->table}/show",
                        compact("article", "comments", "user")
                    );
                } else {
                    $this->flash->set("danger", $this->msg['posts_not_found']);
                    $this->app::redirect("/error-404");
                }
            } else {
                $this->flash->set("danger", $this->msg['posts_not_found']);
                $this->app::redirect("/error-404");
            }
        } else {
            $this->flash->set("danger", $this->msg['undefined_error']);
            $this->index();
        }
    }
}
