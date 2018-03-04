<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ngpictures\Traits\Entity\PostEntityTrait;

class GalleryEntity extends Entity
{
    private $action_url = "gallery";
    private $action_type = 2;
    private $file_path = "gallery";

    use PostEntityTrait;

    /**
     * lien vers la miniature de la publication
     * @return string
     */
    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads";
        $this->thumbUrl .= "/{$this->file_path}/{$this->thumb}";
        return $this->thumbUrl;
    }


    /**
     * lien vers l'image de la publication
     * @return string
     */
    public function getImageUrl(): string
    {
        $this->imageUrl = "/uploads";
        $this->imageUrl .= "/{$this->file_path}/{$this->thumb}";
        return $this->imageUrl;
    }
}
