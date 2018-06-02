<?php
namespace Ngpictures\Controllers\Admin;


use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Controllers\PaginationTrait;

class PostsController extends AdminController
{


    /**
     * PostsController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('posts');
    }

    use PaginationTrait;

    public function index()
    {
        $posts = $this->posts->orderBy('id', 'DESC');
        $article = $this->posts->last();
        $this->pageManager::setName('Adm - posts');
        $this->setLayout("Admin/default");
        $this->viewRender("back_end/posts/index", compact("posts", "article"));
    }
}