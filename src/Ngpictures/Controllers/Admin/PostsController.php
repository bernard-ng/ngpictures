<?php
namespace Ngpictures\Controllers\Admin;


use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class PostsController extends AdminController
{


    /**
     * PostsController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
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
        $this->viewRender(
            "backend/posts/index",
            compact("posts", 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }
}
