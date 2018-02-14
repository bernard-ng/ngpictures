<?php
namespace Ngpictures\Traits\Controllers;

use Ngpictures\Managers\PageManager;

trait StoryPostTrait
{

    public function index()
    {
        $posts = $this->loadModel($this->table)->latest();
        $last = $this->loadModel('gallery')->latest(1, 3);
        $verse = $this->callController("verses")->index();
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC', 0, 5);
        
        PageManager::setName("$this->table");
        PageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table]);

        $this->setLayout("posts/default");
        $this->viewRender("front_end/{$this->table}/index", compact("posts", "verse", "categories", 'last'));
    }
}
