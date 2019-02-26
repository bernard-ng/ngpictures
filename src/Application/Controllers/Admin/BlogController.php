<?php
namespace Application\Controllers\Admin;

use Framework\Managers\Collection;
use Framework\Managers\ImageManager;
use Application\Managers\PageManager;
use Psr\Container\ContainerInterface;
use Application\Controllers\AdminController;
use Application\Traits\Controllers\PaginationTrait;

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
        PageManager::setTitle('Adm - blog');
        $this->view(
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
                        $title = $this->str->escape($post->get('title'));
                        $content = $post->get('content');
                        $slug = $this->str->escape($post->get('slug')) ?? $this->str->suglify($post->get('title'));
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
            PageManager::setTitle('Adm - blog.edit');
            $this->view('backend/blog/edit', compact('article', 'categories', 'post', 'errors'));
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
                $title              =   $this->str->escape($post->get('title'));
                $content            =   $post->get('content');
                $categories_id      =   ($post->get('category') == 0) ? 1 : $post->get('category');

                if ($post->get('slug') !== '') {
                    $this->validator->setRule('slug', 'alnum_dash');
                    if ($this->validator->isValid()) {
                        $slug = $this->str->escape($post->get('slug'));
                    }
                } else {
                    $slug = $this->str->slugify($title);
                }
            } else {
                $this->sendFormError();
            }

            if (isset($_FILES) && !empty($_FILES)) {
                if (!empty($file->get('thumb.name'))) {
                    if ($this->validator->isValid()) {
                        $this->blog->create(compact('title', 'content', 'slug', 'categories_id'));

                        $last_id        =   $this->blog->lastInsertId();
                        if ($last_id) {
                            $isUploaded = $this
                                ->container
                                ->get(ImageManager::class)
                                ->upload($file, 'blog', "ngpictures-{$slug}-{$last_id}", 'article');

                            if ($isUploaded) {
                                $this
                                    ->container
                                    ->get(ImageManager::class)
                                    ->upload($file, 'blog-thumbs', "ngpictures-{$slug}-{$last_id}", 'small');

                                $exif = $this->container->get(ImageManager::class)->getExif($file);
                                $color = $this->container->get(ImageManager::class)->getColor($file);

                                $this->blog->update(
                                    $last_id,
                                    [
                                        'thumb' => "ngpictures-{$slug}-{$last_id}.jpg",
                                        'exif' => $exif,
                                        'color' => $color,
                                    ]
                                );

                                $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                                $this->redirect(ADMIN . "/blog");
                            } else {
                                $this->blog->delete($last_id);
                                $this->flash->set('danger', $this->flash->msg['files_not_uploaded'], false);
                            }
                        } else {
                            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
                            $this->redirect(true, false);
                        }
                    } else {
                        $this->sendFormError();
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['post_requires_picture']);
                }
            }
        }

        $this->turbolinksLocation(ADMIN . "/blog/add");
        PageManager::setTitle('Adm - blog.add');
        $this->view('backend/blog/add', compact('post', 'categories', 'errors'));
    }
}
