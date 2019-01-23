<?php

declare(strict_types=1);

namespace Core\Database;

use App\Entities\PostEntity;
use App\Repositories\PostsRepository;
use Core\Database\Builder\Query;


/**
 * Class Repository
 * @package Core\Database
 */
class Repository
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $entity;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Repository constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    /**
     * simplify instanciation of the queryBuilder
     * @return Query
     */
    protected function makeQuery()
    {
        return new Query($this->pdo);
    }


    /**
     * @return QueryResult
     */
    public function all(): QueryResult
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select('id')
            ->where("{$this->table}.users_id = ?", ['id' => 1])
            ->all();
    }
}