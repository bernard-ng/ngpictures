<?php
namespace Ngpic\Model;

use Core\Model\Model;
use Core\Generic\{Collection,Session};
use \Ngpic;

/**
 * Class LikesModel
 * @package Ngpic\Model
 * @author Bernard ng
 */
class LikesModel extends Model
{

    protected $table = "likes";
    private $types = [ 1 => 'article_id','photo_id','ngarticle_id','ngphoto_id'];
    


    private function getType(int $type)
    {
        $types = new Collection($this->types);
        return $types->get($type);
    }


    /**
     * @param  integer $post_id the id of the post
     * @param integer $t the type of the post
     * @param int user_id
     * @return void
     */
    public function add(int $id, int $t, $user_id)
    {
        return $this->query(
			"INSERT INTO {$this->table}(user_id,{$this->getType($t)},date_created) VALUES(?,?,NOW())",
            [$user_id,$id]
		);	
    }

    public function remove(int $id, int $t, $user_id)
    {
        return $this->query(
			"DELETE FROM {$this->table} WHERE {$this->getType($t)} = ? AND user_id = ? ",
			[$id,$user_id],
			true,
			true
		);
    }

    public function getLikes(int $id, int $t): int
    {
        return $this->query(
            "SELECT id,user_id FROM {$this->table} WHERE {$this->getType($t)} = {$id}",
            [$id], true, false, true
        );
    }

    public function isLiked(int $id, int $t, $user_id = null): bool
    {
        $req = $this->query(

            "SELECT * FROM {$this->table} WHERE {$this->getType($t)} = ? AND user_id = ? ",
            [$id,$user_id],
            true,
            true

        );
        if ($req) {
            return true;
        } else {
            return false;   
        } 
    }

    public function getLikeSentence(int $id, int $t): string
    {
        
        
        $isLiked = $this->isLiked($id,$t,Ngpic::getInstance()->getSession()->getValue('auth','id'));
        $likes =  $this->getLikes($id,$t);
        $liked = $likes - 1 ;

        if ($isLiked && $likes > 2) {

            return "Vous et {$liked} personnes aimez ça";

        } elseif ($isLiked && $likes == 1 ) {

            return "Vous aimez ça";

        } elseif ($isLiked && $likes == 2) {

            return "Vous et une autre personne aimez ça";

        } elseif (!$isLiked && $likes >= 2) {

            return "{$likes} personnes aiment ça";

        } elseif (!$isLiked && $likes == 1) {

            return "Une personne aime ça";

        } else {

            return "{$likes} j'aime";
        }
    }

    public function isMentionnedLike($id,$t){
        if ($this->isLiked($id,$t,Ngpic::getInstance()->getSession()->getValue('auth','id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}
