<?php


namespace Ngpic\Model;

use Core\Model\Model;


/**
 * Class NggaleryModel
 * @package Ngpic\Model
 */
class NggaleryModel extends Model
{

    protected $table = "ng_galery";

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