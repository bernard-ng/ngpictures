<?php
namespace Ngpictures\Controllers\Admin;


use DirectoryIterator;
use Exception;
use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Controllers\AdminController;
use Ngpictures\Managers\PageManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Controllers\PaginationTrait;

class GalleryController extends AdminController
{

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('gallery');
    }

    use PaginationTrait;

    /**
     * gestion de la gallery
     */
    public function index()
    {
        $photo          =   $this->gallery->latest();
        $photos         =   $this->gallery->orderBy('date_created', 'DESC', 0, 10);
        $total          =   count($this->gallery->all());

        $pagination     = $this->setPagination($total, "gallery");
        $currentPage    = $pagination['currentPage'];
        $totalPage      = $pagination['totalPage'];
        $prevPage       = $pagination['prevPage'];
        $nextPage       = $pagination['nextPage'];
        $photos         = $pagination['result'] ?? $photos;


        $this->pageManager::setName('Adm - gallery');
        $this->setLayout("admin/default");
        $this->viewRender(
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
        $categories     =   $this->categories->orderBy('title', 'ASC');

        if (!empty($_FILES)) {
            $name = (empty($post->get('name'))) ?
                strtolower(uniqid("ngpictures-")) :
                $this->str::escape($post->get('name'));

            $tags           =   $this->str::escape($post->get('tags')) ?? null;
            $description    =   $this->str::escape($post->get('description')) ?? null;
            $categories_id    =   intval($post->get('category')) ?? 1;
            $slug = $this->str::slugify($name);

            if (!empty($file->get('thumb'))) {
                $this->gallery->create(compact('name', 'slug', 'description', 'tags', 'categories_id'));
                $last_id    =   $this->gallery->lastInsertId();
                $isUploaded =   ImageManager::upload($file, 'gallery', "{$slug}-{$last_id}", 'ratio');

                if ($isUploaded) {
                    ImageManager::upload($file, 'gallery-thumbs', "{$slug}-{$last_id}", 'small');
                    $exif = ImageManager::getExif($file);

                    $this->gallery->update(
                        $last_id,
                        [
                            "thumb" => "{$slug}-{$last_id}.jpg",
                            'exif' => $exif,
                        ]
                    );

                    $this->flash->set('success', $this->flash->msg['form_post_submitted']);
                    $this->app::redirect(ADMIN . "/gallery");
                } else {
                    $this->flash->set('danger', $this->flash->msg['files_not_uploaded']);
                    $this->gallery->delete($last_id);
                }
            } else {
                $this->flash->set('danger', $this->flash->msg['post_requires_picture']);
                $this->app::redirect(true);
            }
        }

        $this->pageManager::setName('Adm - gallery.add');
        $this->setLayout("admin/default");
        $this->viewRender("backend/gallery/add", compact('post', 'categories'));
    }



    /**
     * edition d'une photo
     * @param int $id
     */
    public function edit($id)
    {
        $photo = $this->gallery->find(intval($id));

        if ($photo) {
            $post       =   new Collection($data ?? $_POST);
            $categories =   $this->categories->orderBy('title', 'ASC');

            if (isset($_POST) && !empty($_POST)) {
                $name           =   $this->str::escape($post->get('name')) ?? $photo->name;
                $tags           =   $this->str::escape($post->get('tags')) ?? $photo->tags;
                $description    =   $this->str::escape($post->get('description')) ?? $photo->description;
                $categories_id    =   intval($post->get('category')) ?? 1;

                $this->gallery->update($id, compact('name', 'tags', 'description', 'categories_id'));
                $this->flash->set("success", $this->flash->msg['post_edit_success']);
                $this->app::redirect(ADMIN . "/gallery");
            }

            $this->pageManager::setName('Adm - gallery.edit');
            $this->setLayout("admin/default");
            $this->viewRender("backend/gallery/edit", compact('photo', 'categories'));
        } else {
            $this->flash->set('danger', $this->flash->msg['post_not_found']);
            $this->app::redirect(true);
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
        $this->setLayout('modal');
        $this->viewRender('backend/gallery/media-browser', compact('images'));
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
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->app::redirect(true);
        }

        $this->pageManager::setName('admin file-browser');
        $this->setLayout('modal');
        $this->viewRender('backend/gallery/file-browser', compact('files', 'relative_dos'));
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
                $isWatermarked = ImageManager::watermark(
                    $filename,
                    $post->get('watermark'),
                    $path[intval($type)],
                    $post->get('color')
                );

                if ($isWatermarked) {
                    $this->flash->set('success', $this->flash->msg['success']);
                    $this->app::redirect(true);
                } else {
                    $this->flash->set('danger', "Watermark non effectué");
                    $this->app::redirect(true);
                }
            }

            $this->pageManager::setName('adm - watermarker');
            $this->setLayout("admin/default");
            $this->viewRender("backend/gallery/watermark", ['image' => "/uploads/$path[$type]/{$filename}"]);
        } else {
            $this->flash->set('danger', $this->flash->msg['files_not_image']);
            $this->app::redirect(true);
        }
    }
}
