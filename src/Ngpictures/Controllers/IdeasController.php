<?php

namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class IdeasController extends Controller
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
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
                $this->flash->set('success', $this->msg['form_idea_submitted']);
            } else {
                $this->flash->set('danger', $this->msg['form_fied_required']);
            }
        }

        $this->pageManager::setName("Donner une idée");
        $this->setLayout('users/default');
        $this->viewRender('front_end/others/ideas', compact('post'));
    }
}
