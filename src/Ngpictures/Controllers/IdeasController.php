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
        $this->authService->restrict();
        $this->loadModel('ideas');
        $this->app::turbolinksLocation("/ideas");
    }


    /**
     * getion d'idee
     */
    public function index()
    {
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('ideas', 'required');

            if ($this->validator->isValid()) {
                $content    =   $this->str::escape($post->get('ideas'));
                $users_id    =    $this->session->getValue(AUTH_KEY, 'id');

                $this->loadModel('ideas')->create(compact('content', 'users_id'));
                $this->flash->set('success', $this->msg['form_idea_submitted']);

                if ($this->isAjax()) {
                    $this->ajaxRedirect('/');
                }

                $this->app::redirect("/");
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->isAjax() ?
                    $this->ajaxFail(json_encode($errors->asArray()), 403) :
                    $this->flash->set('danger', $this->msg['form_field_required']);
            }
        }

        $this->app::turbolinksLocation("/ideas");
        $this->pageManager::setName("Donner une idée");
        $this->setLayout('users/default');
        $this->viewRender('front_end/others/ideas', compact('post', "errors"));
    }
}
