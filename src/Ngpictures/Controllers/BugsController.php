<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class BugsController extends Controller
{

    /**
     * BugsController constructor.
     * oblige un user a se connecter pour effectuer l'action
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->callController('users')->restrict();
        $this->loadModel('bugs');
        $this->app::turbolinksLocation("bugs");
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
                $this->flash->set('success', $this->msg['form_bug_submitted']);

                if ($this->isAjax()) {
                    $this->ajaxRedirect('/');
                }

                $this->app::redirect("/home");
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->isAjax() ?
                    $this->ajaxFail(json_encode($errors->asArray()), 403) :
                    $this->flash->set('danger', $this->msg['form_field_required']);
            }
        }

        $this->app::turbolinksLocation("/bugs");
        $this->pageManager::setName("Signaler un Bug");
        $this->setLayout('users/default');
        $this->viewRender('front_end/others/bugs', compact('post', "errors"));
    }
}
