<?php
namespace Ngpictures\Controllers;

use Ngpictures\Util\Page;


class GalleryController extends NgpicController
{
	public function __construct()
	{
		parent::__construct();
		$this->loadModel('gallery');
	}

    public function index()
    {
    	$photo = $this->gallery->latest();
    	$photos = $this->gallery->lastOnline();

    	Page::setName('Gallerie | Ngpictures');
    	$this->setLayout('articles/default');
    	$this->viewRender('gallery/index', compact('photo', 'photos'));
    }
}