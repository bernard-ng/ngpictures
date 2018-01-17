<?php
namespace Ngpictures\Controllers;


use Ngpictures\Ngpictures;
use Ngpictures\Traits\Util\TypesActionTrait;


class LikesController extends NgpicController
{

    use TypesActionTrait;

    public function __construct(){
        parent::__construct();
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
                echo ($this->isAjax()) ? $post->likes : Ngpictures::redirect(true);
            } else {
                $like->add($post->id, $type, $this->user_id);
                echo ($this->isAjax()) ? $post->likes : Ngpictures::redirect(true);
            }
        } else {
            if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
            $this->flash->set("danger", $this->msg['indefined_error']);
            Ngpictures::redirect(true);
        } 
    }
}
