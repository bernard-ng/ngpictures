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


    /**
     * @return mixed
     */
    public function all()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->orderBy("{$this->table}.created_at DESC")
            ->all()->get();
    }


    public function findWithSameCategory($categories_id, $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->where("categories_id = ? AND id <> ? AND online = 1", [$categories_id, $id])
            ->orderBy("RAND()")
            ->limit(8)
            ->all()->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getLast(int $limit)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->orderBy("{$this->table}.id DESC")
            ->limit($limit)
            ->all()->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->select("categories.name AS category")
            ->where("{$this->table}.id = ?", [$id])
            ->all()->get(0);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findLess($id)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->select("categories.name AS category")
            ->where("{$this->table}.id < ?", [$id])
            ->where("{$this->table}.online = 1")
            ->orderBy("{$this->table}.id DESC")
            ->limit(8)
            ->all()->get();
    }

    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->orderBy("{$this->table}.id DESC")
            ->where("{$this->table}.{$field} = ?", [$value])
            ->all()->get();
    }

    /**
     * @param string $field
     * @param $value
     * @return int
     */
    public function countWith(string $field, $value)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.{$field} = ?", [$value])
            ->count();
    }

    public function userFindLess($user_id, $post_id)
    {
    }

    public function gets($user_id, $limit)
    {
    }

    public function count()
    {
    }

    public function findWithUser(int $id)
    {
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function latest(int $limit = 8)
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("categories.name as category")
            ->orderBy("{$this->table}.id DESC")
            ->limit($limit)
            ->all()->get();
    }
}
