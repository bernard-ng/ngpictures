<?php
namespace Ngpictures\Controllers;

class ErrorController extends Controller
{
    
    public function e404()
    {
        $this->pageManager::setName("Erreur 404");
        $this->viewRender("front_end/error/404");
    }

    public function e500()
    {
        $this->pageManager::setName("Erreur 500");
        $this->viewRender("front_end/error/500");
    }
}
