<?php
namespace Core\Database;

use Envms\FluentPDO\Query;

/**
 * Class Table
 * @package Core\Database
 */
class Table
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
     * Table constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->query = new Query($this->pdo);
    }
}