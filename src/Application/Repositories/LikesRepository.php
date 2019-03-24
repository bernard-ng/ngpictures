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


    /**
     * @param int $id
     * @return int|null
     */
    public function lastPostsIdWithUser(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->where("{$this->table}.users_id = ?", [$id])
            ->orderBy("id DESC")
            ->limit(1)
            ->all()->get(0)->postsId ?? null;
    }
}
