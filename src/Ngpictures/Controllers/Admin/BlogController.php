<?php
namespace Ngpictures\Controllers\Admin;


use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class BlogController extends AdminController
{
    use PaginationTrait;

    /**
     * gestion du blog
     */
    public function index()
    {
        $posts      =   $this->blog->orderBy('id', 'DESC', 0, 10);
        $total      =   $this->blog->countAll()->num;

        $pagination     = $this->setPagination($total, "blog");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $posts          = $pagination['result'] ?? $posts;

        $this->turbolinksLocation(ADMIN . '/blog');
        $this->pageManager::setName('Adm - blog');
        $this->viewRender(
            "backend/blog/index",
            compact("posts", 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }



    /**
     * edition d'un article
     * ne pas escape la valeur de $post->get("content"); a cause de l'editeur wysiwyg
     * @param int $id
     * @param null|array $data
     */
    public function edit(int $id, $data = null)
    {
        $post           = new Collection($data ?? $_POST);
        $errors         = new Collection();
        $article        = $this->blog->find(intval($id));
        $categories     = $this->categories->orderBy('title', 'ASC');

        if ($article) {
            if (isset($_POST) && !empty($_POST)) {
                if (!empty($post->get('content')) && !empty($post->get('title')) && !empty($post->get('slug'))) {
                    $this->validator->setRule('title', 'required');
                    $this->validator->setRule('content', 'required');

                    if ($this->validator->isValid()) {
                        $title = $this->str::escape($post->get('title'));
                        $content = $post->get('content');
                        $slug = $this->str::escape($post->get('slug')) ?? $this->str::suglify($post->get('title'));
                        $categories_id = (int) $post->get('category') ?? 1;

                        $this->blog->update($id, compact('title', 'content', 'slug', 'categories_id'));
                        $this->flash->set("success", $this->flash->msg['post_edit_success'], false);
                        $this->redirect(ADMIN . "/blog", false);
                    } else {
                        $this->sendFormError();
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['form_all_required'], false);
                }
            }

            $this->turbolinksLocation(ADMIN . '/blog/edit/' . $id);
            $this->pageManager::setName('Adm - blog.edit');
            $this->viewRender('backend/blog/edit', compact('article', 'categories', 'post', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found']);
            $this->redirect('/error/not-found', 404);
        }
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
                $this->sendFormError();
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

                            $this->flash->set('success', $this->flash->msg['form_post_submitted']);
                            $this->redirect(ADMIN . "/blog");
                        } else {
                            $this->blog->delete($last_id);
                            $this->flash->set('danger', $this->flash->msg['files_not_uploaded']);
                        }
                    } else {
                        $this->flash->set("danger", $this->flash->msg['form_multi_errors']);
                        $errors = new Collection($this->validator->getErrors());
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['post_requires_picture']);
                }
            }
        }

        $this->turbolinksLocation(ADMIN . "/blog");
        $this->pageManager::setName('Adm - blog.add');
        $this->viewRender('backend/blog/add', compact('post', 'categories', 'errors'));
    }
}
