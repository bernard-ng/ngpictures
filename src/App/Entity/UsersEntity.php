<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;

use Ng\Core\Generic\Str;



class UsersEntity extends Entity
{
	public function getAccountUrl()
	{
		$this->accountUrl = "/account/".Str::slugify($this->name)."-{$this->id}";
		return $this->accountUrl;
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
