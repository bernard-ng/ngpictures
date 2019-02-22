<?php
namespace Ngpictures\Controllers\Admin;

use Ng\Core\Managers\Collection;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Traits\Util\TypesActionTrait;
use Ngpictures\Traits\Controllers\PaginationTrait;

class ReportsController extends AdminController
{

    use PaginationTrait;

    /**
     * list les differents signalement de publication
     */
    public function index()
    {
        $reports = $this->reports->orderBy('id', 'DESC', 0, 10);
        $total = $this->reports->countAll()->num;

        $pagination = $this->setPagination($total, "reports");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $reports = $pagination['result'] ?? $reports;

        PageManager::setTitle('admin gallery.album');
        $this->view(
            'backend/reports',
            compact('reports', "currentPage", 'totalPage', 'prevPage', 'nextPage', 'total')
        );
    }
}
