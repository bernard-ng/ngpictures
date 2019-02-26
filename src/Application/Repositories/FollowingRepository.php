<?php
namespace Application\Repositories;

use Application\Entity\FollowingsEntity;
use Framework\Repositories\Repository;
use Application\Application;
use Framework\Database\DatabaseInterface;
use Framework\Interfaces\SessionInterface;

/**
 * Class FollowingRepository
 * @package Application\Repositories
 */
class FollowingRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = "following";

    /**
     * @var string
     */
    protected $entity = FollowingsEntity::class;


    public function add(int $followed_id, int $follower_id)
    {
        return "INSERT INTO {$this->table} (followed_id, follower_id, date_created) VALUES(?,?,NOW())";
    }

    public function remove(int $followed_id, int $follower_id)
    {
        return "DELETE FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ";
    }

    public function countFollowers($user_id)
    {
        return "SELECT COUNT(follower_id) AS num FROM {$this->table} WHERE followed_id = ? ";
    }

    public function countFollowings($user_id)
    {
        return "SELECT COUNT(followed_id) AS num FROM {$this->table} WHERE follower_id = ? ";
    }

    public function isFollowed(int $id, $users_id = null) : bool
    {
        return "SELECT id FROM {$this->table} WHERE followed_id = ? AND follower_id = ?";
    }

    public function isMentionnedFollow(int $id) : string
    {
        return 1; //$this->isFollowed($id, $this->session->getValue(AUTH_KEY, 'id'));
    }
}
