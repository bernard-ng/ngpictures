<?php
namespace Application\Controllers;

use Application\Managers\PageManager;

class StaticController extends Controller
{

    public function about()
    {
        $this->turbolinksLocation("/about");
        PageManager::setTitle("A Propos de nous");
        $this->view('frontend/others/about');
    }

    public function offline()
    {
        $this->turbolinksLocation("/app.offline");
        PageManager::setTitle("Aucune Connexion Internet");
        $this->view('frontend/others/offline');
    }

    public function privacy()
    {
        $this->turbolinksLocation($this->url('privacy'));
        PageManager::setTitle("Conditions Générales d'utilisation");
        PageManager::setDescription(
            "Les présentes « conditions générales d'utilisation » ont pour objet l'encadrement 
            juridique des modalités de mise à disposition des services du site Ngpictures"
        );
        $this->view("frontend/others/privacy");
    }
}
