<?php
namespace Ngpictures\Controllers;

class ErrorController extends Controller
{

    /**
     * page introuvable, erreur 404
     */
    public function e404()
    {
        $this->turbolinksLocation('/error/not-found');
        $this->pageManager::setName("404 Page Introuvable");
        $this->view("frontend/error/404");
    }


    /**
     * page d'erreur 500
     */
    public function e500()
    {
        $this->turbolinksLocation('/error/internal');
        $this->pageManager::setName("500 Erreur interne");
        $this->view("frontend/error/500");
    }
}
