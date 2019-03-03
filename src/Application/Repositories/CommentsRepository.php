<?php
namespace Application\Repositories;

use Application\Entities\CommentsEntity;
use Framework\Repositories\Repository;

/**
 * Class CommentsRepository
 * @package Application\Repositories
 */
class CommentsRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = "comments";

    /**
     * @var string
     */
    protected $entity = CommentsEntity::class;


    /**
     * @param int $id
     * @return int
     */
    public function count(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.id")
            ->where("posts_id = ?", [$id])
            ->count();
    }

    /**
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function get(int $id, int $limit = 8)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("users.name AS users")
            ->where("{$this->table}.posts_id = ?", [$id])
            ->limit($limit)
            ->all()->get();
    }


    public function countComments($user_id)
    {

    }
}
