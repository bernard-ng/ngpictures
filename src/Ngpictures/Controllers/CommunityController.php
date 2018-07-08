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
}
