<?php
namespace Application\Traits\Repositories;

trait LastQueryTrait
{

    public function last()
    {
        return "SELECT * FROM {$this->table} WHERE online = 1 ORDER BY date_created DESC LIMIT 0,1";
    }

    public function latest(int $from = 0, int $to = 4)
    {
        return "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE {$this->table}.online = 1
            ORDER BY id DESC LIMIT {$from},{$to}";
    }
}
