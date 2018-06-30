<?php
namespace Ngpictures\Controllers\Admin;


use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class PostsController extends AdminController
{
    use PaginationTrait;

    public function index()
    {
        $posts = $this->posts->orderBy('id', 'DESC', 0, 10);
        $total = $this->posts->countAll()->num;

        $pagination     = $this->setPagination($total, "posts");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $posts          = $pagination['result'] ?? $posts;


        $this->turbolinksLocation(ADMIN.'/posts');
        $this->pageManager::setName('Adm - posts');
        $this->view(
            "backend/posts/index",
            compact("posts", 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }
}
