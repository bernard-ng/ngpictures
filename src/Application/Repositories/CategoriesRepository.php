<?php
namespace Application\Repositories;

use Application\Entity\CategoriesEntity;
use Framework\Repositories\Repository;

/**
 * Class CategoriesRepository
 * @package Application\Repositories
 */
class CategoriesRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = "categories";

    /**
     * @var string
     */
    protected $entity = CategoriesEntity::class;


    /**
     * @param $post_id
     */
    public function findLess($post_id)
    {
        $sql = <<< SQL
SELECT * FROM {$this->table}
WHERE {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8
SQL;

    }


    /**
     * @param string $field
     * @param $value
     * @param bool $one
     * @return mixed|void
     */
    public function findWith(string $field, $value, $one = true)
    {
        $sql = <<< SQL
SELECT * FROM {$this->table} WHERE {$field} = ? AND online = 1
SQL;

    }
}
