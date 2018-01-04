<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;

class AlbumsEntity extends Entity
{
    public function getUrl(): string
    {
        $this->url = "/Albums/{$this->slug}-{$this->id}";
        return $this->url;
    }
}