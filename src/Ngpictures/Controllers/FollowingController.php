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


    public function index(string $username, int $id)
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

                if (empty($followers_list)) {
                    $followers = null;
                } else {
                    $followers = $this->users->findList($followers_list);
                }

                $this->pageManager::setName("Mes Abonnés");
                $this->setLayout("posts/default");
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


    public function showFollowing(string $name, int $id, string $token)
    {
        if ($this->session->read(TOKEN_KEY) == $token) {
            $user =  $this->users->find(intval($id));
            if ($user) {
                $followings = $this->following->findWith('follower_id', $user->id, false);
                $followings_list = [];

                foreach ($followings as $following) {
                    $followings_list[] = $following['followed_id'];
                }
                $followings_list = implode(", ", $followings_list);

                if (empty($followings_list)) {
                    $followings = null;
                } else {
                    $followings = $this->users->findList($followings_list);
                }

                $this->pageManager::setName("Mes Abonnements");
                $this->setLayout("posts/default");
                $this->viewRender("front_end/users/account/following", compact("followings"));
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}
