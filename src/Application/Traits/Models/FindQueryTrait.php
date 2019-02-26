<?php
namespace Application\Traits\Repositories;

trait FindQueryTrait
{

    public function findLess($post_id)
    {
        return "SELECT {$this->table}.* , categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 1 AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8";
    }

    public function find(int $id)
    {
        return "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE {$this->table}.id = ? ORDER BY date_created DESC LIMIT 0,1";
    }
}
