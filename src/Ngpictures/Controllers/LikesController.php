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

    public function index($type, $slug, $id)
    {
        $like = $this->loadModel('likes');
        $post = $this->loadModel($this->getType($type))->find(floor($id));

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
                $this->ajaxFail($this->msg['indefined_error']);
            }
            $this->flash->set("danger", $this->msg['indefined_error']);
            $this->app::redirect(true);
        }
    }
}
