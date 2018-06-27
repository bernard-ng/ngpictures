<?php
namespace Ngpictures\Controllers;


use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;


class NotificationsController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
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

            $this->turbolinksLocation("/nofications/{$user_id}/{$token}");
            $this->viewRender('frontend/users/account/notifications', compact('notifications'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true);
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
            $this->flash->set('success', $this->flash->msg['success']);
            $this->redirect(true);
        } else {
            $this->isAjax()?
                $this->setFlash($this->flash->msg['undefined_error']):
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true);
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
                    $this->flash->set('success', $this->flash->msg['success']);
                    $this->redirect(true);
                }
            }
        } else {
            $this->isAjax() ?
                $this->setFlash($this->flash->msg['undefined_error']) :
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true);
        }
    }
}
