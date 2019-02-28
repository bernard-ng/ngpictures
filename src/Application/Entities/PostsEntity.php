<?php
namespace Application\Entities;

use Framework\Entities\Entity;
use Application\Traits\Entities\PostEntityTrait;
use Application\Traits\Entities\UserInfoTrait;
use Application\Traits\Util\AuthTrait;

class PostsEntity extends Entity
{
    use AuthTrait;

    public function getEditUrl()
    {
        $this->editUrl = "/my-posts/edit";
        $this->editUrl .= "/{$this->id}/" . self::$token;
        return $this->editUrl;
    }

    public function getDeleteUrl()
    {
        $this->deleteUrl = "/my-posts/delete";
        $this->deleteUrl .= "/{$this->id}/" . self::$token;
        return $this->deleteUrl;
    }
}
