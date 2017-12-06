<?php
namespace Ngpictures\Entity;


use Ngpictures\Ngpic;

use Ng\Core\Entity\Entity;


class CommentsEntity extends Entity
{
	public function __construct()
	{
		$this->users = Ngpic::getInstance()->getModel('users');
	}


	public function getDeleteUrl()
	{
		return "/comments/delete/{$this->id}";
	}


	public function getEditUrl()
	{
		return "/comments/edit/{$this->id}";
	}
}