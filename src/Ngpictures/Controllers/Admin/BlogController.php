<?php
namespace Ngpictures\Controllers\Admin;


use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Controllers\PaginationTrait;

class BlogController extends AdminController
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('blog');
    }

    use PaginationTrait;

    /**
     * gestion du blog
     */
    public function index()
    {
        $posts      =   $this->blog->orderBy('id', 'DESC');
        $article    =   $this->blog->last();
        $this->pageManager::setName('Adm - blog');
        $this->setLayout("admin/default");
        $this->viewRender("back_end/blog/index", compact("posts", "article"));
    }



    /**
     * edition d'un article
     * ne pas escape la valeur de $post->get("content"); a cause de l'editeur wysiwy
     * @param int $id
     * @param null $data
     */
    public function edit(int $id, $data = null)
    {
        $post = new Collection($data ?? $_POST);
        $errors         =   new Collection();
        $article        =   $this->blog->find(intval($id));
        $categories     =   $this->categories->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('content')) && !empty($post->get('title')) && !empty($post->get('slug'))) {
                $this->validator->setRule('title', 'required');
                $this->validator->setRule('content', 'required');
                $this->validator->setRule('slug', 'required');
                $this->validator->setRule('slug', 'alpha_dash');

                if ($this->validator->isValid()) {
                    $title = $this->str::escape($post->get('title'));
                    $content = $post->get('content');
                    $slug = $this->str::escape($post->get('slug'));
                    $categories_id = (int)$post->get('category') ?? 1;

                    $this->blog->update($id, compact('title', 'content', 'slug', 'categories_id'));
                    $this->flash->set("success", $this->msg['post_edit_success']);
                    $this->app::redirect(ADMIN . "/blog");
                } else {
                    $errors = $this->validator->getErrors();
                }
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
            }
        }

        $this->pageManager::setName('Adm - blog.edit');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/blog/edit', compact('article', 'categories', 'post', 'errors'));
    }



    /**
     * ajout d'un nouvel article
     * le contenu $content n'est pas echapper a cause de l'editeur
     */
    public function add()
    {
        $post           =   new Collection($_POST);
        $file           =   new Collection($_FILES);
        $errors         =   new Collection();
        $categories     =   $this->categories->orderBy('title', 'ASC');

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('title', 'required');
            $this->validator->setRule('content', 'required');

            if ($this->validator->isValid()) {
                $title              =   $this->str::escape($post->get('title'));
                $content            =   $post->get('content');
                $categories_id      =   ($post->get('category') == 0) ? 1 : $post->get('category');

                if ($post->get('slug') !== '') {
                    $this->validator->setRule('slug', 'alnum_dash');
                    if ($this->validator->isValid()) {
                        $slug = $this->str::escape($post->get('slug'));
                    }
                } else {
                    $slug = $this->str::slugify($title);
                }
            } else {
                $this->flash->set('danger', $this->msg['form_multi_errors']);
                $errors = new Collection($this->validator->getErrors());
            }

            if (isset($_FILES) && !empty($_FILES)) {
                if (!empty($file->get('thumb.name'))) {
                    if ($this->validator->isValid()) {
                        $this->blog->create(compact('title', 'content', 'slug', 'categories_id'));

                        $last_id        =   $this->blog->lastInsertId();
                        $isUploaded     =   ImageManager::upload($file, 'blog', "ngpictures-{$slug}-{$last_id}", 'article');

                        if ($isUploaded) {
                            ImageManager::upload($file, 'blog-thumbs', "ngpictures-{$slug}-{$last_id}", 'small');
                            $exif = ImageManager::getExif($file);

                            $this->blog->update(
                                $last_id,
                                [
                                    'thumb' => "ngpictures-{$slug}-{$last_id}.jpg",
                                    'exif' => $exif
                                ]
                            );

                            $this->flash->set('success', $this->msg['form_post_submitted']);
                            $this->app::redirect(ADMIN . "/blog");
                        } else {
                            $this->blog->delete($last_id);
                            $this->flash->set('danger', $this->msg['files_not_uploaded']);
                        }
                    } else {
                        $this->flash->set("danger", $this->msg['form_multi_errors']);
                        $errors = new Collection($this->validator->getErrors());
                    }
                } else {
                    $this->flash->set('danger', $this->msg['post_requires_picture']);
                }
            }
        }

        $this->pageManager::setName('Adm - blog.add');
        $this->setLayout('admin/default');
        $this->viewRender('back_end/blog/add', compact('post', 'categories', 'errors'));
    }
}