<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class FollowingController extends Controller
{

    /**
     * l'id du user qui va suivre une autr personne
     * @var int|null
     */
    private $user_id = null;

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->callController('users')->restrict();
        $this->user_id = intval($this->session->getValue(AUTH_KEY, 'id'));
    }


    public function index($username, $id)
    {
        $f = $this->LoadModel('following');
        $user = $this->loadModel('users')->find($id);

        if ($user) {
            if ($f->isFollowed($user->id, $this->user_id)) {
                $f->remove($user->id, $this->user_id);

                $this->flash->set("success", $this->msg['user_remove_following_success']);
                $this->app::redirect(true);
            }
            $f->add($user->id, $this->user_id);
            $this->flash->set("success", $this->msg['user_add_following_success']);
            $this->app::redirect(true);
        } else {
            $this->flash->set("warning", $this->msg['user_notFound']);
            $this->app::redirect(true);
        }
    }



    /**
     * renvoi "active" si on suis un user
     * @param $id
     * @return string
     */
    public function isMentionnedFollow($id)
    {
        $f = $this->loadModel('following');
        if ($f->isFollowed($id, $this->app::getInstance()->getSession()->getValue(AUTH_KEY, 'id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}
