<?php
namespace Ngpictures\Controllers;

use Ngpictures\Managers\PageManager;
use Ngpictures\Models\BlogModel;
use Ngpictures\Models\CategoriesModel;
use Ngpictures\Models\GalleryModel;
use Ngpictures\Models\PostsModel;

/**
 * Class HomeController
 * @package Ngpictures\Controllers
 */
class HomeController extends Controller
{
    /**
     * home page
     */
    public function index()
    {
        $last           =   $this->container->get(GalleryModel::class)->latest();
        $posts          =   $this->container->get(PostsModel::class)->latest(0, 6);
        $article        =   $this->container->get(BlogModel::class)->last();
        $categories     =   $this->container->get(CategoriesModel::class)->orderBy('title', 'DESC', 0, 10);

        $this->turbolinksLocation("/");
        PageManager::setTitle('Ngpictures');
        $this->view(
            "frontend/index",
            compact('last', 'article', 'categories', 'posts')
        );
    }
}
