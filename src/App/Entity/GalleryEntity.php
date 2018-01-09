<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;


class GalleryEntity extends Entity
{
    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads/gallery/thumbs/{$this->thumb}";
        return $this->thumbUrl;
    }
}