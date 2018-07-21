<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;

class PostsModel extends Model
{

    use FindQueryTrait;

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
            "SELECT * FROM {$this->table} WHERE {$field} = ? and online = 1 ORDER BY id DESC",
            [$value],
            true,
            $one
        );
    }


    public function userFindLess($user_id, $post_id)
    {
        return $this->query(
            "SELECT {$this->table}.* , categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE (online = 1 AND {$this->table}.users_id = ?) AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8",
            [$user_id, $post_id]
        );
    }


    public function get($user_id, $limit)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE users_id = ? AND online = 1 ORDER BY RAND() LIMIT ?",
            [$user_id, $limit]
        );
    }


    public function count($user_id)
    {
        return $this->query(
            "SELECT COUNT(id) AS num FROM {$this->table} WHERE users_id = ? AND online = 1",
            [$user_id],
            true,
            true
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
            WHERE {$this->table}.users_id = ? ORDER BY id DESC LIMIT 8",
            [$id]
        );
    }
}
