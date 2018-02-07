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
            $blog = $this->loadModel('blog')->findWith('category_id', $category->id);
            $articles = $this->loadModel('articles')->findWith('category_id', $category->id);
            $gallery = $this->loadModel('gallery')->findWith('category_id', $category->id);

            $this->pageManager::setName("Catégorie: {$category->title}");
            $this->setLayout('articles/default');
            $this->viewRender(
                'front_end/categories/show',
                compact(
                    'category',
                    'blog',
                    'articles',
                    'gallery'
                )
            );
        } else {
            $this->flash->set('danger', $this->msg['category_notFound']);
            $this->app::redirect(true);
        }
    }
}
