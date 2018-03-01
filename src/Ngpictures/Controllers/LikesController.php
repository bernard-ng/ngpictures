<?php
namespace Ngpictures\Controllers;

use Ngpictures\Traits\Util\TypesActionTrait;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class LikesController extends Controller
{

    use TypesActionTrait;

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->callController('users')->restrict();
        $this->user_id = intval($this->session->getValue(AUTH_KEY, 'id'));
    }

    public function index(string $type, string $slug, int $id)
    {
        $like = $this->loadModel('likes');
        $post = $this->loadModel($this->getType($type))->find(intval($id));

        if ($post && $post->slug === $slug) {
            if ($like->isLiked($post->id, $type, $this->user_id)) {
                $like->remove($post->id, $type, $this->user_id);
                echo ($this->isAjax()) ? $post->likes : $this->app::redirect(true);
            } else {
                $like->add($post->id, $type, $this->user_id);
                echo ($this->isAjax()) ? $post->likes : $this->app::redirect(true);
            }
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['undefined_error']);
            }
            $this->flash->set("danger", $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    public function show(string $type, string $slug, int $id)
    {
        $post = $this->loadModel($this->getType($type))->find(intval($id));

        if ($post && $post->slug === $slug) {
            $likes = $this->loadModel('likes');
            $likers = $likes->getLikers($id, $type);

            $likers_list = [];
            foreach($likers as $liker) {
                $likers_list[] = $liker['user_id'];
            }

            $likers_list = implode(", ", $likers_list);
            $likers = $this->loadModel('users')->findList($likers_list);

            $this->pageManager::setName("Mentions j'aime");
            $this->setLayout("posts/default");
            $this->viewRender("front_end/posts/likers", compact("likers"));
        }
    }
}
