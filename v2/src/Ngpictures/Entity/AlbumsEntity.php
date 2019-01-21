<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;

class AlbumsEntity extends Entity
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
