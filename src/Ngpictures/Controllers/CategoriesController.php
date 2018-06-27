<?php
namespace Ngpictures\Controllers;


use Psr\Container\ContainerInterface;


class CategoriesController extends Controller
{

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->blog         = $this->loadModel('blog');
        $this->posts        = $this->loadModel('posts');
        $this->gallery      = $this->loadModel('gallery');
        $this->categories   = $this->loadModel('categories');
    }


    /**
     * liste des differentes categories
     */
    public function index()
    {
        $nb         = [];
        $thumbs     = [];
        $categories = $this->categories->orderBy('title', 'ASC');

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

        $this->turbolinksLocation('/categories');
        $this->pageManager::setName('Les catégories');
        $this->pageManager::setDescription(
            "Rétrouvez facilement une photo en cliquant sur une catégorie"
        );
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
            $blog       = $this->blog->findWith('categories_id', $category->id, false);
            $posts      = $this->posts->findWith('categories_id', $category->id, false);
            $gallery    = $this->gallery->findWith('categories_id', $category->id, false);

            $this->turbolinksLocation("/categories/{$name}-{$id}");
            $this->pageManager::setName("{$category->title}");
            $this->viewRender('frontend/categories/show', compact('category', 'blog', 'posts', 'gallery'));
        } else {
            $this->flash->set('danger', $this->flash->msg['category_not_found']);
            $this->redirect('/categories');
        }
    }
}
