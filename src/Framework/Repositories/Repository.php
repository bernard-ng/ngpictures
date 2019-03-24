<?php
namespace Framework\Repositories;

use Framework\Database\Builder\Query;

/**
 * Class Repository
 * @package Framework\Repositories
 */
class Repository
{

    /**
     * The entity of a repository, represent one record
     * @var string
     */
    protected $entity;

    /**
     * The name of the table in the database
     * @var string
     */
    protected $table;

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
     * Simplify instantiation of the queryBuilder
     * @return Query
     */
    protected function makeQuery()
    {
        return new Query($this->pdo);
    }

    /**
     * Store data
     * @param array $data
     * @return bool|int
     */
    public function create(array $data)
    {
        return $this->makeQuery()->insertInto($this->table, $data)->execute();
    }

    /**
     * Update data
     * @param int $id
     * @param array $data
     * @return bool|int|\PDOStatement
     */
    public function update(int $id, array $data)
    {
        return $this->makeQuery()->update($this->table, $data, $id)->execute();
    }

    /**
     * Delete data
     * @param int $id
     * @return mixed
     */
    public function destroy(int $id)
    {
        return $this->makeQuery()->delete($this->table, $id)->execute();
    }

    /**
     * Retrieve the last inserted id
     * @return string|int|mixed
     */
    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->orderBy("{$this->table}.id DESC")
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
            ->where("{$this->table}.id = ?", compact('id'))
            ->all()->get(0);
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
            ->where("{$this->table}.{$field} = ?", [$field => $value])
            ->all()->get();
    }

    /**
     * @return int
     */
    public function countAll()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.id")
            ->count();
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
            ->where("{$this->table}.{$field} = ?", [$value])
            ->count();
    }

    /**
     * @param int $lastId
     * @param string $limit
     */
    public function findGreater(int $lastId, string $limit)
    {
        $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.*")
            ->where("{$this->table}.id < ?", [$lastId])
            ->where("{$this->table}.online = 1")
            ->orderBy("{$this->table}.id DESC")
            ->limit($limit)
            ->all()->get();
    }
}
