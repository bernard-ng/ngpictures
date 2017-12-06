<?php
namespace Ngpictures\Controllers;

class VersesController extends NgpicController {

	public function __construct()
	{
		$this->loadModel('verses');
	}

	public function index()
	{
		$id = mt_rand(1,517);
		$verse = $this->verses->find($id);
		return $verse ?? false;
	}
}
