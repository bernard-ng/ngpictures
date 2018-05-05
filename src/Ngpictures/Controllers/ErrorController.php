<?php
namespace Ngpictures\Controllers;

class ErrorController extends Controller
{

    /**
     * page introuvable, erreur 404
     */
    public function e404()
    {
        $this->app::turbolinksLocation('error-404');
        $this->pageManager::setName("Erreur 404");
        $this->viewRender("front_end/error/404");
    }


    /**
     * page d'erreur 500
     */
    public function e500()
    {
        $this->app::turbolinksLocation('error-500');
        $this->pageManager::setName("Erreur 500");
        $this->viewRender("front_end/error/500");
    }
}
