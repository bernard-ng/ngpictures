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
        $this->callController("users")->restrict();
        $this->loadModel("users");
    }


    public function index()
    {
        $users = $this->users->all();
        $this->pageManager::setName("La communauté");
        $this->setLayout("posts/default");
        $this->viewRender("front_end/community/community", compact('users'));
    }
}
