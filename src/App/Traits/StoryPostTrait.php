<?php
namespace Ngpictures\Traits;

use Ngpictures\Ngpic;
use Ngpictures\Util\Page;

trait StoryPostTrait {
	
	public function index()
	{
	    $articles = $this->loadModel($this->table)->latest();
	    $last = $this->loadModel('gallery')->latest();
	    $verse = $this->callController("verses")->index();
	    $categories = $this->loadModel('categories')->orderBy('title','ASC', 0, 5);
	    
	    Page::setName("$this->table | Ngpictures");
	    Page::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table]);

	    $this->setLayout("articles/default");
	    $this->viewRender("{$this->table}/index", compact("articles","verse","categories",'last'));
	}
}
