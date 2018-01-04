<?php
namespace Ngpictures\Controllers;
use Ngpictures\Ngpic;

class RssController extends NgpicController
{
 
 	public function __construct()
 	{
 		parent::__construct();
 		$this->loadModel('blog');
 	}

	public function index()
	{
		if ($this->blog->last()) {
			$last = $this->blog->last()->date_created;
			$articles = $this->blog->latest(0,10);
		} else {
			$this->session->setFlash('info', 'Aucun article dans notre flux rss');
			Ngpic::redirect(true);
		}


		$this->viewRender('others/rss', compact('last','articles'), false);
		header("Content-type: application/rss+xml");
	}

}