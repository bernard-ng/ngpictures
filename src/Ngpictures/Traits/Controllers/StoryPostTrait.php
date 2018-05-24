<?php
namespace Ngpictures\Traits\Controllers;

use Ngpictures\Managers\PageManager;

trait StoryPostTrait
{

    /**
     * list les articles
     *
     * @return void
     */
    public function index()
    {
        $last       =   $this->loadModel('gallery')->latest(1, 3);
        $posts      =   $this->loadModel($this->table)->latest();
        $categories =   $this->loadModel('categories')->all();
        $title      =   ucfirst($this->table);

        $this->app::turbolinksLocation("/".$this->table);
        $this->pageManager::setName(ucfirst($this->table));
        $this->pageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table]);

        $this->setLayout("posts/default");
        $this->viewRender("front_end/{$title}/index", compact("posts", "categories", 'last'));
    }
}
