<?php
namespace Ngpictures\Controllers\Admin;

use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class UsersController extends AdminController
{
    use PaginationTrait;


    /**
     * gestion d'Managersisateur
     */
    public function index()
    {
        $users = $this->users->orderBy('id', 'DESC', 0, 10);
        $total = $this->users->countAll()->num;

        $pagination     = $this->setPagination($total, "users");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $users          = $pagination['result'] ?? $users;

        $this->turbolinksLocation(ADMIN."/users");
        $this->pageManager::setName("Adm - users");
        $this->view(
            "backend/users/index",
            compact('users', 'bugs', 'ideas', 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }


    /**
     * gestion des permissions
     * @param integer $id
     */
    public function permissions($id)
    {
        $user = $this->users->find(intval($id));
        if ($user && $user->confirmed_at !== null) {
            if ($user->rank === "admin") {
                $this->users->update($user->id, ['rank' => 'user']);
                $this->flash->set('success', $this->flash->msg['admin_removed_admin'], false);
                $this->redirect(true, false);
            } else {
                $this->users->update($user->id, ['rank' => 'admin']);
                $this->flash->set('success', $this->flash->msg['admin_added_admin'], false);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }


    /**
     * gestion des bugs
     */
    public function bugs()
    {
        $bugs   = $this->bugs->orderBy('id', 'DESC', 0, 10);
        $total  = $this->bugs->countAll()->num;

        $pagination     = $this->setPagination($total, "bugs");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $bugs           = $pagination['result'] ?? $bugs;

        $this->turbolinksLocation(ADMIN.'/bugs');
        $this->pageManager::setName('Adm - bugs');
        $this->view(
            'backend/users/bugs',
            compact('bugs', 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }


    /**
     * gestion des ideas
     */
    public function ideas()
    {
        $ideas = $this->ideas->orderBy('id', 'DESC', 0, 10);
        $total = $this->ideas->countAll()->num;

        $pagination     = $this->setPagination($total, "ideas");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $ideas          = $pagination['result'] ?? $ideas;

        $this->turbolinksLocation(ADMIN.'/ideas');
        $this->pageManager::setName('Adm - ideas');
        $this->view(
            'backend/users/ideas',
            compact('ideas', 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }
}
