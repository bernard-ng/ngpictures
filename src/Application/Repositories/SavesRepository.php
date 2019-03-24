<?php
namespace Application\Repositories;

use Application\Entities\SavesEntity;
use Framework\Repositories\Repository;

/**
 * Class SavesRepository
 * @package Application\Repositories
 */
class SavesRepository extends Repository
{

    /**
     * @var string $table
     */
    protected $table = 'saves';

    /**
     * @var
     */
    protected $entity = SavesEntity::class;


    /**
     * @param int $id
     * @return int|null
     */
    public function lastPostsIdWithUser(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.id")
            ->where("{$this->table}.users_id = ?", [$id])
            ->orderBy("id DESC")
            ->limit(1)
            ->all()->get(0)->postsId ?? null;
    }
}
