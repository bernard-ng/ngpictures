<?php
namespace Ngpictures\Controllers;

use Ngpictures\Controllers\NgpicController;
use Ngpictures\Util\Page;


class GalleryController extends NgpicController
{

    public function index()
    {
    	Page::setName('Gallerie | Ngpictures');
    	$this->setLayout('articles/default');
    	$this->viewRender('gallery/index');
    }
}