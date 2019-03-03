<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Repositories;

use Application\Entities\CategoriesEntity;
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
     * @param int $limit
     * @return mixed
     */
    public function get(int $limit)
    {
       return $this->makeQuery()
           ->into($this->entity)
           ->from($this->table)
           ->orderBy("{$this->table}.id DESC")
           ->limit($limit)
           ->all()->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findLess(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->orderBy("{$this->table}.id DESC")
            ->where("{$this->table}.id < ?", [$id])
            ->all()->get();
    }
}
