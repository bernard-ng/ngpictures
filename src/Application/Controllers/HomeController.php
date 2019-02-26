<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Models\BlogModel;
use Application\Models\CategoriesModel;
use Application\Models\GalleryModel;
use Application\Models\PostsModel;
use Psr\Container\ContainerInterface;

/**
 * Class HomeController
 * @package Application\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var BlogModel
     */
    protected $blog;

    /**
     * @var GalleryModel
     */
    protected $gallery;

    /**
     * @var PostsModel
     */
    protected $posts;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->gallery = $container->get(GalleryModel::class);
        $this->posts = $container->get(PostsModel::class);
        $this->blog = $container->get(BlogModel::class);
    }

    /**
     * home page
     */
    public function index()
    {

        $nb         = [];
        $thumbs     = [];
        $categories = $this->container->get(CategoriesModel::class)->orderBy('id', 'DESC', 0, 10);

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

        $last           =   $this->container->get(GalleryModel::class)->latest();
        $posts          =   $this->container->get(PostsModel::class)->latest(0, 12);
        $article        =   $this->container->get(BlogModel::class)->last();

        $this->turbolinksLocation("/");
        PageManager::setTitle('Ngpictures');
        $this->view(
            "frontend/index",
            compact('last', 'article', 'categories', 'posts', 'thumbs', 'nb')
        );
    }
}
