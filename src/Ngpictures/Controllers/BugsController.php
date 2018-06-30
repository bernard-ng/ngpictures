<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;

class BugsController extends Controller
{

    /**
     * BugsController constructor.
     * oblige un user a se connecter pour effectuer l'action
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->loadModel('bugs');
        $this->turbolinksLocation("/bugs");
    }


    /**
     * permet de signaler un bug
     */
    public function index()
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('bugs', "required");

            if ($this->validator->isValid()) {
                $content = $this->str::escape($post->get('bugs'));
                $users_id = $this->session->getValue('auth', 'id');

                $this->loadModel('bugs')->create(compact('content', 'users_id'));
                $this->flash->set('success', $this->flash->msg['form_bug_submitted'], false);
                $this->redirect("/home", false);
            } else {
               $this->sendFormError();
            }
        }

        $this->turbolinksLocation("/bugs");
        $this->pageManager::setName("Signaler un Bug");
        $this->view('frontend/others/bugs', compact('post', "errors"));
    }
}
