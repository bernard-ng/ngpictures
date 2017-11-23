<?php
namespace Ngpic\Model;
use Core\Model\Model;
use Core\Generic\Collection;
use \Ngpic;
/**
 * Class DislikesModel
 * @package Ngpic\Model
 * @author Bernard ng
 */
class DislikesModel extends Model
{

    protected $table = "dislikes";
    private $types = [ 1 => 'article_id','photo_id','ngarticle_id','ngphoto_id'];
    


    private function getType(int $type)
    {
        $types = new Collection($this->types);
        return $types->get($type);
    }

    public function setUserId(int $user_id)
    {
        return $this->user_id = $user_id;
    }


    /**
     * @param  integer $post_id the id of the post
     * @param integer $t the type of the post
     * @param int user_id
     * @return void
     */
    public function add(int $id, int $t, int $user_id)
    {
        return $this->query(
            "INSERT INTO {$this->table}(user_id,{$this->getType($t)},date_created) VALUES(?,?,NOW())",
            [$user_id,$id]
        );  
    }

    public function remove(int $id, int $t, int $user_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE {$this->getType($t)} = ? AND user_id = ? ",
            [$id,$user_id],
            true, true
        );
    }

    public function getDislikes(int $id, int $t): int
    {
        return $this->query(
            "SELECT id,user_id FROM {$this->table} WHERE {$this->getType($t)} = {$id}",
            [$id], true, false, true
        );
    }

    public function isDisliked(int $id, int $t, int $user_id = null): bool
    {
        $req = $this->query(
            "SELECT * FROM {$this->table} WHERE {$this->getType($t)} = ? AND user_id = ? ",
            [$id,$user_id],
            true, true
        );

        return ($req)? true : false;
    }

    public function getDislikeSentence(int $id, int $t): string
    {
        
        $isDisliked = $this->isDisliked($id,$t,Ngpic::getInstance()->getSession()->getValue('auth','id'));
        $dislikes =  $this->getDislikes($id,$t);
        $disliked = $dislikes - 1 ;

        if ($isDisliked && $dislikes > 2) {

            return "Vous et {$disliked} personnes n'aimez pas ça";

        } elseif ($isDisliked && $dislikes == 1 ) {

            return "Vous n'aimez pas ça";

        } elseif ($isDisliked && $dislikes == 2) {

            return "Vous et une autre personne n'aimez pas ça";

        } elseif (!$isDisliked && $dislikes >= 2) {

            return "{$dislikes} personnes n'aiment pas ça";

        } elseif (!$isDisliked && $dislikes == 1) {

            return "Une personne n'aime pas ça";

        } else {

            return "{$dislikes} je n'aime pas";
        }
    }

     public function isMentionnedDislike($id,$t){
        if ($this->isDisliked($id,$t,Ngpic::getInstance()->getSession()->getValue('auth','id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}
