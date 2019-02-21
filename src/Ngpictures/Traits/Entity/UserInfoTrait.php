<?php
namespace Application\Traits\Entity;

use Application\Ngpictures;

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
        return $this->usersModel = Ngpictures::getDic()->get($this->model("users"))->find($id);
    }

    /**
     * permet d'avoir le nom d'un user
     * @return string
     */
    public function getUsername()
    {
        return $this->getUsersModel($this->users_id)->name;
    }


    /**
     * account url du user
     * @return string
     */
    public function getUserAccountUrl()
    {
        return $this->getUsersModel($this->users_id)->accountUrl;
    }


    /**
     * avatar thumb path
     *
     * @return string
     */
    public function getUserAvatarUrl(): string
    {
        return $this->getUsersModel($this->users_id)->avatarUrl;
    }

    /**
     * bio text
     *
     * @return string
     */
    public function getUserBio(): string
    {
        return $this->getUsersModel($this->users_id)->bio;
    }
}
