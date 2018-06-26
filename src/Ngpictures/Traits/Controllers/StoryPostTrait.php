<?php
namespace Ngpictures\Traits\Controllers;

use Ngpictures\Models\CategoriesModel;
use Ngpictures\Traits\Util\ResolverTrait;

trait StoryPostTrait
{

    use ResolverTrait;

    /**
     * list les articles
     *
     * @return void
     */
    public function index()
    {
        $posts      =   $this->container->get($this->model($this->table))->all();
        $categories =   $this->container->get(CategoriesModel::class)->all();
        $title      =   ucfirst($this->table);

        $this->app::turbolinksLocation("/".$this->table);
        $this->pageManager::setName(ucfirst($this->table));
        $this->pageManager::setMeta(['property' => 'og:url', 'content' => '//larytech.com/'.$this->table]);
        $this->viewRender("frontend/{$title}/index", compact("posts", "categories"));
    }
}
