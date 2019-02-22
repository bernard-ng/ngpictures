<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ngpictures\Managers\PageManager;
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
        $users = $this->users->get(10);

        $this->turbolinksLocation('/community');
        PageManager::setTitle("Communauté");
        PageManager::setDescription(
            "Rétrouvez la communauté de ngpictures, vos amis, les artistes et les passionnés
            de la photographie"
        );
        $this->view("frontend/community/community", compact('users'));
    }


    public function photographers()
    {
        $this->authService->restrict();
        $this->loadModel("users");
        $photographers = $this->loadModel('photographers')->get(8);
        $photographers = (new Collection($photographers))->asList(', ', "users_id");
        $users = $this->users->findList($photographers);

        $this->turbolinksLocation('/community/photographers');
        PageManager::setTitle("Photographers");
        PageManager::setDescription(
            "Rétrouvez la communauté de ngpictures, vos amis, les artistes et les passionnés
            de la photographie"
        );
        $this->view("frontend/community/photographers", compact('users'));
    }


    public function search()
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $query = trim($this->str->escape($_GET['q']));

            $users = $this->loadModel('users')->search($query);
            $this->turbolinksLocation("/community/search?q={$query}");
            PageManager::setTitle("Recherches");
            $this->view("frontend/community/search", compact("query", "users"));
        } else {
            $this->turbolinksLocation("/community/search");
            PageManager::setTitle("Recherches");
            $this->view("frontend/community/search");
        }
    }
}
