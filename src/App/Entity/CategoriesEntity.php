<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ng\Core\Generic\Str;


class CategoriesEntity extends Entity
{

	public function getUrl(): string
	{
		$title = Str::slugify($this->title);
		$this->url = "/categories/{$title}-{$this->id}";
		return $this->url;
	}
}
