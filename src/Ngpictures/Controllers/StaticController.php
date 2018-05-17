<?php
namespace Ngpictures\Controllers;


class StaticController extends Controller
{
    /**
     * la page d'about
     */
    public function about()
    {
        $this->app::turbolinksLocation("/about");
        $this->setLayout("posts/default");
        $this->pageManager::setName("A Propos de nous");
        $this->viewRender('front_end/others/about');
    }


    /**
     * privacy terms
     */
    public function privacy()
    {
        $this->app::turbolinksLocation("/privacy");
        $this->setLayout("posts/default");
        $this->pageManager::setName("Politique d'utilisation");
        $this->pageManager::setDescription(
            'La présente clause a pour objet de définir les différents termes essentiels du contrat'
        );
        $this->viewRender("front_end/others/privacy");
    }

}
