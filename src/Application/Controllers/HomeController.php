<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\PostsRepository;
use Psr\Container\ContainerInterface;

/**
 * Class HomeController
 * @package Application\Controllers
 */
class HomeController extends Controller
{

    /**
     * @var PostsRepository
     */
    protected $posts;


    public function index()
    {
        $categories = $this->container->get(CategoriesRepository::class)->all();
        $posts = $this->container->get(PostsRepository::class)->all();

        $this->turbolinksLocation("/");
        PageManager::setTitle('Ngpictures');
        $this->view(
            "frontend/index",
            compact('categories', 'posts')
        );
    }

    /**
     * genere une route pour une route donnee et redirige vers celle-ci
     * @param string $route
     * @param array $param
     * @param int $status
     * @return mixed
     */
    public function route(string $route, array $param = [], int $status = 200)
    {
        $url = $this->getRouter()->url($route, $param);
        $this->redirect($url, $status);
    }
}
