<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;



class ArticlesModel extends Model
{

    protected $table = "articles";


    public function lastByUser($user_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY date_created DESC",[$user_id]);
    }


    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?",[$category_id]);
    }


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
}
