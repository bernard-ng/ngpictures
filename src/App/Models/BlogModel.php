<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;



class BlogModel extends Model{


    protected $table = "blog";

 
    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?", $category_id);
    }


    public function findLess($id)
    {
    	return $this->query("
    		SELECT {$this->table}.* , categories.title as category 
            FROM {$this->table} 
            LEFT JOIN categories ON category_id = categories.id
            WHERE (online = 1 AND {$this->table}.id < ?) ORDER BY id DESC LIMIT 0,5",
    		[$id]
    	);
    }

}