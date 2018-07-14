<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;

class CommunityController extends Controller
{

    /**
     * page de community
     */
    public function index()
    {
        $this->authService->restrict();
        $this->loadModel("users");
        $users = $this->users->lastConfirmed();

        $this->turbolinksLocation('/community');
        $this->pageManager::setTitle("Communauté");
        $this->pageManager::setDescription(
            "Rétrouvez la communauté de ngpictures, vos amis, les artistes et les passionnés
            de la photographie"
        );
        $this->view("frontend/community/community", compact('users'));
    }


    public function search()
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $query = trim($this->str->escape($_GET['q']));

            $users = $this->loadModel('users')->search($query);
            $this->turbolinksLocation("/community/search?q={$query}");
            $this->pageManager::setTitle("Recherches");
            $this->view("frontend/community/search", compact("query", "users"));
        } else {
            $this->turbolinksLocation("/community/search");
            $this->pageManager::setTitle("Recherches");
            $this->view("frontend/community/search");
        }
    }
}
