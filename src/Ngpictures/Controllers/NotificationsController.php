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
    public function show($user_id, $token)
    {
        if ($this->authService->getToken() == $token) {
            $notifications = $this->notifications->findWith('users_id', $user_id, false);
            return $notifications;
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
    public function clear($token)
    {
        if ($this->authService->getToken() == $token) {
            $this->notifications->setRead(intval($this->authService->isLogged()->id));

            $this->turbolinksLocation("/my-notifications/clear/{$token}");
            $this->flash->set('success', $this->flash->msg['success']);
            $this->redirect(true);
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }


    /**
     * suppression de toutes les notifications
     */
    public function delete($token)
    {
        if ($this->authService->getToken() == $token) {
            $this->notifications->delete(intval($this->authService->isLogged()->id));

            $this->turbolinksLocation("/my-notifications/delete/{$token}");
            $this->flash->set('success', $this->flash->msg['success'], false);
            $this->redirect(true, false);
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }
}
