<?php
namespace Application\Repositories;

use Application\Entities\PostsEntity;
use Framework\Repositories\Repository;

/**
 * Class PostsRepository
 * @package Application\Repositories
 */
class PostsRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = "posts";

    /**
     * @var string
     */
    protected $entity = PostsEntity::class;


    public function lastByCategory($categories_id)
    {
        return "SELECT * FROM {$this->table} WHERE categories_id = ?";
    }

    public function findWith(string $field, $value, $one = true)
    {
        return "SELECT * FROM {$this->table} WHERE {$field} = ? and online = 1 ORDER BY id DESC";
    }

    public function userFindLess($user_id, $post_id)
    {
        return "SELECT {$this->table}.* , categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE (online = 1 AND {$this->table}.users_id = ?) AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 8";
    }

    public function get($user_id, $limit)
    {
        return "SELECT * FROM {$this->table} WHERE users_id = ? AND online = 1 ORDER BY RAND() LIMIT ?";
    }

    public function count($user_id)
    {
        return "SELECT COUNT(id) AS num FROM {$this->table} WHERE users_id = ? AND online = 1";
    }

    public function findWithUser(int $id)
    {
        return "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE {$this->table}.users_id = ? ORDER BY id DESC LIMIT 8";
    }

    public function latest(int $from = 0, int $to = 4)
    {
        return "SELECT {$this->table}.*, categories.title as category, users.name as username
            FROM {$this->table}
            LEFT JOIN users ON users_id = users.id
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 1 ORDER BY id DESC LIMIT {$from},{$to}";
    }
}
