<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class GalleryController extends Controller
{

    /**
     * GalleryController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('gallery');
    }


    /**
     * page par default
     *
     * @return void
     */
    public function index()
    {
        $photo = $this->gallery->latest();
        $photos = $this->gallery->lastOnline();

        $this->app::turbolinksLocation("/gallery");
        $this->pageManager::setName('Galerie');
        $this->setLayout('posts/default');
        $this->viewRender('frontend/gallery/index', compact('photo', 'photos'));
    }


    /**
     * affiche un article
     *
     * @param integer $id
     * @return void
     */
    public function show(int $id)
    {
        $photo = $this->gallery->find(intval($id));
        if ($photo) {
            $this->app::turbolinksLocation("/gallery/{$id}");
            $this->viewRender('frontend/gallery/show', compact('photo'), false);
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['post_not_found']);
            }
            $this->flash->set("danger", $this->msg['post_not_found']);
            $this->app::redirect(true);
        }
    }


    /**
     * affiche les albums
     *
     * @return void
     */
    public function albums()
    {
        $albums = $this->loadModel('albums')->all();

        $this->app::turbolinksLocation("/gallery/albums");
        $this->pageManager::setName('albums');
        $this->setLayout('posts/default');
        $this->viewRender('frontend/gallery/albums', compact("albums"));
    }


    /**
     * affiche en slider
     *
     * @return void
     */
    public function slider()
    {
        if (isset($_GET['last_id']) && !empty($_GET['last_id'])) {
            $lastId = $this->str::escape($_GET['last_id']);

            if ($this->gallery->find(intval($lastId))) {
                $photos = $this->gallery->findGreater($lastId, 4);

                $this->pageManager::setName('Diaporama');
                $this->setLayout('blank');
                $this->viewRender('frontend/gallery/slider', compact('photos'));
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect('/gallery');
            }
        } else {
            $photos = $this->gallery->latest();
            $this->pageManager::setName('Diaporama');
            $this->setLayout('blank');
            $this->viewRender('frontend/gallery/slider', compact('photos'));
        }
    }
}
