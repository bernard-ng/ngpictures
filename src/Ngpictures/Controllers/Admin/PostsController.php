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
        $posts = $this->posts->orderBy('id', 'DESC', 0, 10);
        $total = count($this->posts->all());

        $pagination = $this->setPagination($total, "posts");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $posts = $pagination['result'] ?? $posts;


        $this->pageManager::setName('Adm - posts');
        $this->setLayout("Admin/default");
        $this->viewRender(
            "backend/posts/index",
            compact("posts", 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }
}
