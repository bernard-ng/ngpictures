<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;
use Ngpictures\Traits\FindQueryTrait;


class ArticlesModel extends Model
{

    protected $table = "articles";
    

    use FindQueryTrait;


    public function lastByUser($user_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY date_created DESC",[$user_id]);
    }


    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?",[$category_id]);
    }


}
