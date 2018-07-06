<?php
namespace Ngpictures\Controllers\Admin;


use Exception;
use DirectoryIterator;
use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
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
        $photo          =   $this->gallery->latest();
        $photos         =   $this->gallery->orderBy('date_created', 'DESC', 0, 10);
        $total          =   $this->gallery->countAll()->num;

        $pagination     = $this->setPagination($total, "gallery");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $photos         = $pagination['result'] ?? $photos;


        $this->pageManager::setName('Adm - gallery');
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
        $post           =   new Collection($_POST);
        $file           =   new Collection($_FILES);
        $categories     =   $this->categories->all();
        $albums         =   $this->albums->all();

        if (!empty($_FILES)) {
            $name = (empty($post->get('name'))) ? 'ngpictures-photo' : $this->str->escape($post->get('name'));
            $tags           =   $this->str->escape($post->get('tags')) ?? null;
            $description    =   $this->str->escape($post->get('description')) ?? null;
            $categories_id  =   intval($post->get('category')) ?? 1;
            $albums_id      =   intval($post->get('album')) ?? null;
            $slug           =   $this->str->slugify($name);

            if (!empty($file->get('thumb'))) {
                $this->gallery->create(compact('name', 'slug', 'description', 'tags', 'categories_id'));
                $last_id    =   $this->gallery->lastInsertId();
                $isUploaded =   $this->container->get(ImageManager::class)->upload($file, 'gallery', "{$slug}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    $this->container->get(ImageManager::class)->upload($file, 'gallery-thumbs', "{$slug}-{$last_id}", 'small');
                    $exif = $this->container->get(ImageManager::class)->getExif($file);

                    $this->gallery->update(
                        $last_id,
                        [
                            "thumb" => "{$slug}-{$last_id}.jpg",
                            'exif' => $exif,
                        ]
                    );

                    $this->flash->set('success', $this->flash->msg['form_post_submitted'], false);
                    $this->redirect(ADMIN . "/gallery", false);
                } else {
                    $this->flash->set('danger', $this->flash->msg['files_not_uploaded'], false);
                    $this->gallery->delete($last_id, false);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['post_requires_picture'], false);
                $this->redirect(true, false);
            }
        }

        $this->pageManager::setName('Adm - gallery.add');
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
            $post       =   new Collection($_POST);
            $categories =   $this->categories->all();
            $albums     =   $this->albums->all();

            if (isset($_POST) && !empty($_POST)) {
                $name           =   $this->str->escape($post->get('name')) ?? $photo->name;
                $tags           =   $this->str->escape($post->get('tags')) ?? $photo->tags;
                $description    =   $this->str->escape($post->get('description')) ?? $photo->description;
                $categories_id  =   intval($post->get('category')) ?? 1;
                $albums_id      =   ($posts->get('album') == 0)? null : inval($this->get('album'));

                $this->gallery->update($id, compact('name', 'tags', 'description', 'categories_id', 'albums_id'));
                $this->flash->set("success", $this->flash->msg['post_edit_success'], false);
                $this->redirect(ADMIN . "/gallery", false);
            }

            $this->pageManager::setName('Adm - gallery.edit');
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
        $this->pageManager::setName('admin media-browser');
        $this->view('backend/gallery/media-browser', compact('images'));
    }



    /**
     * permet de faire un access au fichier se situant sur le server
     * @param string $dirname
     */
    public function fileBrowser($dirname)
    {
        $dos = UPLOAD."/{$dirname}";
        $relative_dos = "/uploads/{$dirname}";

        try {
            $files = new DirectoryIterator($dos);
        } catch (Exception  $e) {
            LogMessageManager::register(__class__, $e);
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, true);
        }

        $this->pageManager::setName('admin file-browser');
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
        $image = UPLOAD."/$path[$type]/{$filename}";
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

            $this->pageManager::setName('adm - watermarker');
            $this->view("backend/gallery/watermark", ['image' => "/uploads/$path[$type]/{$filename}"]);
        } else {
            $this->flash->set('danger', $this->flash->msg['files_not_image'], false);
            $this->redirect(true, false);
        }
    }
}
