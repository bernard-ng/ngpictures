<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\CollectionsRepository;
use Application\Repositories\PostsRepository;
use Application\Repositories\UsersRepository;
use Framework\Managers\StringHelper;

/**
 * Class SearchController
 * @package Application\Controllers
 */
class SearchController extends Controller
{

    public function index()
    {
        if (isset($_GET['q']) && !empty($_GET['q'])) {
            $query = urldecode(trim(StringHelper::escape($_GET['q'])));

            $users = $this->container->get(UsersRepository::class)->search($query);
            $posts = $this->container->get(PostsRepository::class)->search($query);
            $categories = $this->container->get(CategoriesRepository::class)->search($query);
            $collections = $this->container->get(CollectionsRepository::class)->search($query);
            $pexels = $this->container->get(PexelsController::class)->search($query, 15, 1);

            $this->turbolinksLocation("/search?q=" . str_replace(' ', '+', $query));
            PageManager::setTitle("Recherches");
            $this->view(
                "frontend/others/search",
                compact("query", "users", "posts", "categories", "collections", "pexels")
            );
        } else {
            $this->turbolinksLocation($this->url('search'));
            PageManager::setTitle("Recherches");
            $this->view("frontend/others/search");
        }
    }
}
