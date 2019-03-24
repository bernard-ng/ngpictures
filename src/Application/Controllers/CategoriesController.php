<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Entities\PostsEntity;
use Application\Managers\PageManager;
use Application\Repositories\CategoriesRepository;
use Application\Repositories\PostsRepository;
use Psr\Container\ContainerInterface;

/**
 * Class CategoriesController
 * @package Application\Controllers
 */
class CategoriesController extends Controller
{

    /**
     * @var PostsController|mixed
     */
    private $posts;

    /**
     * @var CategoriesRepository|mixed
     */
    private $categories;

    /**
     * CategoriesController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->posts = $container->get(PostsRepository::class);
        $this->categories = $container->get(CategoriesRepository::class);
    }


    public function index()
    {
        $categories = $this->categories->get(9);

        if ($categories) {
            foreach ($categories as $category) {
                /** @var PostsEntity $thumb */
                $thumb = $this->posts->findWith('categories_id', $category->id)[0];
                $categoriesThumbs[$category->id] =
                    (is_null($thumb)) ? "/imgs/default.jpeg" : $thumb->getSmallThumb();
            }

            foreach ($categories as $category) {
                $categoriesCount[$category->id] = $this->posts->countWith('categories_id', $category->id);
            }
        }

        $this->turbolinksLocation($this->url('categories'));
        PageManager::setTitle('Les catégories');
        PageManager::setDescription("Rétrouvez facilement une photo en cliquant sur une catégorie");
        $this->view("frontend/categories/index", compact('categories', 'categoriesCount', 'categoriesThumbs'));
    }

    /**
     * @param string $slug
     * @param int $id
     */
    public function show(string $slug, int $id)
    {
        $category = $this->categories->find(intval($id));

        if ($category) {
            /** @var PostsEntity[] $posts */
            $posts = $this->posts->findWith('categories_id', $category->id);
            $this->turbolinksLocation($this->url('categories.show', compact('id', 'slug')));
            PageManager::setTitle($category->name);
            PageManager::setDescription($category->description);
            PageManager::setImage($posts[0]->getSmallThumb());
            $this->view('frontend/categories/show', compact('category', 'posts'));
        } else {
            $this->notFound();
        }
    }
}
