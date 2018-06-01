<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ng\Core\Managers\CacheBustingManager;
use Ngpictures\Traits\Entity\PostEntityTrait;

class GalleryEntity extends Entity
{
    private $action_url = "gallery";
    private $action_type = 2;
    private $file_path = "gallery";

    use PostEntityTrait;

    public function getUrl()
    {
        $this->url = "/gallery/{$this->id}";
        return $this->url;
    }


    /**
     * lien vers la miniature de la publication
     * @return string
     */
    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads";
        $this->thumbUrl .= "/{$this->file_path}/{$this->thumb}";
        $this->thumbUrl = CacheBustingManager::get($this->thumbUrl);
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
