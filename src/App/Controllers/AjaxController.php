<?php
namespace Ngpictures\Controllers;

use Ng\Core\Generic\{Collection};
use Ngpictures\Controllers\NgpicController;


class AjaxController extends NgpicController 
{
	//ajout d'article infinite scroll 
	public function articles() 
	{
		$post = new Collection($_POST);

		if ($post->has('lastId')) {
			$this->loadModel('articles');
			$result = $this->articles->findLess($post->get('lastId'));
			require(APP."/Views/ajax/articles/cards.php");
		} else {
			header("http/1.1 Internal Server Error");
		}
	}

	// infinite scroll pour le blog
	public function blog() 
	{
		$post = new Collection($_POST);

		if ($post->has('lastId')) {
			$this->loadModel('blog');
			$result = $this->blog->findLess($post->get('lastId'));
			require(APP."/Views/ajax/blog/cards.php");
		} else {
			header("http/1.1 Internal Server Error");
		}
	}


	public function verset()
	{
		$verse = $this->callController('verses')->index();
		require(APP."/Views/ajax/verset.php");
	}
}