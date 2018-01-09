<?php
namespace Ngpictures\Controllers;

use Ng\Core\Generic\Collection;
use Ngpictures\Controllers\NgpicController;


class AjaxController extends NgpicController 
{
	//ajout d'article infinite scroll 
	public function articles() 
	{
		if ($this->isAjax()) {
			$post = new Collection($_POST);

			if ($post->has('lastId')) {
				$result = $this->loadModel('articles')->findLess($post->get('lastId'));
				require(APP."/Views/ajax/articles/cards.php");
				exit();
			} else {
				$this->ajaxFail($this->msg['indefined_error']);
			}
		} else {
			$this->flash->set("warning", $this->msg['indefined_error']);
			Ngpic::redirect();
		}
	}


	// infinite scroll pour le blog
	public function blog() 
	{
		if ($this->isAjax()) {
			$post = new Collection($_POST);
			if ($post->has('lastId')) {
				$result = $this->loadModel('blog')->findLess($post->get('lastId'));
				require(APP."/Views/ajax/blog/cards.php");
				exit();
			} else {
				$this->ajaxFail($this->msg['indefined_error']);
			}
		} else {
			$this->flash->set("warning", $this->msg['indefined_error']);
			Ngpic::redirect();
		}
	}


	public function verset()
	{
		$verse = $this->callController('verses')->index();
		require(APP."/Views/ajax/verset.php");
	}
}