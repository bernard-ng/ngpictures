<?php
namespace Ngpictures\Entity;

use Ngpictures\Ngpictures;
use Ng\Core\Entity\Entity;

class CommentsEntity extends Entity
{
    /**
     * lien de suppression de commentaire
     * @return string
     */
    public function getDeleteUrl()
    {
        $session = Ngpictures::getInstance()->getSession();
        $this->deleteUrl = "/comments/delete/";
        $this->deleteUrl .= "{$this->id}/{$session->read(TOKEN_KEY)}";
        return $this->deleteUrl;
    }


    /**
     * lien d'edition de commentaire
     * @return string
     */
    public function getEditUrl()
    {
        $session = Ngpictures::getInstance()->getSession();
        $this->editUrl =  "/comments/edit/";
        $this->editUrl .= "{$this->id}/{$session->read(TOKEN_KEY)}";
        return $this->editUrl;
    }
}
