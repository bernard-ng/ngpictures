<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;



class BlogModel extends Model{

    /**
     * nom de la table
     * @var string
     */
    protected $table = "blog";


    /**
     * trouve des publications en desc pour le scroll ajax
     * @param $id
     * @return mixed
     */
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


    /**
     * recupere un enregistrement
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->query("
            SELECT {$this->table}.*, categories.title as category 
            FROM {$this->table} 
            LEFT JOIN categories ON category_id = categories.id
            WHERE {$this->table}.id = ? ",
           [$id], true, true
        );
    }

}