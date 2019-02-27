<?php
namespace Application\Repositories;

use Application\Entities\LikesEntity;
use Framework\Repositories\Repository;

/**
 * @property \Framework\Managers\SessionManager session
 */
class LikesRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = "likes";

    /**
     * @var string
     */
    protected $entity = LikesEntity::class;


    public function add(int $id, int $type, $users_id)
    {
        return "INSERT INTO {$this->table}(users_id,{$this->getType($type)},date_created) VALUES(?,?,NOW())";
    }

    public function remove(int $id, int $type, $users_id)
    {
        return "DELETE FROM {$this->table} WHERE {$this->getType($type)} = ? AND users_id = ? ";
    }

    public function getLikes(int $id, int $type) : int
    {
        return "SELECT users_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}";
    }

    public function getLikers(int $id, int $type)
    {
        return "SELECT users_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}";
    }


    public function isLiked(int $id, int $t, $users_id = null) : bool
    {
       return "SELECT * FROM {$this->table} WHERE {$this->getType($t)} = ? AND users_id = ? ";
    }


    public function getLikeSentence(int $id, int $type) : string
    {

    }

    public function isMentionnedLike(int $id, int $type) : string
    {

    }

    public function count($user_id)
    {
        return "SELECT COUNT('id') as num FROM {$this->table} WHERE users_id = ?";
    }
}
