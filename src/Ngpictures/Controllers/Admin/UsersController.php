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
        $users = $this->users->all();
        $user = $this->users->last();
        $this->pageManager::setName("Adm - users");
        $this->setLayout("admin/default");
        $this->viewRender("backend/users/index", compact('users', 'user', 'bugs', 'ideas'));
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
                $this->flash->set('success', $this->msg['admin_removed_admin']);
                $this->app::redirect(true);
            } else {
                $this->users->update($user->id, ['rank' => 'admin']);
                $this->flash->set('success', $this->msg['admin_added_admin']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * gestion des bugs
     */
    public function bugs()
    {
        $bugs = $this->bugs->all();
        $this->pageManager::setName('Adm - bugs');
        $this->setLayout('admin/default');
        $this->viewRender('backend/users/bugs', compact('bugs'));
    }


    /**
     * gestion des ideas
     */
    public function ideas()
    {
        $ideas = $this->ideas->all();
        $this->pageManager::setName('Adm - ideas');
        $this->setLayout('admin/default');
        $this->viewRender('backend/users/ideas', compact('ideas'));
    }
}
