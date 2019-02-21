<?php
namespace Application\Entity;

use Framework\Entity\Entity;
use Application\Ngpictures;
use Application\Traits\Util\AuthTrait;
use Framework\Interfaces\SessionInterface;

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
