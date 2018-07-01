<?php
namespace Ngpictures\Controllers\Admin;


use Ng\Core\Managers\Collection;
use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class CategoriesController extends AdminController
{

    use PaginationTrait;

    /**
     * liste des differentes categories
     */
    public function index()
    {
        $categories = $this->categories->orderBy('title', 'DESC', 0, 10);
        $total = $this->categories->countAll()->num;

        $pagination     = $this->setPagination($total, "categories");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $categories     = $pagination['result'] ?? $categories;

        $this->pageManager::setName('admin categories');
        $this->view(
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
                $title          =   $this->str->escape($post->get('title'));
                $slug           =   $this->str->slugify($title);
                $description    =   $post->get('description');
                $this->categories->create(compact('title', 'description', 'slug'));

                $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                $this->redirect(ADMIN . "/blog/categories", false);
            } else {
               $this->sendFormError();
            }
        }

        $this->pageManager::setName('admin categories.add');
        $this->view('backend/blog/categories.add', compact('post', 'errors'));
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
                    $title          =   $this->str->escape($post->get('title')) ?? $category->title;
                    $slug           =   $this->str->slugify($title);
                    $description    =   $post->get('description') ?? $category->description;

                    $this->categories->update($category->id, compact('title', 'description', 'slug'));
                    $this->flash->set('success', $this->flash->msg['post_edit_success']);
                    $this->redirect(ADMIN . "/blog/categories");
                } else {
                    $this->sendFormError();
                }
            }

            $this->pageManager::setName('admin categories.edit');
            $this->view('backend/blog/categories.edit', compact('post', 'category', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
        }
    }
}
