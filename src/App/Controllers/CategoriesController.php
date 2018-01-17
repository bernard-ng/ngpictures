<?php
namespace Ngpictures\Controllers;
use Ngpictures\Ngpictures;
use Ngpictures\Util\Page;


/**
 * gestion des categories de publication
 * Class CategoriesController
 * @package Ngpictures\Controllers
 */
class CategoriesController extends NgpicController
{

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('categories');
    }


    /**
     * liste des differentes categories
     */
    public function index()
    {
        $categories = $this->categories->orderBy('title', 'ASC');

        Page::setName('Toutes les catégories | Ngpictures');
        $this->setLayout('default-simple');
        $this->viewRender("categories/index", compact('categories'));
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

            Page::setName("Catégorie: {$category->title} | Ngpictures");
            $this->setLayout('articles/default');
            $this->viewRender('categories/show',
                compact(
                    'category', 'blog', 'articles', 'gallery'
                )
            );
        } else {
            $this->flash->set('danger', $this->msg['category_notFound']);
            Ngpictures::redirect(true);
        }
    }


}
