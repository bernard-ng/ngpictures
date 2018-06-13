<?php
namespace Ngpictures\Controllers;

class ErrorController extends Controller
{

    /**
     * page introuvable, erreur 404
     */
    public function e404()
    {
        $this->app::turbolinksLocation('/error/not-found');
        $this->setLayout('blank');
        $this->pageManager::setName("404 Page Introuvable");
        $this->viewRender("frontend/error/404");
    }


    /**
     * page d'erreur 500
     */
    public function e500()
    {
        $this->app::turbolinksLocation('/error/internal');
        $this->setLayout('blank');
        $this->pageManager::setName("500 Erreur interne");
        $this->viewRender("frontend/error/500");
    }
}
