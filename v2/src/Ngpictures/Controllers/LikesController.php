<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Util\TypesActionTrait;
use Ngpictures\Services\Notification\NotificationService;

class LikesController extends Controller
{

    use TypesActionTrait;
    private $user;

    /**
     * LikesController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->user = $this->authService->isLogged();
    }


    /**
     * @param string $type
     * @param string $slug
     * @param int $id
     */
    public function index($type, $slug, $id)
    {
        $like       = $this->loadModel('likes');
        $post       = $this->loadModel($this->getAction($type))->find(intval($id));
        $notifier   = $this->container->get(NotificationService::class);

        if ($post && $post->slug === $slug) {
            if ($like->isLiked($post->id, $type, $this->user->id)) {
                $like->remove($post->id, $type, $this->user->id);
                if ($this->isAjax()) {
                    echo $post->likes;
                    exit();
                } else {
                    $this->flash->set('success', $this->flash->msg['post_like_remove']);
                    $this->redirect(true, false);
                }
            } else {
                $like->add($post->id, $type, $this->user->id);
                $notifier->notify(2, [$post, $this->user->id]);

                if ($this->isAjax()) {
                    echo $post->likes;
                    exit();
                } else {
                    $this->flash->set('success', $this->flash->msg['post_like_add']);
                    $this->redirect(true, false);
                }
            }
        } else {
            $this->flash->set("danger", $this->flash->msg['post_not_found']);
            $this->redirect(true, false);
        }
    }


    /**
     * show likers
     *
     * @param string $type
     * @param string $slug
     * @param integer $id
     * @return void
     */
    public function show(string $type, string $slug, int $id)
    {
        $post = $this->loadModel($this->getAction($type))->find(intval($id));

        if ($post && $post->slug === $slug) {
            $likes      =   $this->loadModel('likes');
            $likers     =  (new Collection($likes->getLikers($id, $type)))->asList();

            if (!empty($likers)) {
                $likers = $this->loadModel('users')->findList($likers);

                $this->turbolinksLocation("/likes/show/{$type}/{$slug}-{$id}");
                $this->pageManager::setTitle("Mentions j'aime");
                $this->view("frontend/posts/likers", compact("likers"));
            } else {
                $this->flash->set('info', $this->flash->msg['post_not_liked']);
                $this->redirect(true);
            }
        }
    }
}
