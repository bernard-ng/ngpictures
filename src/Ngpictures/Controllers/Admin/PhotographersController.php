<?php
namespace Ngpictures\Controllers\Admin;

use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class PhotographersController extends AdminController
{
    use PaginationTrait;

    /**
     * list les differents photographers
     * un album poura contenir des photo de n'importe quel categorie
     */
    public function index()
    {
        $photographers = $this->photographers->orderBy('id', 'DESC', 0, 10);
        $total = $this->photographers->countAll()->num;

        $pagination = $this->setPagination($total, "photographers");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $photographers = $pagination['result'] ?? $photographers;

        $this->pageManager::setTitle('admin gallery.album');
        $this->view(
            'backend/photographers/index',
            compact('photographers', "currentPage", 'totalPage', 'prevPage', 'nextPage', 'total')
        );
    }
}
