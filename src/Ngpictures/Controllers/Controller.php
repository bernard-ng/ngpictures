<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;
use Ng\Core\Controllers\Controller as SuperController;
use Ngpictures\Services\Auth\DatabaseAuthService;

/**
 * @property DatabaseAuthService authService
 */
class Controller extends SuperController
{
    protected $app;
    protected $str;
    protected $msg;
    protected $flash;
    protected $cookie;
    protected $layout;
    protected $session;
    protected $viewPath;
    protected $validator;
    protected $pageManager;
    protected $cacheBusting;


    /**
     * va construire le controller avec une instance de l'application
     * et du pagemanager, en tant que variable global
     *
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        $this->app              =   $app;
        $this->layout           =   'default';
        $this->viewPath         =   APP."/Views/";
        $this->pageManager      =   $pageManager;

        $this->str              =   $this->app->getStr();
        $this->msg              =   $this->app->getMessageManager();
        $this->flash            =   $this->app->getFlash();
        $this->cookie           =   $this->app->getCookie();
        $this->session          =   $this->app->getSession();
        $this->validator        =   $this->app->getValidator();
        $this->cacheBusting     =   $this->app->getCacheBusting();
        $this->authService = new DatabaseAuthService($this->app, $this->loadModel('users'));

        if(!$this->authService->isLogged()) {
            $this->authService->cookieConnect();
        }
    }


    /**
     * permet de rendre une vue
     *
     * @param string $view
     * @param array $variables
     * @param boolean $layout
     * @return void
     */
    public function viewRender(string $view, array $variables = [], bool $layout = true)
    {
        $variables['verse']                 =   $this->callController('verses')->index();
        $variables['pageManager']           =   $this->pageManager;
        $variables['sessionManager']        =   $this->session;
        $variables['flashMessageManager']   =   $this->flash;

        if ($this->authService->isLogged()) {
            $variables['activeUser']        =   $this->session->read(AUTH_KEY);
            $variables['securityToken']     =   $this->session->read(TOKEN_KEY);

            $this->pageManager::setMeta(['active-user' => $this->session->getValue(AUTH_KEY, 'id')]);
            $this->pageManager::setMeta(['active-token' => $this->session->read(TOKEN_KEY)]);
        } else {
            $variables['activeUser']        =   false;
            $variables['securityToken']     =   false;
        }

        parent::viewRender($view, $variables, $layout);
    }


    /**
     * charge un model
     * @param string|array $model
     * @return mixed|null
     */
    protected function loadModel($model)
    {
        if (is_string($model)) {
            return $this->$model = $this->app->getModel($model);
        } elseif (is_array($model)) {
            foreach ($model as $m) {
                $this->$m =  $this->app->getModel($m);
            }
        } else {
            return null;
        }
    }


    /**
     * fait appel a un controller dans un autre controller
     * @param string $name
     * @return mixed
     */
    protected function callController(string $name)
    {
        return $this->app->getController($name);
    }


    /**
     * definit un layout pour une vue
     * @param string $layout
     */
    protected function setLayout(string $layout)
    {
        $this->layout = $layout;
    }
}
