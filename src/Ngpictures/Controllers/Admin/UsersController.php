<?php
namespace Ngpictures\Controllers\Admin;


use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Controllers\PaginationTrait;

class UsersController extends AdminController
{

    /**
     * UsersController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('users');
    }

    use PaginationTrait;

    /**
     * gestion d'Managersisateur
     */
    public function index()
    {
        $users = $this->users->orderBy('id', 'DESC', 0, 10);
        $total = count($this->users->all());

        $pagination = $this->setPagination($total, "users");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $users = $pagination['result'] ?? $users;

        $this->pageManager::setName("Adm - users");
        $this->setLayout("admin/default");
        $this->viewRender(
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
                $this->flash->set('success', $this->flash->msg['admin_removed_admin']);
                $this->app::redirect(true);
            } else {
                $this->users->update($user->id, ['rank' => 'admin']);
                $this->flash->set('success', $this->flash->msg['admin_added_admin']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * gestion des bugs
     */
    public function bugs()
    {
        $bugs = $this->bugs->orderBy('id', 'DESC', 0, 10);
        $total = count($this->bugs->all());

        $pagination = $this->setPagination($total, "bugs");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $bugs = $pagination['result'] ?? $bugs;


        $this->pageManager::setName('Adm - bugs');
        $this->setLayout('admin/default');
        $this->viewRender(
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
        $total = count($this->ideas->all());

        $pagination = $this->setPagination($total, "ideas");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $ideas = $pagination['result'] ?? $ideas;

        $this->pageManager::setName('Adm - ideas');
        $this->setLayout('admin/default');
        $this->viewRender(
            'backend/users/ideas',
            compact('ideas', 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }
}
