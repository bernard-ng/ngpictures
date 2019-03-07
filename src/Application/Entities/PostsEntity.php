<?php
namespace Application\Entities;

use Framework\Entities\Entity;

/**
 * Class PostsEntity
 * @package Application\Entities
 */
class PostsEntity extends Entity
{

    /**
     * @var string
     */
    public $thumb;

    /**
     * @var string
     */
    public $thumbOld;

    /**
     * @return string
     */
    public function getThumb(): string
    {
        return ($this->thumb)?
            "/uploads/posts/{$this->thumb}" :
            "/uploads/gallery/{$this->thumbOld}";
    }

    /**
     * @return string
     */
    public function getSmallThumb(): string
    {
        return ($this->thumb)?
            "/uploads/posts/thumbs/{$this->thumb}" :
            "/uploads/gallery/thumbs/{$this->thumbOld}";
    }
}
