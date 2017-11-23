<?php


namespace Ngpic\Model;

use Core\Model\Model;


/**
 * Class GaleryModel
 * @package Ngpic\Model
 */
class GaleryModel extends Model
{

    protected $table = "galery";

    public function isLiked(int $id,int $type,int $user_id): bool
    {
        return true;
    }

    public function isDisliked(int $id,int $type,int $user_id): bool
    {
        return true;
    }

    public function getLikes(int $id,int $type)
    {

    }

    public function getDislikes(int $id,int $type)
    {
        
    }
}