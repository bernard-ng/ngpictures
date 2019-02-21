<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;

class CategoriesEntity extends Entity
{

    /**
     * lien vers la categorie
     * @return string
     */
    public function getUrl(): string
    {
        $this->url = "/categories";
        $this->url .= "/{$this->slug}-{$this->id}";
        return $this->url;
    }
}
