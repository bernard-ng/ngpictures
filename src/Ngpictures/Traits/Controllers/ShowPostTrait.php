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
            $categories =   $this->loadModel('categories')->orderBy('title', 'ASC', 0, 5);


            if ($article) {
                if ($article->slug === $slug) {
                    $similars = $this->loadModel($this->table)->findSimilars($article->id);
                    $author = $this->loadModel('users')->find($article->users_id);
                    $this->pageManager::setName("{$article->title}");

                    $this->app::turbolinksLocation("/{$this->table}/{$slug}-{$id}");
                    $this->setLayout("show");
                    $this->viewRender(
                        "frontend/{$this->table}/show",
                        compact("article", "comments", "user", "categories", "author", "similars")
                    );
                } else {
                    $this->flash->set("danger", $this->msg['post_not_found']);
                    http_response_code(404);
                    $this->app::redirect("/error/not-found");
                }
            } else {
                $this->flash->set("danger", $this->msg['post_not_found']);
                http_response_code(404);
                $this->app::redirect("/error/not-found");
            }
        } else {
            $this->flash->set("danger", $this->msg['undefined_error']);
            $this->index();
        }
    }
}
