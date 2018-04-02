<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class GalleryController extends Controller
{
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('gallery');
    }

    public function index()
    {
        $photo = $this->gallery->latest();
        $photos = $this->gallery->lastOnline();
        $this->pageManager::setName('Gallerie');
        $this->setLayout('posts/default');
        $this->viewRender('front_end/gallery/index', compact('photo', 'photos'));
    }


    public function show(int $id)
    {
        $photo = $this->gallery->find(intval($id));
        if ($photo) {
            $this->viewRender('front_end/gallery/show', compact('photo'), false);
        } else {
            if ($this->isAjax()) {
                $this->ajaxFail($this->msg['post_not_found']);
            }
            $this->flash->set("danger", $this->msg['post_not_found']);
            $this->app::redirect(true);
        }
    }


    public function albums()
    {
        $albums = $this->loadModel('albums')->all();
        $this->pageManager::setName('albums');
        $this->setLayout('posts/default');
        $this->viewRender('front_end/gallery/albums', compact("albums"));
    }
}
