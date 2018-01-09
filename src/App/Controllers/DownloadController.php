<?php
namespace Ngpictures\Controllers;


use Ng\Core\Generic\{Flash,Str};
use Ngpictures\Ngpic;


class DownloadController extends NgpicController
{

	/**
	* oblige a un utilisateur de se connecter pour telecharger
	*/
	public function __construct()
	{
		$this->callController('users')->restrict();
	}


	/**
	* les chemain dans lequel se trouve les fichier 
	* telechargable.
	*/
	private static $path = [
		1 => UPLOAD."/posts/",
		UPLOAD."/blog/",
		UPLOAD."/gallery/"
	];


	/**
	* permet de telecharger un fichier a partir de son type et de son nom, c'est 
	* specifique a notre application. on envoit des headers particulier pour forcer
	* le telechargement.
	*/
	public function index($type, $file_name)
	{
		if (isset($type, $file_name) && !empty($type) && !empty($file_name)) {
			$type = $this->str::escape($type);
			$file_name = $this->str::escape($file_name);

			$file = self::$path[$type].$file_name;

			if (file_exists($file)) {

				header('Content-Type: application/octet-stream');
				header('Content-Transfer-Encoding: Binary');
				header('Content-Disposition: attachement; filename="'.basename($file).'"');
				echo readfile($file);
				exit();
				
			} else {
				$this->flash->set('danger', $this->msg['indefined_error']);
				Ngpic::redirect(true);
			}

		} else {
			$this->flash->set('danger', $this->msg['download_failed']);
			Ngpic::redirect(true);
		}
	}
}
