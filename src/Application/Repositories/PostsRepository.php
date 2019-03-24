<?php
namespace Application\Repositories;

use Application\Entities\PostsEntity;
use Framework\Database\Builder\Queries\Select;
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
            ->orderBy("created_at DESC")
            ->all()->get();
    }


    /**
     * @return Select
     */
    private function onlineWithCategory()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("categories.name AS category")
            ->where("{$this->table}.online = 1");
    }

    /**
     * @param int $categories_id
     * @param int $id
     * @return mixed
     */
    public function findWithSameCategory(int $categories_id, int $id)
    {
        return $this->onlineWithCategory()
            ->where("categories_id = ? AND {$this->table}.id <> ? ", [$categories_id, $id])
            ->orderBy("RAND()")->limit(8)->all()->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getLast(int $limit = 8)
    {
        return $this->onlineWithCategory()
            ->orderBy("{$this->table}.id DESC")
            ->limit($limit)->all()->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->onlineWithCategory()->where("{$this->table}.id = ? ", [$id])->all()->get(0);
    }

    /**
     * @param string $field
     * @param $value
     * @return int
     */
    public function countWith(string $field, $value): int
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.id")
            ->where("{$this->table}.{$field} = ? AND {$this->table}.online = 1", [$value])
            ->count();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findLess($id)
    {
        return $this->onlineWithCategory()
            ->where("{$this->table}.id < ? ", [$id])
            ->orderBy("{$this->table}.id DESC")->limit(8)->all()->get();
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
            ->where("{$this->table}.{$field} = ?", [$value])
            ->orderBy("{$this->table}.id DESC")
            ->all()->get();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getRandomWithUser(int $id)
    {
        return $this->onlineWithCategory()
            ->where("{$this->table}.users_id = ?", [$id])
            ->orderBy("RAND()")->limit(8)->all()->get();
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->makeQuery()
            ->from($this->table)
            ->select("{$this->table}.id")
            ->count();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function findWithUser(int $id)
    {
        return $this->onlineWithCategory()
            ->where("{$this->table}.users_id = ?", [$id])
            ->orderBy("{$this->table}.id DESC")
            ->limit(8)
            ->all()->get();
    }
}
