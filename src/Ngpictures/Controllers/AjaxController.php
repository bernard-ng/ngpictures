<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;

class AjaxController extends Controller
{
    //ajout d'article infinite scroll
    public function posts()
    {
        if ($this->isAjax()) {
            $post = new Collection($_POST);

            if ($post->has('lastId')) {
                $result = $this->loadModel('posts')->findLess($post->get('lastId'));
                require(APP."/Views/ajax/posts/cards.php");
                exit();
            } else {
                $this->ajaxFail($this->msg['undefined_error']);
            }
        } else {
            $this->flash->set("warning", $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    // infinite scroll pour le blog
    public function blog()
    {
        if ($this->isAjax()) {
            $post = new Collection($_POST);
            if ($post->has('lastId')) {
                $result = $this->loadModel('blog')->findLess($post->get('lastId'));
                require(APP."/Views/ajax/blog/cards.php");
                exit();
            } else {
                $this->ajaxFail($this->msg['undefined_error']);
            }
        } else {
            $this->flash->set("warning", $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    public function verset()
    {
        $verse = $this->callController('verses')->index();
        require(APP."/Views/ajax/verset.php");
    }
}
