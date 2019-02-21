<?php
namespace Ngpictures\Services\Notification;

use Ngpictures\Models\UsersModel;
use Ng\Core\Managers\StringManager;
use Psr\Container\ContainerInterface;
use Ngpictures\Models\NotificationsModel;
use Ngpictures\Models\FollowingModel;

class NotificationService
{


    private $users;
    private $nofications;

    /**
     * les diff type de notifications
     *
     * @var array
     */
    private $actionRegister = [
        1 => 'newPost',
        'newLike',
        'newComment',
        'newBlog',
        'newGallery',
        'newFollower'
    ];


    /**
     * NotificationService Constructor
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container        = $container;
        $this->users            = $this->container->get(UsersModel::class);
        $this->notifications    = $this->container->get(NotificationsModel::class);
    }


    /**
     * notificaton proprement dite
     *
     * @param string $action
     * @param array $args
     * @return void
     */
    public function notify(string $action, array $args)
    {
        if (array_key_exists($action, $this->actionRegister) && method_exists($this, $this->actionRegister[$action])) {
            return call_user_func_array([$this, $this->actionRegister[$action]], $args);
        } else {
            throw new \InvalidArgumentException("method $action is not defined in $this");
        }
    }


    /**
     * genere le text de la notification
     *
     * @param int $type
     * @return void
     */
    private function generateNotification(int $type, $post, $user, $data = null)
    {
        $subject = "{$user} a ";

        switch ($type) {
            case 1:
                $action = "ajouté une nouvelle photo";
                break;
            case 2:
                $action = "aimé votre publication";
                break;
            case 3:
                $action = "commenté votre publication";
                break;
            case 4:
                $action = "ajouté une publication sur le blog";
                break;
            case 5:
                $action = "ajouté une photo dans la gallery";
                break;
            case 6:
                $action = "commencé a vous suivre";
                break;
        }


        $complement = $post->name ?? $post->title ?? ".";
        $nofication = ($complement != '.')?
            $subject . $action . " : « {$complement} »" :
            $subject . $action . '.';

        if ($type === 3) {
            $data = $this->container->get(StringManager::class)->truncate($data, 50);
            $nofication = $subject . $action . " : « {$data} »";
            $this->notifications->add($type, $nofication, $post->users_id, $post->id);
            return true;
        } elseif ($type === 1) {
            foreach ($data as $follower_id) {
                $this->notifications->add($type, $nofication, $follower_id, $post->id);
            }
            return true;
        }

        if (!$this->alreadyNotified($type, $nofication, $post->users_id)) {
            $this->notifications->add($type, $nofication, $post->users_id, $post->id);
            return true;
        }
        return false;
    }


    /**
     * avons nous deja notifier une personne ?
     * ceci pour eviter une mm notification plusieur fois
     *
     * @param int $type
     * @param string $nofication
     * @param int $sendTo
     * @return boolean
     */
    public function alreadyNotified(int $type, string $nofication, int $sendTo): bool
    {
        return $this->notifications->hasNotification($type, $nofication, $sendTo);
    }



    //-------------------------------------------------------------------------------------------------------------


    /**
     * notifie un nouveau like
     *
     * @param integer $post_id
     * @param integer $liker_id
     * @return void
     */
    private function newLike($post, int $liker_id)
    {
        $sendTo = $this->users->find($post->users_id);
        $liker_name = $this->users->find($liker_id)->name;

        if (is_object($sendTo)) {
            if ($sendTo->id == $liker_id) {
                return false;
            }
            return $this->generateNotification(2, $post, $liker_name);
        }
        return false;
    }


    /**
     * notifie un nouveau like
     *
     * @param integer $post_id
     * @param integer $liker_id
     * @return void
     */
    private function newComment($post, $cmter_id, $comment)
    {
        $sendTo     = $this->users->find($post->users_id);
        $cmtr_name  = $this->users->find($cmter_id)->name;

        if (is_object($sendTo)) {
            if ($sendTo->id == $cmter_id) {
                return false;
            }
            return $this->generateNotification(3, $post, $cmtr_name, $comment);
        }
        return false;
    }


    /**
     * notifie ce qui suis, celui qui a postE
     *
     * @param object $post
     * @param string $commentaire
     * @return void
     */
    public function newPost($post)
    {
        $followers_list     = [];
        $poster_name        = $this->users->find($post->users_id)->name;
        $followers = $this
            ->container
            ->get(FollowingModel::class)
            ->findWith('followed_id', $post->users_id, false);

        foreach ($followers as $follower) {
            if ($post->users_id !== $follower['follower_id']) {
                $followers_list[] = $follower['follower_id'];
            }
        }

        return $this->generateNotification(1, $post, $poster_name, $followers_list);
    }
}
