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
        $errors = [];

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('ideas', 'required');

            if ($this->validator->isValid()) {
                $content = $this->str::escape($post->get('ideas'));
                $user_id = $this->session->getValue(AUTH_KEY, 'id');

                $this->loadModel('ideas')->create(compact('content', 'user_id'));
                $this->flash->set('success', $this->msg['form_idea_submitted']);
                $this->app::redirect("/");
            } else {
                $errors = $this->validator->getErrors();
                $this->flash->set('danger', $this->msg['form_field_required']);
            }
        }

        $this->pageManager::setName("Donner une idée");
        $this->setLayout('users/default');
        $this->viewRender('front_end/others/ideas', compact('post', "errors"));
    }
}
