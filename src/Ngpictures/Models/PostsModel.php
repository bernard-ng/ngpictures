<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;
use Ngpictures\Traits\Models\SearchQueryTrait;

class PostsModel extends Model
{

    use FindQueryTrait;
    use SearchQueryTrait;

    /**
     * nom de la table
     * @var string
     */
    protected $table = "posts";


    /**
     * listage des publication par categories
     * @param $categories_id
     * @return mixed
     */
    public function lastByCategory($categories_id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE categories_id = ?", [$categories_id]);
    }


    /**
     * recupere un enregistrement avec une contrainte
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value, $one = true)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ? and online = 1 ORDER BY date_created DESC",
            [$value],
            true,
            $one
        );
    }


    public function get($user_id, $limit)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE users_id = ? AND online = 1 ORDER BY RAND() LIMIT ?",
            [$user_id, $limit]
        );
    }


    /**
     * find toute les publication du user selon la category
     *
     * @param int $id
     * @return void
     */
    public function findWithUser(int $id)
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE {$this->table}.users_id = ? ORDER BY date_created DESC LIMIT 0,5",
            [$id],
            true,
            false
        );
    }
}
