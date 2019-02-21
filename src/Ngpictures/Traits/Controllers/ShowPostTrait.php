<?php
namespace Application\Traits\Controllers;

trait ShowPostTrait
{

    /**
     * affiche une publication
     *
     * @param string $slug
     * @param integer $id
     * @return void
     */
    public function show($slug,$id)
    {
        if (!empty($slug) && !empty($id)) {
            $id         =   intval($id);
            $user       =   $this->loadModel('users');
            $article    =   $this->loadModel($this->table)->find(intval($id));

            $comments           =   $this->loadModel('comments');
            $commentsNumber     = $comments->count($id, $this->table."_id")->num;
            $comments           = $comments->get($id, $this->table."_id", 0, 4);


            $categories =   $this->loadModel('categories')->orderBy('title', 'ASC', 0, 5);

            if ($article && $article->slug === $slug) {
                if ($article->online == 1) {
                    $similars = $this->loadModel($this->table)->findSimilars($article->id);
                    $author = $this->loadModel('users')->find($article->users_id);
                    $altName = $this->table . " - publication - " . $article->id;

                    $this->turbolinksLocation("/{$this->table}/{$slug}-{$id}");
                    $this->pageManager::setTitle($article->title ?? $altName);
                    $this->pageManager::setDescription($article->snipet);
                    $this->pageManager::setImage($article->smallThumbUrl);
                    
                    $this->view(
                        "frontend/{$this->table}/show",
                        compact("article", "comments", "commentsNumber", "user", "categories", "author", "similars")
                    );
                } else {
                    $this->flash->set("warning", $this->flash->msg['post_private'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set("danger", $this->flash->msg['post_not_found'], false);
                http_response_code(404);
                $this->redirect(true);
            }
        } else {
            $this->flash->set("danger", $this->flash->msg['undefined_error'], false);
            $this->index();
        }
    }
}
