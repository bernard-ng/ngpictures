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


    public function all()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->orderBy("{$this->table}.created_at DESC")
            ->all()->get();
    }


    public function lastByCategory($categories_id)
    {
    }

    public function findWith(string $field, $value)
    {
    }

    public function userFindLess($user_id, $post_id)
    {
    }

    public function get($user_id, $limit)
    {
    }

    public function count()
    {
    }

    public function findWithUser(int $id)
    {
    }

    public function latest(int $from = 0, int $to = 4)
    {
    }
}
