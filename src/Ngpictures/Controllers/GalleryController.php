<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;


class GalleryController extends Controller
{

    /**
     * @inheritDoc
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
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

        $this->turbolinksLocation("/gallery");
        $this->pageManager::setName('Galerie');
        $this->viewRender('frontend/gallery/index', compact('photo', 'photos'));
    }


    /**
     * affiche un article
     *
     * @param integer $id
     * @return void
     */
    public function show($id)
    {
        $photo = $this->gallery->find(intval($id));
        if ($photo) {
            $this->turbolinksLocation("/gallery/{$id}");
            $this->viewRender('frontend/gallery/show', compact('photo'), false);
        } else {
            if ($this->isAjax()) {
                $this->setFlash($this->flash->msg['post_not_found']);
            }
            $this->flash->set("danger", $this->flash->msg['post_not_found']);
            $this->redirect(true);
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

        $this->turbolinksLocation("/gallery/albums");
        $this->pageManager::setName('albums');
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
                $this->viewRender('frontend/gallery/slider', compact('photos'));
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error']);
                $this->redirect('/gallery');
            }
        } else {
            $photos = $this->gallery->latest();
            $this->pageManager::setName('Diaporama');
            $this->viewRender('frontend/gallery/slider', compact('photos'));
        }
    }
}
