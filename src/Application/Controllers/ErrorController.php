<?php
namespace Application\Controllers;

use Application\Managers\PageManager;

class ErrorController extends Controller
{

    /**
     * page introuvable, erreur 404
     */
    public function e404()
    {
        http_response_code(404);
        $this->turbolinksLocation('/error/not-found');
        PageManager::setTitle("404 Page Introuvable");
        $this->view("frontend/error/404");
    }


    /**
     * page d'erreur 500
     */
    public function e500()
    {
        $this->turbolinksLocation('/error/internal');
        PageManager::setTitle("500 Erreur interne");
        $this->view("frontend/error/500");
    }
}
