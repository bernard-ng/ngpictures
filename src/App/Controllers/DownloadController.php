<?php
namespace Ngpictures\Controllers;


use Ng\Core\Generic\{Flash,Str};

use Ngpictures\Ngpic;


class DownloadController extends NgpicController
{
	public function __construct()
	{
		$this->callController('users')->restrict();
	}

	private $path = [
		1 => UPLOAD."/articles/",
		UPLOAD."/pictures/",
		UPLOAD."/blog/",
		UPLOAD."/ngpictures/"
	];

	public function index($type, $file_name)
	{
		if (isset($type, $file_name) && !empty($type) && !empty($file_name)) {
			$type = Str::escape($type);
			$file_name = Str::escape($file_name);

			$file = $this->path[$type].$file_name;

			if (file_exists($file)) {

				header('Content-Type: application/octet-stream');
				header('Content-Transfer-Encoding: Binary');
				header('content-disposition: attachement; filename="'.basename($file).'"');
				echo readfile($file);
				
			} else {
				flash::getInstance()->set('danger', "Une Erreur est survenu");
				Ngpic::redirect(true);
			}

		} else {
			flash::getInstance()->set('danger', "Une Erreur c'est produit lors du téléchargement");
			Ngpic::redirect(true);
		}
	}
}
