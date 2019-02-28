<?php
namespace Application\Entities;

use Framework\Entities\Entity;

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
