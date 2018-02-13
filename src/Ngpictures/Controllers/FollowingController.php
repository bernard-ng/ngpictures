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
        $this->loadModel(['users', 'following']);
        $this->user_id = intval($this->session->getValue(AUTH_KEY, 'id'));
    }


    public function index($username, $id)
    {
        $f = $this->following;
        $user = $this->loadModel('users')->find(intval($id));

        if ($user) {
            if ($f->isFollowed($user->id, $this->user_id)) {
                $f->remove($user->id, $this->user_id);

                $this->flash->set("success", $this->msg['users_unfollowing_success']);
                $this->app::redirect(true);
            }

            $f->add($user->id, $this->user_id);
            $this->flash->set("success", $this->msg['users_following_success']);
            $this->app::redirect(true);
        } else {
            $this->flash->set("warning", $this->msg['users_not_found']);
            $this->app::redirect(true);
        }
    }


    public function showFollowers(string $name, int $id, string $token)
    {
       if ($this->session->read(TOKEN_KEY) == $token) {
        $user =  $this->users->find(intval($id));
            if ($user) {
                $followers = $this->following->findWith('followed_id', $user->id, false);

                $followers_list = [];
                foreach ($followers as $follower) {
                    $followers_list[] = $follower['follower_id'];
                }

                $followers_list = implode(", ", $followers_list);
                $followers = $this->users->findList($followers_list);

                $this->pageManager::setName("Mes Abonnés");
                $this->setLayout("articles/default");
                $this->viewRender("front_end/users/account/followers", compact("followers"));
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
           $this->flash->set('danger', $this->msg['undefined_error']);
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
        if ($f->isFollowed($id, $this->user_id)) {
            return 'active';
        } else {
            return '';
        }
    }
}
