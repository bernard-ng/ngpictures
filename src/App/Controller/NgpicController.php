<?php
namespace Ngpic\Controller;

use Core\Controller\Controller;
use \Ngpic;



class NgpicController extends Controller
{
    protected   $viewPath,
                $template,
                $session,
                $cookie,
                $str,
                $validator;

    public function __construct()
    {
        $this->viewPath = APP."/Views/";
        $this->template = 'default';
        $Ngpic = Ngpic::getInstance();

        $this->session = $Ngpic->getSession();
        $this->cookie = $Ngpic->getCookie();
        $this->str = $Ngpic->getStr();
        $this->validator = $Ngpic->getValidator();
    }


    protected function loadModel($model)
    {
        $Ngpic = Ngpic::getInstance();
        if (is_string($model)) {
            return $this->$model = $Ngpic->getModel($model);
        } elseif (is_array($model)) {
            foreach ($model as $m) {
                $this->$m =  $Ngpic->getModel($m);
            }
        } else {
            return null;
        }
    }

    protected function callController(string $name)
    {
        return Ngpic::getInstance()->getController($name);
    }


    protected function setTemplate(string $template)
    {
        $this->template = $template;
    }
}
