<?php
namespace Application\Entity;

use Framework\Entities\Entity;

/**
 * Class CollectionEntity
 * @package Application\Entity
 */
class CollectionEntity extends Entity
{
    /**
     * lien vers un album photo precis
     * @return string
     */
    public function getUrl(): string
    {
        $this->url = "/gallery/albums";
        $this->url .= "/{$this->slug}-{$this->id}";
        return $this->url;
    }
}
