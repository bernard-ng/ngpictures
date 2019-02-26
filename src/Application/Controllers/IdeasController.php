<?php

namespace Application\Controllers;

use Framework\Managers\Collection;
use Application\Managers\PageManager;
use Psr\Container\ContainerInterface;

class IdeasController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->loadModel('ideas');
        $this->turbolinksLocation("/ideas");
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
                $content     =   $this->str->escape($post->get('ideas'));
                $users_id    =    $this->authService->isLogged()->id;

                $this->loadModel('ideas')->create(compact('content', 'users_id'));
                $this->flash->set('success', $this->flash->msg['form_idea_submitted'], false);
                $this->redirect("/", true);
            } else {
                $this->sendFormError();
            }
        }

        $this->turbolinksLocation("/ideas");
        PageManager::setTitle("Donner une idée");
        $this->view('frontend/others/ideas', compact('post', "errors"));
    }
}
