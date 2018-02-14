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
        $categories = $this->categories->orderBy('title', 'ASC');

        $this->pageManager::setName('Toutes les catégories');
        $this->setLayout('default-simple');
        $this->viewRender("front_end/categories/index", compact('categories'));
    }


    /**
     * affiche toutes les informations concernant une categorie
     * @param string $name
     * @param int $id
     */
    public function show($name, $id)
    {
        $category = $this->categories->find(intval($id));

        if ($category && $this->str::checkUserUrl($name, $category->title)) {
            $blog = $this->loadModel('blog')->findWith('category_id', $category->id, false);
            $posts = $this->loadModel('posts')->findWith('category_id', $category->id, false);
            $gallery = $this->loadModel('gallery')->findWith('category_id', $category->id, false);

            $this->pageManager::setName("Catégorie: {$category->title}");
            $this->setLayout('posts/default');
            $this->viewRender('front_end/categories/show', compact('category', 'blog', 'posts'));
        } else {
            $this->flash->set('danger', $this->msg['category_not_found']);
            $this->app::redirect(true);
        }
    }
}
