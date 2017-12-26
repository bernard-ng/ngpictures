<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;

use Ng\Core\Generic\{Str,Session};



class UsersEntity extends Entity
{
	public function getAccountUrl()
	{
		$this->accountUrl = "/account/".Str::slugify($this->name)."-{$this->id}";
		return $this->accountUrl;
	}


	public function getEditUrl()
	{
		$session = Session::getInstance();
		$this->editUrl = "/account/edit/".Str::slugify($this->name)."-{$this->id}/".$session->read('token');
		return $this->editUrl;
	}


	public function getAvatarUrl()
	{
		$this->avatarUrl = "/uploads/avatars/{$this->avatar}";
		return $this->avatarUrl;
	}


	public function getGalleryUrl()
	{
		$this->galleryUrl = "/gallery/".Str::slugify($this->name)."-{$this->id}";
		return $this->galleryUrl;
	}
}
