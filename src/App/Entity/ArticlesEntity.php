<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;
use Ngpictures\Traits\Entity\PostEntityTrait;

class ArticlesEntity extends Entity
{
    private $file_path = "posts";
    private $action_type = 1;
    private $action_url = "articles";

    use PostEntityTrait;
}
