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
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
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

        $this->pageManager::setName("Signaler un Bug");
        $this->setLayout('users/default');
        $this->viewRender('front_end/others/bugs', compact('post'));
    }
}
