<?php
namespace Ngpic\Controller;
use Core\Generic\{Session,Collection};
use \Ngpic;


class LikesController extends NgpicController
{

    private $types = [ 1 => 'articles','galery','ngarticles','nggalery'];
    private $methods = [ 1 => 'like','dislike'];
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

    private function getMethod(int $m): string
    {
        $method = new Collection($this->methods);
        return $method->get($m);
    }

    public function index($slug, $id, $t, $m)
    {
        if ($this->session->getValue('auth','id') !== null) {

            $like = $this->LoadModel('likes');
            $dislike = $this->LoadModel('dislikes');
            $post = $this->LoadModel($this->getType($t))->find(floor($id));

            switch ($this->getMethod(floor($m))) {
                case 'like' :
                    if ($post) { 
                        if ($like->isLiked($post->id, $t, $this->user_id)) {
                            $like->remove($post->id, $t, $this->user_id);
                        } elseif ($dislike->isDisliked($post->id, $t, $this->user_id)) {
                            $dislike->remove($post->id, $t, $this->user_id); 
                            $like->add($post->id, $t, $this->user_id);
                        } else {
                            $like->add($post->id, $t, $this->user_id);
                        }
                    }
                    Ngpic::redirect(true);
                break;

                case 'dislike' :
                    if ($post) {    
                        if ($dislike->isDisliked($post->id, $t, $this->user_id)) {
                            $dislike->remove($post->id, $t, $this->user_id);
                        } elseif ($like->isLiked($post->id, $t, $this->user_id)) {
                            $like->remove($post->id, $t, $this->user_id);
                            $dislike->add($post->id, $t, $this->user_id);
                        } else {
                            $dislike->add($post->id, $t, $this->user_id);
                        }
                    }                   
                    Ngpic::redirect(true);
                break;

                default :
                    Ngpic::redirect("/error-500");
                break;
            }
        } else {
            $this->session->setFlash("warning","connecter vous ou crée un compte pour effectuer cette action");
            Ngpic::redirect(true);
        }
    }

    public function show(string $slug, int $id)
    {
        Ngpic::setPageName('Les mentions | Ngpictures');
        $this->setTemplate('features/default');
        $this->viewRender('features/mentions');
    }
}
