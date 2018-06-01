<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Util\TypesActionTrait;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class LikesController extends Controller
{

    use TypesActionTrait;

    /**
     * LikesController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->callController('users')->restrict();
        $this->users_id = intval($this->session->getValue(AUTH_KEY, 'id'));
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
            if ($like->isLiked($post->id, $type, $this->users_id)) {
                $like->remove($post->id, $type, $this->users_id);
                if ($this->isAjax()) {
                    echo $post->likes;
                } else {
                    $this->app::redirect(true);
                }
            } else {
                $like->add($post->id, $type, $this->users_id);
                if ($this->isAjax()) {
                    echo $post->likes;
                } else {
                    $this->app::redirect(true);
                }
            }
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['undefined_error']);
            }
            $this->flash->set("danger", $this->msg['undefined_error']);
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
            $likers     =   $likes->getLikers($id, $type);

            $likers_list = [];
            foreach ($likers as $liker) {
                $likers_list[] = $liker['users_id'];
            }

            $likers_list = implode(", ", $likers_list);
            if (!empty($likers_list)) {
                $likers = $this->loadModel('users')->findList($likers_list);

                $this->app::turbolinksLocation("/likes/show/{$type}/{$slug}-{$id}");
                $this->pageManager::setName("Mentions j'aime");
                $this->setLayout("posts/default");
                $this->viewRender("front_end/posts/likers", compact("likers"));
            } else {
                $this->flash->set('info', $this->msg['post_not_liked']);
                $this->app::redirect(true);
            }
        }
    }
}
