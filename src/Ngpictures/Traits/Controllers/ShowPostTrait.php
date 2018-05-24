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
            $categories =   $this->loadModel('categories')->all();


            if ($article) {
                if ($article->slug === $slug) {
                    $this->pageManager::setName("{$article->title}");

                    $this->app::turbolinksLocation("{$slug}-{$id}");
                    $this->setLayout("show");
                    $this->viewRender(
                        "front_end/{$this->table}/show",
                        compact("article", "comments", "user", "categories")
                    );
                } else {
                    $this->flash->set("danger", $this->msg['posts_not_found']);
                    $this->app::redirect("error/not-found");
                }
            } else {
                $this->flash->set("danger", $this->msg['posts_not_found']);
                $this->app::redirect("error/not-found");
            }
        } else {
            $this->flash->set("danger", $this->msg['undefined_error']);
            $this->index();
        }
    }
}
