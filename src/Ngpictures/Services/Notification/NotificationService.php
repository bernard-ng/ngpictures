<?php
namespace Ngpictures\Services\Notification;

use Ngpictures\Ngpictures;
use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Util\ResolverTrait;


class NotificationService
{

    use ResolverTrait;

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
     *
     * @param Ngpictures $app
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->users = $this->get($this->model('users'));
        $this->notifications = $this->get($this->model('notifications'));
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
     * ajoute une nofication
     *
     * @param integer $type
     * @param string $text
     * @param integer $to
     * @return void
     */
    private function add(int $type, string $text, int $to) {
        $nofications = $this->app->getModel('notifications');
        $nofications->add($type, $text, $to);
    }


    /**
     * genere le text de la notification
     *
     * @param int $type
     * @return void
     */
    private function generateNotification(int $type, $post, $liker_name) {

        $subject = "{$liker_name} a ";

        switch($type) {
            case 1 :
                $action = "ajouté une nouvelle photo ";
                break;
            case 2 :
                $action = "aimé votre publication ";
                break;
            case 3 :
                $action = "commenté votre publication";
                break;
            case 4 :
                $action = "ajouté une publication sur le blog";
                break;
            case 5 :
                $action = "ajouté une photo dans la gallery";
                break;
            case 6 :
                $action = "commencé a vous suivre";
                break;
        }


        $complement = $post->name ?? $post->title ?? ".";
        if ($complement != '.') {
            $nofication = $subject . $action . ": \"{$complement}\"";
        } else {
            $nofication = $subject . $action . '.';
        }


        if (!$this->alreadyNotified($type, $nofication, $post->users_id)) {
            $this->notifications->add($type, $nofication, $post->users_id);
        }
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

        if(is_object($sendTo)) {
            if ($sendTo->id == $liker_id) {
                return false;
            }
            return $this->generateNotification(2, $post, $liker_name, $sendTo->id);
        }
        return false;
    }


    /**
     * notifie ce qui suis, celui qui a postE
     *
     * @param object $post
     * @param sstring $commentaire
     * @return void
     */
    public function newPost($post, string $commentaire)
    {

    }
}
