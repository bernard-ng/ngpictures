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
    public function count()
    {
        return $this->makeQuery()
            ->into($this->entity)
            ->from($this->table)
            ->select("{$this->table}.id")
            ->count();
    }

    public function search(string $query)
    {
    }

    public function findSimilars(int $id)
    {
        $sql = <<< SQL
"SELECT *
FROM {$this->table}
WHERE (categories_id = (
    SELECT categories_id
    FROM {$this->table}
    WHERE id = ?
) AND id <> ? ) AND online = 1
ORDER BY RAND() LIMIT 5 "
SQL;
    }

    public function findList(string $list)
    {
        $sql = <<< SQL
"SELECT * FROM {$this->table} WHERE id IN ({$list}) ORDER BY id DESC "
SQL;
    }

    public function findGreater(int $lastId, string $limit)
    {
        $sql = <<< SQL
"SELECT * FROM {$this->table} WHERE id < ? AND online = 1 ORDER BY id DESC LIMIT {$limit}"
SQL;
    }


    public function findWithId(string $field, $value)
    {
        $sql = <<< SQL
"SELECT * FROM {$this->table} WHERE id = ? AND {$field} = ?"
SQL;
    }


    public function latest(int $from = 0, int $to = 4)
    {
        $sql = <<< SQL
"SELECT {$this->table}.*, categories.title as category
FROM {$this->table}
LEFT JOIN categories ON categories_id = categories.id
WHERE online = 1 ORDER BY id DESC LIMIT {$from},{$to}"
SQL;
    }


    public function last()
    {
        $sql = <<< SQL
"SELECT {$this->table}.*, categories.title as category
FROM {$this->table}
LEFT JOIN categories ON categories_id = categories.id
WHERE online = 1 ORDER BY id DESC"
SQL;
    }


    public function random(int $limit)
    {
        $sql = <<< SQL
"SELECT * FROM {$this->table} WHERE online = 1 ORDER BY RAND() LIMIT {$limit}"
SQL;
    }


    public function lastOnline($limit = 5)
    {
        $sql = <<< SQL
"SELECT {$this->table}.*, categories.title as category
FROM {$this->table}
LEFT JOIN categories ON categories_id = categories.id
WHERE online = 1 ORDER BY id DESC LIMIT {$limit} "
SQL;
    }


    public function lastOffline($limit = 5)
    {
        $sql = <<< SQL
"SELECT {$this->table}.*, categories.title as category
FROM {$this->table}
LEFT JOIN categories ON categories_id = categories.id
WHERE online = 0 ORDER BY id DESC LIMIT {$limit} "
SQL;
    }


    public function orderBy(string $field, string $order = 'DESC', int $from = null, int $to = null)
    {
    }
}
