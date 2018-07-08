<?php
namespace Ngpictures\Traits\Controllers;


trait StoryPostTrait
{
    /**
     * list les articles
     *
     * @return void
     */
    public function index()
    {
        $posts      =   $this->loadModel($this->table)->all();
        $categories =   $this->loadModel('categories')->all();
        $title      =   ucfirst($this->table);
        $name       =   ($this->table == 'posts') ? "Fil d'actualité" : ucfirst($this->table);

        $this->turbolinksLocation("/".$this->table);
        $this->pageManager::setTitle($name);
        $this->pageManager::setDescription("
            Découvez les photos et les articles des passionnés de la photographie, partager vos photos avec la
            communauté.
        ");
        $this->pageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table]);
        $this->view("frontend/{$title}/index", compact("posts", "categories"));
    }
}
