<?php
namespace Application\Controllers;

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
                if ($this->isAjax()) {
                    echo "S'abonner";
                    exit();
                }
                $this->flash->set("success", $this->flash->msg['users_unfollowing_success'], false);
                $this->redirect(true, false);
            }

            $model->add($user->id, $this->user->id);
            if ($this->isAjax()) {
                echo "Se désabonner";
                exit();
            }
            $this->flash->set("success", $this->flash->msg['users_following_success'], false);
            $this->redirect(true, false);
        } else {
            $this->flash->set("warning", $this->flash->msg['users_not_found']);
            $this->redirect(true, false);
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
        if ($this->authService->getToken() == $token) {
            $user = $this->authService->isLogged();
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
                $this->pageManager::setTitle("Mes Abonnés");
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
    public function showFollowing($token)
    {
        if ($this->authService->getToken() == $token) {
            $user =  $this->authService->isLogged();
            if ($user) {
                $followings         =   $this->following->findWith('follower_id', $user->id, false);
                $followings_list    =   [];

                foreach ($followings as $following) {
                    $followings_list[] = $following['followed_id'];
                }

                $followings_list    =   implode(", ", $followings_list);
                $followings         =   empty($followings_list)? null : $this->users->findList($followings_list);

                $this->turbolinksLocation("/my-following/{$token}");
                $this->pageManager::setTitle("Mes Abonnements");
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
