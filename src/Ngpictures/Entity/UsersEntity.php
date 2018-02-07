<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ng\Core\Managers\StringManager;
use Ng\Core\Managers\Session;

class UsersEntity extends Entity
{
    /**
     * le lien vers le compte d'un user
     * @return mixed|string
     */
    public function getAccountUrl()
    {
        $this->accountUrl = "/account/".StringManager::slugify($this->name)."-{$this->id}";
        return $this->accountUrl;
    }


    /**
     * le lien vers l'edition du profile
     * @return mixed|string
     */
    public function getEditUrl()
    {
        $session = Session::getInstance();
        $this->editUrl = "/account/edit/".StringManager::slugify($this->name)."-{$this->id}/".$session->read(TOKEN_KEY);
        return $this->editUrl;
    }

    /**
     * le lien vers la liste des ses amies(followers)
     * @return mixed|string
     */
    public function getFriendsUrl()
    {
        $session = Session::getInstance();
        $this->friendsUrl = "/account/my-friends/".StringManager::slugify($this->name)."-{$this->id}/".$session->read(TOKEN_KEY);
        return $this->friendsUrl;
    }


    /**
     * le lien vers son avatar
     * @return mixed|string
     */
    public function getAvatarUrl()
    {
        $this->avatarUrl = "/uploads/avatars/{$this->avatar}";
        return $this->avatarUrl;
    }
}
