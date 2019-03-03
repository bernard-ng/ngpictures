<?php
namespace Application\Repositories;

use Application\Entities\CollectionsEntity;
use Framework\Repositories\Repository;

/**
 * Class CollectionRepository
 * @package Application\Repositories
 */
class CollectionsRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'collections';

    /**
     * @var string
     */
    protected $entity = CollectionsEntity::class;


    /**
     * @param int $id
     * @return mixed
     */
    public function findLess(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->where("{$this->table}.id < ?  AND {$this->table}.online = 1", [$id])
            ->orderBy("{$this->table}.id DESC")
            ->limit(8)
            ->all()->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function get(int $limit)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->where("{$this->table}.online = 1")
            ->orderBy("{$this->table}.id DESC")
            ->limit($limit)
            ->all()->get();
    }
}
