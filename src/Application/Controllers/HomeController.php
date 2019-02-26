<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Repositories\BlogRepository;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\GalleryRepository;
use Application\Repositories\PostsRepository;
use Psr\Container\ContainerInterface;

/**
 * Class HomeController
 * @package Application\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var BlogRepository
     */
    protected $blog;

    /**
     * @var GalleryRepository
     */
    protected $gallery;

    /**
     * @var PostsRepository
     */
    protected $posts;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->gallery = $container->get(GalleryRepository::class);
        $this->posts = $container->get(PostsRepository::class);
        $this->blog = $container->get(BlogRepository::class);
    }

    /**
     * home page
     */
    public function index()
    {

        $nb         = [];
        $thumbs     = [];
        $categories = $this->container->get(CategoriesRepository::class)->orderBy('id', 'DESC', 0, 10);

        foreach ($categories as $category) {
            $thumbs[$category->id] =
                $this->blog->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                $this->gallery->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                $this->posts->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                '/imgs/default.jpeg';
        }

        foreach ($categories as $category) {
            $nb[$category->id] =
                count($this->blog->findWith('categories_id', $category->id, false)) +
                count($this->gallery->findWith('categories_id', $category->id, false)) +
                count($this->posts->findWith('categories_id', $category->id, false));
            ;
        }

        $last           =   $this->container->get(GalleryRepository::class)->latest();
        $posts          =   $this->container->get(PostsRepository::class)->latest(0, 12);
        $article        =   $this->container->get(BlogRepository::class)->last();

        $this->turbolinksLocation("/");
        PageManager::setTitle('Ngpictures');
        $this->view(
            "frontend/index",
            compact('last', 'article', 'categories', 'posts', 'thumbs', 'nb')
        );
    }
}
