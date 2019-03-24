<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Entities;

use Framework\Auth\User;
use Framework\Entities\Entity;

/**
 * Class UsersEntity
 * @package Application\Entities
 */
class UsersEntity extends Entity implements User
{

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $avatar;

    /**
     * @var string the username
     */
    public $name;

    /**
     * compte les publication d'un user
     *
     * @return int
     */
    public function getPostsNumber()
    {
        return "{XXXX}";
    }


    /**
     * compte les followers d'un user
     *
     * @return int
     */
    public function getFollowersNumber()
    {
        return "{XXXX}";
    }

    /**
     * compte les followings d'un user
     *
     * @return int
     */
    public function getFollowingsNumber()
    {
        return "{XXXX}";
    }


    /**
     * compte les likes
     *
     * @return int
     */
    public function getLikesNumber()
    {
        return "{XXX}";
    }


    /**
     * compte les commentaires
     *
     * @return int
     */
    public function getCommentsNumber()
    {
        return "{XXX}";
    }

    /**
     * le lien vers le compte d'un user
     * @return mixed|string
     */
    public function getAccountUrl() : string
    {
        return "{XXX}";
    }

    /**
     * @return string
     */
    public function getAvatar() : string
    {
        return "/uploads/avatars/{$this->avatar}";
    }

    /**
     * Retrieve the username
     * @return string
     */
    public function getUsername(): string
    {
        return $this->name;
    }

    /**
     * Retrieve the roles/rank of the current user
     * @return array
     */
    public function getRoles(): array
    {
        // TODO: Implement getRoles() method.
    }
}
