<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;

class FollowingController extends Controller
{

    private $user;


    /**
     * FollowingController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->user = $this->authService->isLogged();
        $this->loadModel(['users', 'following']);

        var_dump($this->following->getFollowers(5)); die();
    }


    /**
     * following system
     *
     * @param string $username
     * @param integer $id
     * @return void
     */
    public function index(string $username, int $id)
    {
        $model = $this->following;
        $user = $this->loadModel('users')->find(intval($id));

        if ($user) {
            if ($model->isFollowed($user->id, $this->user->id)) {
                $model->remove($user->id, $this->user->id);
                $this->flash->set("success", $this->flash->msg['users_unfollowing_success']);
                $this->redirect(true);
            }

            $model->add($user->id, $this->user->id);
            $this->flash->set("success", $this->flash->msg['users_following_success']);
            $this->redirect(true);
        } else {
            $this->flash->set("warning", $this->flash->msg['users_not_found']);
            $this->redirect(true);
        }
    }


    /**
     * show followers
     *
     * @param string $token
     * @return void
     */
    public function showFollowers(string $token)
    {
        if ($this->session->read(TOKEN_KEY) == $token) {
            $user = $this->session->read(AUTH_KEY);
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

                $this->turbolinksLocation("/my-followers/{$token}");
                $this->pageManager::setName("Mes Abonnés");
                $this->view("frontend/users/account/followers", compact("followers"));
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    /**
     * show following
     *
     * @param string $name
     * @param integer $id
     * @param string $token
     * @return void
     */
    public function showFollowing(string $token)
    {
        if ($this->session->read(TOKEN_KEY) == $token) {
            $user =  $this->session->read(AUTH_KEY);
            if ($user) {
                $followings         =   $this->following->findWith('follower_id', $user->id, false);
                $followings_list    =   [];

                foreach ($followings as $following) {
                    $followings_list[] = $following['followed_id'];
                }

                $followings_list    =   implode(", ", $followings_list);
                $followings         =   empty($followings_list)? null : $this->users->findList($followings_list);

                $this->turbolinksLocation("/my-following/{$token}");
                $this->pageManager::setName("Mes Abonnements");
                $this->view("frontend/users/account/following", compact("followings"));
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }
}
