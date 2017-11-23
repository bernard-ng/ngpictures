<?php
namespace Ngpic\Model;

use Core\Model\Model;


/**
 * Class FollowingModel
 * @package Ngpic\Model
 * @author Bernard ng
 */
class FollowingModel extends Model
{

    protected $table = "following";

    public function add(int $followed_id, int $follower_id)
    {
        return $this->query(
			"INSERT INTO {$this->table} (followed_id, follower_id, date_created) VALUES(?,?,NOW())",
            [$followed_id, $follower_id]
		);	
    }


    public function remove(int $followed_id, int $follower_id)
    {
        return $this->query(
			"DELETE FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
			[$followed_id, $follower_id],
			true, true
		);
    }


    public function getFollowers(int $user_id): int
    {
        return $this->query(
            "SELECT follower_id FROM {$this->table} WHERE followed_id = {$user_id}",
            [$user_id], true, false, true
        );
    }


    public function getFollowing(int $user_id): int
    {
        return $this->query(
            "SELECT followed_id FROM {$this->table} WHERE follower_id = {$user_id}",
            [$user_id], true, false, true
        );
    }


    public function isFollowed(int $followed_id, $user_id = null): bool
    {
        $req = $this->query(
            "SELECT id FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
            [$id,$user_id], true, true
        );
        
        if ($req) { return true; } 
        else { return false;   } 
    }


    public function isMentionnedFollow($id){
        if ($this->isFollowed($id, Ngpic::getInstance()->getSession()->getValue('auth','id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}