<?php
namespace Application\Entity;

use Framework\Entity\Entity;
use Application\Traits\Entity\PostEntityTrait;
use Application\Traits\Entity\UserInfoTrait;
use Application\Traits\Util\AuthTrait;

class PostsEntity extends Entity
{
    private $file_path = "posts";
    private $action_type = 1;
    private $action_url = "posts";

    use PostEntityTrait;
    use UserInfoTrait;
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