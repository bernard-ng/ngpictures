<?php
namespace Ngpictures\Controllers\Admin;


use Ng\Core\Managers\Collection;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Controllers\PaginationTrait;

class CategoriesController extends AdminController
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('categories');
    }

    use PaginationTrait;

    /**
     * liste des differentes categories
     */
    public function index()
    {
        $categories = $this->categories->orderBy('title', 'DESC', 0, 10);
        $total = count($this->categories->all());

        $pagination = $this->setPagination($total, "categories");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $categories = $pagination['result'] ?? $categories;

        $this->pageManager::setName('admin categories');
        $this->setLayout('admin/default');
        $this->viewRender(
            'backend/blog/categories',
            compact('categories', 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }



    /**
     * ajout d'une categorie
     */
    public function add()
    {
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('title', 'required');
            $this->validator->setRule('description', 'required');

            if ($this->validator->isValid()) {
                $title          =   $this->str::escape($post->get('title'));
                $slug           =   $this->str::slugify($title);
                $description    =   $post->get('description');
                $this->categories->create(compact('title', 'description', 'slug'));

                $this->flash->set('success', $this->flash->msg['form_post_submitted']);
                $this->app::redirect(ADMIN . "/blog/categories");
            } else {
                $this->flash->set('danger', $this->flash->msg['form_multi_errors']);
                $errors = new Collection($this->validator->getErrors());
            }
        }

        $this->pageManager::setName('admin categories.add');
        $this->setLayout('admin/default');
        $this->viewRender('backend/blog/categories.add', compact('post', 'errors'));
    }



    /**
     * edition d'une categorie
     * @param int $id
     */
    public function edit($id)
    {
        $post       =   new Collection($_POST);
        $errors     =   new Collection();
        $category   =   $this->categories->find(intval($id));

        if ($category) {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('description', 'required');

                if ($this->validator->isValid()) {
                    $title          =   $this->str::escape($post->get('title')) ?? $category->title;
                    $slug           =   $this->str::slugify($title);
                    $description    =   $post->get('description') ?? $category->description;

                    $this->categories->update($category->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->flash->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/blog/categories");
                } else {
                    $this->flash->set("danger", $this->flash->msg['form_multi_errors']);
                    $errors = new Collection($this->validator->getErrors());
                }
            }

            $this->pageManager::setName('admin categories.edit');
            $this->setLayout('admin/default');
            $this->viewRender('backend/blog/categories.edit', compact('post', 'category', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}
