<?php
namespace Application\Repositories;

use Application\Entity\CollectionEntity;
use Framework\Repositories\Repository;

/**
 * Class CollectionRepository
 * @package Application\Repositories
 */
class CollectionRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = 'collections';

    /**
     * @var string
     */
    protected $entity = CollectionEntity::class;


    public function findLess($post_id)
    {
        return
            "SELECT * FROM {$this->table} WHERE online = 1 AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8";
    }


    public function get($limit)
    {
        return "SELECT * FROM {$this->table} WHERE online = 1 ORDER BY id DESC LIMIT $limit";
    }
}
