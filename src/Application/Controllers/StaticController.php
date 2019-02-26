<?php
namespace Application\Controllers;

use Application\Managers\PageManager;

class StaticController extends Controller
{
    /**
     * la page d'about
     */
    public function about()
    {
        $this->turbolinksLocation("/about");
        PageManager::setTitle("A Propos de nous");
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
        PageManager::setTitle("Aucune Connexion Internet");
        $this->view('frontend/others/offline');
    }


    /**
     * privacy terms
     */
    public function privacy()
    {
        $this->turbolinksLocation("/privacy");
        $categories = $this->loadRepository('categories')->orderBy('title', 'ASC', 0, 5);
        PageManager::setTitle("Politique d'utilisation");
        PageManager::setDescription(
            'La présente clause a pour objet de définir les différents termes essentiels du contrat'
        );
        $this->view("frontend/others/privacy", compact('categories'));
    }
}
