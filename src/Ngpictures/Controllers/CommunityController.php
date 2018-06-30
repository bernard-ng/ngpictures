<?php
namespace Ngpictures\Controllers;


use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;

class CommunityController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->authService->restrict();
        $this->loadModel("users");
    }


    /**
     * page de community
     */
    public function index()
    {
        $users = $this->users->all();

        $this->turbolinksLocation('/community');
        $this->pageManager::setName("Communauté");
        $this->pageManager::setDescription(
            "Rétrouvez la communauté de ngpictures, vos amis, les artistes et les passionnés
            de la photographie"
        );
        $this->view("frontend/community/community", compact('users'));
    }
}
