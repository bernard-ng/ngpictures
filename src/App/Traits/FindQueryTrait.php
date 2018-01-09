<?php
namespace Ngpictures\Traits;

trait FindQueryTrait {

	public function findLess($post_id)
    {
    	return $this->query("
    		SELECT {$this->table}.* , categories.title as category 
            FROM {$this->table} 
            LEFT JOIN categories ON category_id = categories.id
            WHERE (online = 1 AND {$this->table}.id < ?) ORDER BY id DESC LIMIT 0,5",
    		[$post_id]
    	);
    }

    public function find(int $id)
    {
        return $this->query("
            SELECT {$this->table}.*, categories.title as category 
            FROM {$this->table} 
            LEFT JOIN categories ON category_id = categories.id
            WHERE {$this->table}.id = ? ORDER BY date_created DESC LIMIT 0,1",
            [$id], true, true
        );
    }
}