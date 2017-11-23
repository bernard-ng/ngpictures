<?php
namespace Ngpic\Controller;
use \Ngpic;

class ErrorController extends NgpicController
{
	
	public function e404()
	{
		Ngpic::setPageName("Erreur 404 | Ngpictures");
		$this->viewRender("error/404");
	}

	public function e403()
	{
		Ngpic::setPageName('Erreur 403 | Ngpictures');
		$this->viewRender('error/404');
	}

	public function e500()
	{
		Ngpic::setPageName("Erreur 500 | Ngpictures");
		$this->viewRender("error/500");
	}
}