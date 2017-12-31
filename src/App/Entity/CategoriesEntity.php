<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ng\Core\Generic\Str;


class CategoriesEntity extends Entity
{

	public function getUrl(): string
	{
		$this->url = "/categories/{$this->slug}-{$this->id}";
		return $this->url;
	}
}
