<?php

declare(strict_types=1);

namespace Core\Database;

use Envms\FluentPDO\Query;

/**
 * Class Repository
 * @package Core\Database
 */
class Repository
{
    /**
     * @var Query
     */
    protected $query;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * Repository constructor.
     * @param \PDO $pdo
     */
    public function __construct(?\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->query = new Query($this->pdo);
    }


    public function all()
    {
        return $this->query->from('posts')->select('id')->execute()->fetchAll();
    }
}