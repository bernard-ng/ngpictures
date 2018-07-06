<?php
namespace Ngpictures\Controllers;

class StaticController extends Controller
{
    /**
     * la page d'about
     */
    public function about()
    {
        $this->turbolinksLocation("/about");
        $this->pageManager::setName("A Propos de nous");
        $this->view('frontend/others/about');
    }


    /**
     * genere une page pour dire aux user
     * qu'il est offline.
     *
     * @return void
     */
    public function offline()
    {
        $this->turbolinksLocation("/app.offline");
        $this->pageManager::setName("Aucune Connexion Internet");
        $this->view('frontend/others/offline');
    }


    /**
     * privacy terms
     */
    public function privacy()
    {
        $this->turbolinksLocation("/privacy");
        $categories = $this->loadModel('categories')->orderBy('title', 'ASC', 0, 5);
        $this->pageManager::setName("Politique d'utilisation");
        $this->pageManager::setDescription(
            'La présente clause a pour objet de définir les différents termes essentiels du contrat'
        );
        $this->view("frontend/others/privacy", compact('categories'));
    }
}
