<?php
namespace Ngpictures\Traits\Entity;


use Ngpictures\Ngpictures;

trait UserInfoTrait
{

    /**
     * le model qui contient les info
     * sur les users
     * @var null
     */
    private $usersModel = null;

    private function getUsersModel(int $id)
    {
       return $this->usersModel= Ngpictures::getInstance()
           ->getModel("users")
           ->find($id);
    }

    /**
     * permet d'avoir le nom d'un user
     * @return string
     */
    public function getUsername()
    {
        return $this->getUsersModel($this->user_id)->name;
    }


    /**
     * @return string
     */
    public function getUserAccountUrl()
    {
        return $this->getUsersModel($this->user_id)->accountUrl;
    }


    public function getUserAvatarUrl()
    {
        return $this->getUsersModel($this->user_id)->avatarUrl;
    }

    public function getUserBio()
    {
        return $this->getUsersModel($this->user_id)->bio;
    }
}