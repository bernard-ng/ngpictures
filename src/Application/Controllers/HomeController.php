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

    /**
     * HomeController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->posts = $container->get(PostsRepository::class);
    }


    public function index()
    {
        $categories = $this->container->get(CategoriesRepository::class)->orderBy('id', 'DESC', 0, 10);
        $posts          =   $this->container->get(PostsRepository::class)->latest(0, 12);

        $this->turbolinksLocation("/");
        PageManager::setTitle('Ngpictures');
        $this->view(
            "frontend/index",
            compact('categories', 'posts')
        );
    }
}
