<?php
namespace Ngpictures\Services\Auth;


use Ngpictures\Ngpictures;

class AuthService
{

    protected $str;
    protected $msg;
    protected $flash;
    protected $app;
    protected $session;
    protected $cookie;
    protected $validator;


    /**
     * AuthService constructor.
     * configure les dependances de l'application
     * necessaire aux interactions.
     * @param Ngpictures $app
     */
    public function __construct(Ngpictures $app)
    {
        $this->app = $app;
        $this->str = $this->app->getStr();
        $this->msg = $this->app->getMessageManager();
        $this->flash = $this->app->getFlash();
        $this->session = $this->app->getSession();
        $this->validator = $this->app->getValidator();
        $this->cookie = $this->app->getCookie();
    }
}