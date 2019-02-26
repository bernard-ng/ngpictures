<?php
namespace Application\Traits\Controllers;

trait PaginationTrait
{
    public function setPagination(int $total, string $action)
    {
        $currentPage = 1;
        $totalPage = ceil($total / 10);

        if (isset($_GET['page']) && !empty($_GET['page']) && $_GET['page'] > 0) {
            $page = $this->str->escape($_GET['page']);
            if ($page <= $totalPage) {
                $currentPage = $page;
                $result = $this->$action->orderBy('id', 'DESC', ($currentPage - 1) * 10, 10);
            } else {
                $this->flash->set('danger', "Page {$page} inéxistante");
                $this->redirect(ADMIN."/{$action}");
            }
        }

        $prevPage = ($currentPage - 1 <= 0)? 1 : $currentPage - 1;
        $nextPage = ($currentPage + 1 > $totalPage)? $totalPage : $currentPage + 1;

        return [
            'currentPage' => $currentPage ?? 1,
            'totalPage' => $totalPage,
            'prevPage' =>  $prevPage,
            'nextPage' => $nextPage,
            'result' => $result ?? null
        ];
    }
}
