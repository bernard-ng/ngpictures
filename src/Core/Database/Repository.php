<?php

declare(strict_types=1);

namespace Core\Database;

use App\Repositories\PostsRepository;


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
    }


    public function all()
    {
        return (new Query($this->pdo))
            ->into(PostsRepository::class)
            ->from('posts')
            ->select('id')
            ->getQuery(false);
    }
}