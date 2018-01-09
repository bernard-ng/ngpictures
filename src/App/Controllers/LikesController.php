<?php
namespace Ngpictures\Controllers;


use Ng\Core\Generic\Collection;
use Ngpictures\Ngpic;


class LikesController extends NgpicController
{
    private $types = [ 1 => 'articles','gallery','blog'];
    private $user_id = null;

    public function __construct(){
        parent::__construct();
        $this->callController('users')->restrict();
        $this->user_id = intval($this->session->getValue(AUTH_KEY, 'id'));
    }

    private function getType(int $type): string
    {
        $model = new Collection($this->types);
        return $model->get($type);
    }

    public function index($t, $slug, $id)
    {
        $like = $this->loadModel('likes');
        $post = $this->loadModel($this->getType($type))->find(floor($id));

        if ($post && $post->slug === $slug) { 
            if ($like->isLiked($post->id, $t, $this->user_id)) {
                $like->remove($post->id, $t, $this->user_id);
                echo ($this->isAjax()) ? $post->likes : Ngpic::redirect(true);
            } else {
                $like->add($post->id, $t, $this->user_id);
                echo ($this->isAjax()) ? $post->likes : Ngpic::redirect(true);
            }
        } else {
            if ($this->isAjax()) $this->ajaxFail($this->msg['indefined_error']);
            $this->flash->set("danger", $this->msg['indefined_error']);
            Ngpic::redirect(true);
        } 
    }
}
