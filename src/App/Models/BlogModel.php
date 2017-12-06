<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;



class BlogModel extends Model{


    protected $table = "blog";

 
    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?", $category_id);
    }

}