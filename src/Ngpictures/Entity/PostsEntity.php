<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ngpictures\Traits\Entity\PostEntityTrait;
use Ngpictures\Traits\Entity\UserInfoTrait;

class PostsEntity extends Entity
{
    private $file_path = "posts";
    private $action_type = 1;
    private $action_url = "posts";

    use PostEntityTrait;
    use UserInfoTrait;
}
