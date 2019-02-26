<?php
namespace Application\Controllers\Admin;

use Application\Managers\PageManager;
use Psr\Container\ContainerInterface;
use Application\Controllers\AdminController;
use Application\Traits\Controllers\PaginationTrait;

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
        PageManager::setTitle('Adm - posts');
        $this->view(
            "backend/posts/index",
            compact("posts", 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }
}
