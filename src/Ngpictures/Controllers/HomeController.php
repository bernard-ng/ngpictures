<?php
namespace Application\Controllers;

use Psr\Container\ContainerInterface;
use Application\Traits\Util\ResolverTrait;

class HomeController extends Controller
{
    /**
     * homepage
     *
     * @return void
     */
    public function index()
    {
        $last           =   $this->loadModel('gallery')->latest();
        $article        =   $this->loadModel('blog')->last();
        $categories     =   $this->loadModel('categories')->orderBy('title', 'DESC', 0, 10);
        $sliderTitle    =   ["Deep Shooting", "Find it", "Discover More", "Share feelings"];
        $sliderDesc     =   [
            "Faites vos réservations shooting, trouvez le photographes idéal pour vous.",
            "Trouver la photo que vous avez besoin pour vos fond d'écrans, affiche et autres",
            "Découvrez la version 2.0 de ngpictures et toutes les nouvelles fonctionnalités.",
            "Partager vos photos avec les passionnés de la photographie et le reste du monde."
        ];

        $this->turbolinksLocation("/");
        $this->pageManager::setTitle('Ngpictures');
        $this->view(
            "frontend/index",
            compact('last', 'article', 'categories', 'sliderTitle', 'sliderDesc')
        );
    }
}
