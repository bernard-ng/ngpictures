<?php
namespace Ngpictures\Controllers;


use Ng\Core\Generic\Collection;
use Ngpictures\Util\Page;


class BugsController extends NgpicController
{

    /**
     * BugsController constructor.
     * oblige un user a se connecter pour effectuer l'action
     */
    public function __construct()
    {
    	parent::__construct();
    	$this->callController('users')->restrict();
    	$this->loadModel('bugs');
    }


    /**
     * permet de signaler un bug
     */
    public function index()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('bugs'))) {
                $content = $this->str::escape($post->get('bugs'));
                $user_id = $this->session->getValue('auth', 'id');
                $this->loadModel('bugs')->create(compact('content', 'user_id'));
                $this->flash->set('success', $this->msg['admin_ideas_success']);
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName("Signaler un Bug | Ngpictures");
        $this->setLayout('users/default');
        $this->viewRender('others/bugs', compact('post'));
    }
}
