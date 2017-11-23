<?php
namespace Ngpic\Controller;
use \Ngpic;

class RssController extends NgpicController
{
 
 	public function __construct()
 	{
 		parent::__construct();
 		$this->loadModel('ngarticles');
 	}

	public function index()
	{
		header("Content-type:application/rss+xml");
		if ($this->ngarticles->last()) {
			$last = $this->ngarticles->last()->date_created;
			$articles = $this->ngarticles->last(25);
		} else {
			$this->session->setFlash('info', 'Aucun article dans notre flux rss');
			Ngpic::redirect(true);
		}

		$this->viewRender('others/rss', compact('last','articles'), false);
	}

}