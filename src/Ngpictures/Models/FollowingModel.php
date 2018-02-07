<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;

class FollowingModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "following";


    /**
     * ajouter un follower
     * @param int $followed_id
     * @param int $follower_id
     * @return mixed
     */
    public function add(int $followed_id, int $follower_id)
    {
        return $this->query(
            "INSERT INTO {$this->table} (followed_id, follower_id, date_created) VALUES(?,?,NOW())",
            [$followed_id, $follower_id]
        );
    }


    /**
     * retire un follower
     * @param int $followed_id
     * @param int $follower_id
     * @return mixed
     */
    public function remove(int $followed_id, int $follower_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
            [$followed_id, $follower_id],
            true,
            true
        );
    }

    /**
     * check si un user suis un autre
     * @param int $followed_id
     * @param null $user_id
     * @return bool
     */
    public function isFollowed(int $followed_id, $user_id = null): bool
    {
        $req = $this->query(
            "SELECT id FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
            [$followed_id,$user_id],
            true,
            true
        );
        
        return ($req)? true : false ;
    }
}
