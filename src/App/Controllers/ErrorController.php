<?php
namespace Ngpictures\Controllers;


use Ngpictures\Util\Page;

use Ngpictures\Ngpic;


class ErrorController extends NgpicController
{
	
	public function e404()
	{
		Page::setName("Erreur 404 | Ngpictures");
		$this->viewRender("error/404");
	}

	public function e403()
	{
		Page::setName('Erreur 403 | Ngpictures');
		$this->viewRender('error/404');
	}

	public function e500()
	{
		Page::setName("Erreur 500 | Ngpictures");
		$this->viewRender("error/500");
	}
}