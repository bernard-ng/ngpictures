<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Util\AuthTrait;
use Ng\Core\Interfaces\SessionInterface;

class CommentsEntity extends Entity
{

    use AuthTrait;

    /**
     * lien de suppression de commentaire
     * @return string
     */
    public function getDeleteUrl()
    {
        $this->deleteUrl = "/comments/delete/";
        $this->deleteUrl .= "{$this->id}/" . self::$token;
        return $this->deleteUrl;
    }


    /**
     * lien d'edition de commentaire
     * @return string
     */
    public function getEditUrl()
    {
        $this->editUrl =  "/comments/edit/";
        $this->editUrl .= "{$this->id}/" . self::$token;
        return $this->editUrl;
    }
}
