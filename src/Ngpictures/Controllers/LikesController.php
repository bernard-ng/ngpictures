<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;
use Ngpictures\Traits\Util\TypesActionTrait;


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
    public function index(string $type, string $slug, int $id)
    {
        $like   =   $this->loadModel('likes');
        $post   =   $this->loadModel($this->getAction($type))->find(intval($id));

        if ($post && $post->slug === $slug) {
            if ($like->isLiked($post->id, $type, $this->user->id)) {
                $like->remove($post->id, $type, $this->user->id);
                if ($this->isAjax()) {
                    echo $post->likes;
                } else {
                    $this->redirect(true);
                }
            } else {
                $like->add($post->id, $type, $this->user->id);
                $this->notificationService->notify(2, [$post, $this->user->id]);

                if ($this->isAjax()) {
                    echo $post->likes;
                } else {
                    $this->redirect(true);
                }
            }
        } else {
            if ($this->isAjax()) {
                $this->setFlash($this->flash->msg['post_not_found']);
            }
            $this->flash->set("danger", $this->flash->msg['post_not_found']);
            $this->redirect(true);
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
                $this->pageManager::setName("Mentions j'aime");
                $this->view("frontend/posts/likers", compact("likers"));
            } else {
                $this->flash->set('info', $this->flash->msg['post_not_liked']);
                $this->redirect(true);
            }
        }
    }
}
