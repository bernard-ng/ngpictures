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
        $this->viewRender('frontend/others/about');
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
        $this->viewRender("frontend/others/privacy", compact('categories'));
    }
}
