<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ngpictures\Traits\Util\TypesActionTrait;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class LikesController extends Controller
{

    use TypesActionTrait;
    private $user;

    /**
     * LikesController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
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
                    $this->app::redirect(true);
                }
            } else {
                $like->add($post->id, $type, $this->user->id);
                $this->notificationService->notify(2, [$post, $this->user->id]);

                if ($this->isAjax()) {
                    echo $post->likes;
                } else {
                    $this->app::redirect(true);
                }
            }
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->flash->msg['post_not_found']);
            }
            $this->flash->set("danger", $this->flash->msg['post_not_found']);
            $this->app::redirect(true);
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

                $this->app::turbolinksLocation("/likes/show/{$type}/{$slug}-{$id}");
                $this->pageManager::setName("Mentions j'aime");
                $this->setLayout("posts/default");
                $this->viewRender("frontend/posts/likers", compact("likers"));
            } else {
                $this->flash->set('info', $this->flash->msg['post_not_liked']);
                $this->app::redirect(true);
            }
        }
    }
}
