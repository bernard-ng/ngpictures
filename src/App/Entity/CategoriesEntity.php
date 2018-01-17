<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ng\Core\Generic\Str;


class CategoriesEntity extends Entity
{

    /**
     * lien vers la categorie
     * @return string
     */
	public function getUrl(): string
	{
		$this->url = "/categories/{$this->slug}-{$this->id}";
		return $this->url;
	}
}
