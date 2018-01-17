<?php
namespace Ngpictures\Traits\Models;


trait LastQueryTrait
{
    /**
     * derniere publication
     * @return mixed
     */
    public function last()
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE online = 1 ORDER BY date_created DESC LIMIT 0,1",
            null, true, true
        );
    }


    /**
     * les derniere publication
     * @param int $from
     * @param int $to
     * @return mixed
     */
    public function latest(int $from = 0, int $to = 4)
    {
        return $this->query("
            SELECT {$this->table}.*, categories.title as category 
            FROM {$this->table} 
            LEFT JOIN categories ON category_id = categories.id
            WHERE {$this->table}.online = 1
            ORDER BY id DESC LIMIT {$from},{$to}",
            null, true, false
        );
    }
}