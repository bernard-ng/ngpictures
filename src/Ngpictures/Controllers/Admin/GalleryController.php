<?php
namespace Ngpictures\Controllers\Admin;

use Exception;
use DirectoryIterator;
use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Managers\PageManager;
use Psr\Container\ContainerInterface;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Traits\Controllers\PaginationTrait;

class GalleryController extends AdminController
{

    use PaginationTrait;

    /**
     * gestion de la gallery
     */
    public function index()
    {
        $photo = $this->gallery->latest();
        $photos = $this->gallery->orderBy('date_created', 'DESC', 0, 10);
        $total = $this->gallery->countAll()->num;

        $pagination = $this->setPagination($total, "gallery");
        $currentPage = $pagination['currentPage'];
        $totalPage = $pagination['totalPage'];
        $prevPage = $pagination['prevPage'];
        $nextPage = $pagination['nextPage'];
        $photos = $pagination['result'] ?? $photos;


        PageManager::setTitle('Adm - gallery');
        $this->view(
            "backend/gallery/index",
            compact('photos', 'photo', 'total', "totalPage", "currentPage", "prevPage", "nextPage")
        );
    }


    /**
     * ajout d'une nouvelle photo
     */
    public function add()
    {
        $post = new Collection($_POST);
        $file = new Collection($_FILES);
        $categories = $this->categories->all();
        $albums = $this->albums->findWith(
            "photographers_id",
            $this->photographers->findWith('users_id', $this->authService->isLogged()->id)->id,
            false
        );

        if (!empty($_FILES)) {
            $name = $this->str->escape($post->get('name'));
            $tags = $this->str->escape($post->get('tags')) ?? null;
            $description = $this->str->escape($post->get('description')) ?? null;
            $categories_id = ($post->get('category') == 0) ? 1 : intval($post->get('category'));
            $albums_id = ($post->get('album') == 0) ? 1 : intval($post->get('album'));
            $slug =  empty($name)? 'ngpictures-photo' : "ngpictures-" . $this->str->slugify($name);

            if (!empty($file->get('thumb'))) {
                $this->gallery->create(compact('name', 'slug', 'description', 'tags', 'categories_id', 'albums_id'));
                $last_id = $this->gallery->lastInsertId();
                if ($last_id) {
                    $isUploaded = $this->container->get(ImageManager::class)->upload($file, 'gallery', "{$slug}-{$last_id}", 'ratio');

                    if ($isUploaded) {
                        $this->container->get(ImageManager::class)->upload($file, 'gallery-thumbs', "{$slug}-{$last_id}", 'small');
                        $exif = $this->container->get(ImageManager::class)->getExif($file);
                        $color = $this->container->get(ImageManager::class)->getColor($file);

                        $this->gallery->update(
                            $last_id,
                            [
                                "thumb" => "{$slug}-{$last_id}.jpg",
                                'exif' => $exif,
                                'color' => $color,
                            ]
                        );

                        $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                        $this->redirect(ADMIN . "/gallery", false);
                    } else {
                        $this->flash->set('danger', $this->flash->msg['files_not_uploaded'], false);
                        $this->gallery->delete($last_id, false);
                    }
                } else {
                    $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
                    $this->redirect(true, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['post_requires_picture'], false);
                $this->redirect(true, false);
            }
        }

        PageManager::setTitle('Adm - gallery.add');
        $this->view("backend/gallery/add", compact('post', 'categories', 'albums'));
    }



    /**
     * edition d'une photo
     * @param int $id
     */
    public function edit($id)
    {
        $photo = $this->gallery->find(intval($id));

        if ($photo) {
            $post = new Collection($_POST);
            $categories = $this->categories->all();
            $albums = $this->albums->all();

            if (isset($_POST) && !empty($_POST)) {
                $name = $this->str->escape($post->get('name')) ?? $photo->name;
                $tags = $this->str->escape($post->get('tags')) ?? $photo->tags;
                $description = $this->str->escape($post->get('description')) ?? $photo->description;
                $categories_id = intval($post->get('category')) ?? $photo->categories_id ?? 1;
                $albums_id = ($post->get('album') == 0) ? $photo->albums_id : intval($post->get('album'));

                $this->gallery->update($id, compact('name', 'tags', 'description', 'categories_id', 'albums_id'));
                $this->flash->set("success", $this->flash->msg['post_edit_success'], false);
                $this->redirect(ADMIN . "/gallery", false);
            }

            PageManager::setTitle('Adm - gallery.edit');
            $this->view("backend/gallery/edit", compact('photo', 'categories', 'albums'));
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found'], false);
            $this->redirect(true, false);
        }
    }



    /**
     * modal de selection d'imageManager
     * c'est juste un mediabrowser pour les posts
     */
    public function mediaBrowser()
    {
        $images = $this->gallery->all();
        PageManager::setTitle('admin media-browser');
        $this->view('backend/gallery/media-browser', compact('images'));
    }



    /**
     * permet de faire un access au fichier se situant sur le server
     * @param string $dirname
     */
    public function fileBrowser($dirname)
    {
        $dos = UPLOAD . "/{$dirname}";
        $relative_dos = "/uploads/{$dirname}";

        try {
            $files = new DirectoryIterator($dos);
        } catch (Exception $e) {
            LogMessageManager::register(__class__, $e);
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, true);
        }

        PageManager::setTitle('admin file-browser');
        $this->view('backend/gallery/file-browser', compact('files', 'relative_dos'));
    }


    /**
     * ajoute un logo a une image
     *
     * @param integer $type
     * @param string $filename
     * @return void
     */
    public function watermark(int $type, string $filename)
    {
        $path = [1 => 'posts', 'gallery', 'blog'];
        $image = UPLOAD . "/$path[$type]/{$filename}";
        $post = new Collection($_POST);

        if (is_file($image)) {
            if (isset($_POST) and !empty($_POST)) {
                $isWatermarked = $this->container->get(ImageManager::class)->watermark(
                    $filename,
                    $post->get('watermark'),
                    $path[intval($type)],
                    $post->get('color')
                );

                if ($isWatermarked) {
                    $this->flash->set('success', $this->flash->msg['success'], false);
                    $this->redirect(true, false);
                } else {
                    $this->flash->set('danger', $this->flash->msg['failed'], false);
                    $this->redirect(true, false);
                }
            }

            PageManager::setTitle('adm - watermarker');
            $this->view("backend/gallery/watermark", ['image' => "/uploads/$path[$type]/{$filename}"]);
        } else {
            $this->flash->set('danger', $this->flash->msg['files_not_image'], false);
            $this->redirect(true, false);
        }
    }
}
