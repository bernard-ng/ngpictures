<?php

namespace Ngpictures\Controllers;


use Ng\Core\Generic\Collection;
use Ngpictures\Util\Page;

class IdeasController extends  NgpicController
{

    public function __construct()
    {
        parent::__construct();
        $this->callController('users')->restrict();
        $this->loadModel('ideas');
    }


    public function index()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('ideas'))) {
                $content = $this->str::escape($post->get('ideas'));
                $user_id = $this->session->getValue('auth', 'id');
                $this->loadModel('ideas')->create(compact('content', 'user_id'));
                $this->flash->set('success', $this->msg['admin_ideas_success']);
            } else {
                $this->flash->set('danger', $this->msg['admin_all_fields']);
            }
        }

        Page::setName("Donner une idée | Ngpictures");
        $this->setLayout('users/default');
        $this->viewRender('others/ideas', compact('post'));
    }
}