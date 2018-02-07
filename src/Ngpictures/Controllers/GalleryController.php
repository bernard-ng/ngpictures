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
        $this->setLayout('articles/default');
        $this->viewRender('front_end/gallery/index', compact('photo', 'photos'));
    }
}
