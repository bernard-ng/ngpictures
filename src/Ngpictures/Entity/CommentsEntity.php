<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ngpictures\Ngpictures;
use Ng\Core\Interfaces\SessionInterface;

class CommentsEntity extends Entity
{
    /**
     * lien de suppression de commentaire
     * @return string
     */
    public function getDeleteUrl()
    {
        $session = Ngpictures::getDic()->get(SessionInterface::class);
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
        $session = Ngpictures::getDic()->get(SessionInterface::class);
        $this->editUrl =  "/comments/edit/";
        $this->editUrl .= "{$this->id}/{$session->read(TOKEN_KEY)}";
        return $this->editUrl;
    }
}
