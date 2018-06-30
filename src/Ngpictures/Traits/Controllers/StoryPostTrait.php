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

        $this->turbolinksLocation("/".$this->table);
        $this->pageManager::setName(ucfirst($this->table));
        $this->pageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table]);
        $this->view("frontend/{$title}/index", compact("posts", "categories"));
    }
}
