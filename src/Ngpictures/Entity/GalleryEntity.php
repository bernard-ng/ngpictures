<?php
namespace Application\Entity;

use Framework\Entity\Entity;
use Framework\Managers\CacheBustingManager;
use Application\Traits\Entity\PostEntityTrait;

class GalleryEntity extends Entity
{
    private $action_url = "gallery";
    private $action_type = 2;
    private $file_path = "gallery";

    use PostEntityTrait;


    /**
     * url d'enregistrement
     *
     * @return string
     */
    public function getSaveUrl() : string
    {
        $this->saveUrl = "/saves/{$this->action_type}";
        $this->saveUrl .= "/{$this->SI}";
        return $this->saveUrl;
    }

    public function getUrl()
    {
        $this->url = "/gallery/{$this->slug}-{$this->id}";
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
