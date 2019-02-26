<?php
namespace Application\Repositories;

use Framework\Repositories\Repository;

class AlbumsRepository extends Repository
{


    /**
     * le nom de la table
     * @var string $table
     */
    protected $table = 'albums';


    public function findLess($post_id)
    {
        return $this->query(
            "SELECT * FROM {$this->table}
            WHERE online = 1 AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8",
            [$post_id]
        );
    }


    public function get($limit)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE online = 1 ORDER BY id DESC LIMIT $limit"
        );
    }
}
