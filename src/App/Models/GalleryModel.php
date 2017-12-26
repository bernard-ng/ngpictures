<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;


class GalleryModel extends Model
{

    protected $table = "gallery";


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