<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ng\Core\Managers\Collection;
use Ngpictures\Managers\PageManager;

class CommunityController extends Controller
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->authService->restrict();
        $this->loadModel("users");
    }


    /**
     * page de community
     */
    public function index()
    {
        $users = $this->users->all();

        $this->app::turbolinksLocation('/community');
        $this->pageManager::setName("Communauté");
        $this->pageManager::setDescription(
            "Rétrouvez la communauté de ngpictures, vos amis, les artistes et les passionnés
            de la photographie"
        );
        $this->setLayout("posts/default");
        $this->viewRender("frontend/community/community", compact('users'));
    }
}
