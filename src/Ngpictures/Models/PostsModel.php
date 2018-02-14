<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;
use Ngpictures\Traits\Models\SearchQueryTrait;

class PostsModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "posts";


    use FindQueryTrait;
    use SearchQueryTrait;


    /**
     * @param $user_id
     * @return mixed
     */
    public function lastByUser($user_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY date_created DESC", [$user_id]);
    }


    /**
     * @param $category_id
     * @return mixed
     */
    public function lastByCategory($category_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE category_id = ?", [$category_id]);
    }


    public function findWithUser($id)
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON category_id = categories.id
            WHERE {$this->table}.user_id = ? ORDER BY date_created DESC LIMIT 0,5",
            [$id],
            true,
            false
        );
    }
}
