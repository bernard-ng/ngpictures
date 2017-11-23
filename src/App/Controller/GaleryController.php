<?php
namespace Ngpic\Controller;

use Ngpic\Controller\NgpicController;
use \Ngpic;


class GaleryController extends NgpicController
{
	public function __construct() {
		parent::__construct();
		$this->loadModel('ngarticles');
	}

    public function index()
    {
    	//$articles = $this->ngarticles->lastById();
    	Ngpic::setPageName('Galerie | Ngpictures');
    	$this->setTemplate('articles/default');
    	$this->viewRender('galery/index');
    }
}