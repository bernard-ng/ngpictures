<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ng\Core\Managers\Collection;
use Ngpictures\Managers\PageManager;


class NotificationsController extends Controller
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->authService->restrict();
        $this->loadModel('notifications');
    }


    /**
     * affiche les notifcation d'un user
     *
     * @param int $user_id
     * @param string $token
     * @return void
     */
    public function index(int $user_id, string $token)
    {
        if ($this->authService->getToken() == $token) {
            $nofications = $this->notifcation->findWith('users_id', $user_id, false);

            $this->app::turbolinksLocation("/nofications/{$user_id}/{$token}");
            $this->viewRender('frontend/users/account/notifications', compact('notifications'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * marque toutes les notifications commme lues
     *
     * @param integer $user_id
     * @param string $token
     * @return void
     */
    public function setRead(int $user_id, string $token)
    {

        if ($this->authService->getToken() == $token) {
            $this->notifications->setRead($user_id);
            $this->flash->set('success', $this->msg['success']);
            $this->app::redirect(true);
        } else {
            $this->isAjax()?
                $this->ajaxFail($this->msg['undefined_error']):
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
        }
    }


    /**
     * suppression de toutes les notifications
     */
    public function delete(int $user_id, string $token)
    {
        if ($this->authService->getToken() == $token) {
            if (isset($_POST) && !empty($_POST)) {
                $post = new Collection($_POST);

                if ($post->get('token') == $token) {
                    $this->notifications->delete($user_id);
                    $this->flash->set('success', $this->msg['success']);
                    $this->app::redirect(true);
                }
            }
        } else {
            $this->isAjax() ?
                $this->ajaxFail($this->msg['undefined_error']) :
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
        }
    }
}
