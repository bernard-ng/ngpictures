<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class CategoriesController extends Controller
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('categories');
    }


    /**
     * liste des differentes categories
     */
    public function index()
    {
        $this->loadModel('gallery');
        $this->loadModel('blog');
        $this->loadModel('posts');
        $categories = $this->categories->orderBy('title', 'ASC');
        $thumbs = [];
        $nb = [];

        foreach($categories as $category) {
            $thumbs[$category->id] =
                $this->blog->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                $this->gallery->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                $this->posts->findWith('categories_id', $category->id, true)->smallThumbUrl ??
                '/imgs/default.jpeg';
        }

        foreach($categories as $category) {
            $nb[$category->id] =
                count($this->blog->findWith('categories_id', $category->id, false)) +
                count($this->gallery->findWith('categories_id', $category->id, false)) +
                count($this->posts->findWith('categories_id', $category->id, false));;
        }

        $this->app::turbolinksLocation('/categories');
        $this->pageManager::setName('Les catégories');
        $this->pageManager::setDescription(
            "Rétrouvez facilement une photo en cliquant sur une catégorie"
        );
        $this->setLayout('posts/default');
        $this->viewRender("frontend/categories/index", compact('categories', 'thumbs', 'nb'));
    }


    /**
     * affiche toutes les informations concernant une categorie
     * @param string $name
     * @param int $id
     */
    public function show(string $name, int $id)
    {
        $category = $this->categories->find(intval($id));

        if ($category && $this->str::checkUserUrl($name, $category->title)) {
            $blog = $this->loadModel('blog')->findWith('categories_id', $category->id, false);
            $posts = $this->loadModel('posts')->findWith('categories_id', $category->id, false);
            $gallery = $this->loadModel('gallery')->findWith('categories_id', $category->id, false);

            $this->app::turbolinksLocation("/categories/{$name}-{$id}");
            $this->pageManager::setName("{$category->title}");
            $this->setLayout('posts/default');
            $this->viewRender('frontend/categories/show', compact('category', 'blog', 'posts', 'gallery'));
        } else {
            $this->flash->set('danger', $this->msg['category_not_found']);
            $this->app::redirect('/categories');
        }
    }
}
