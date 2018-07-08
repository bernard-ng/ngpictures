<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ngpictures\Traits\Entity\PostEntityTrait;
use Ngpictures\Traits\Entity\UserInfoTrait;
use Ngpictures\Traits\Util\AuthTrait;

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
