<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;


class ArticlesModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "articles";
    

    use FindQueryTrait;


    /**
     * @param $user_id
     * @return mixed
     */
    public function lastByUser($user_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY date_created DESC",[$user_id]);
    }


    /**
     * @param $category_id
     * @return mixed
     */
    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?",[$category_id]);
    }
}
