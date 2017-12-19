<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;


class NgGalleryEntity extends Entity
{
	public function getThumbUrl(): string 
	{
		$this->thumbUrl = "/uploads/ngpictures/{$this->thumb}";
		return $this->thumbUrl;
	}
}