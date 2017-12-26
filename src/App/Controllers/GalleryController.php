<?php
namespace Ngpictures\Controllers;

use Ngpictures\Controllers\NgpicController;
use Ngpictures\Util\Page;


class GalleryController extends NgpicController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('ngGallery');
		$this->loadModel('gallery');
	}

    public function index()
    {
    	$photo = $this->ngGallery->latest();
    	$photos = $this->ngGallery->lastOnline();

    	Page::setName('Gallerie | Ngpictures');
    	$this->setLayout('articles/default');
    	$this->viewRender('gallery/index', compact('photo', 'photos'));
    }
}