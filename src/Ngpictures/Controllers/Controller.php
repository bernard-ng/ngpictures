<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;
use Ng\Core\Controllers\Controller as SuperController;

class Controller extends SuperController
{
    protected $viewPath;
    protected $layout;
    protected $session;
    protected $pageManager;
    protected $cookie;
    protected $str;
    protected $msg;
    protected $validator;
    protected $app;

   
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        $this->viewPath = APP."/Views/";
        $this->layout = 'default';

        $this->app = $app;
        $this->pageManager = $pageManager;

        $this->session = $this->app->getSession();
        $this->cookie = $this->app->getCookie();
        $this->str = $this->app->getStr();
        $this->validator = $this->app->getValidator();
        $this->flash = $this->app->getFlash();
        $this->msg = $this->app->getMessageManager();
    }

    
    public function viewRender(string $view, array $variables = [], bool $layout = true)
    {
        $variables['pageManager'] = $this->pageManager;
        $variables['sessionManager'] = $this->session;
        $variables['flashMessageManager'] = $this->flash;

        if (!empty($this->session->read(AUTH_KEY))) {
            $variables['securityToken'] = $this->session->read(TOKEN_KEY);
            $variables['activeUser'] = $this->session->read(AUTH_KEY);
        } else {
            $variables['securityToken'] = false;
            $variables['activeUser'] = false;
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
