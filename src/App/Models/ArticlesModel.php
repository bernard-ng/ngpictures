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
}
