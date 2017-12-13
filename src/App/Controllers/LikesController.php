<?php
namespace Ngpictures\Controllers;


use Ng\Core\Generic\{Session,Collection};
use Ng\Core\Generic\Flash;
use Ngpictures\Ngpic;


class LikesController extends NgpicController
{

    private $types = [ 1 => 'articles','gallery','blog','ngGallery'];
    private $user_id = null;

    public function __construct(){
        parent::__construct();
        $this->callController('users')->restrict();
        $this->user_id = intval($this->session->getValue('auth','id'));
    }

    private function getType(int $t): string
    {
        $model = new Collection($this->types);
        return $model->get($t);
    }

    public function index($t, $slug, $id)
    {
        if ($this->session->getValue('auth','id') !== null) {

            $like = $this->LoadModel('likes');
            $post = $this->LoadModel($this->getType($t))->find(floor($id));

            if ($post && $post->slug === $slug) { 
                if ($like->isLiked($post->id, $t, $this->user_id)) {
                    $like->remove($post->id, $t, $this->user_id);

                    Ngpic::redirect(true);
                } else {
                    $like->add($post->id, $t, $this->user_id);
                    Ngpic::redirect(true);
                }
            } else {
                Ngpic::redirect(true);
                $this->flash->set("danger",$this->msg['undefined_error']);    
            }  
        } else {
            $this->flash->set("warning", $this->msg['user_must_login']);
            Ngpic::redirect(true);
        }
    }

    public function show(string $slug, int $id)
    {
        Page::setName('Les mentions | Ngpictures');
        $this->setLayout('features/default');
        $this->viewRender('features/mentions');
    }
}
