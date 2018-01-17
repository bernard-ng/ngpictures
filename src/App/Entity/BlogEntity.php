<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;
use Ngpictures\Traits\Entity\PostEntityTrait;

class BlogEntity extends Entity
{
    private $file_path = "blog";
    private $action_type = 3;
    private $action_url = "blog";

    use PostEntityTrait;
}
