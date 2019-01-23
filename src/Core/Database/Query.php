<?php
namespace Core\Database;

use Core\Database\Builder\Query as QueryBuilder;


/**
 * Class Query
 * @package Core\Database
 */
class Query extends QueryBuilder
{

    /**
     * @var string
     */
    private $entity;

    /**
     * Add the entity which will be hydrated after the query
     * @param string $entity
     * @return Query
     */
    public function into(string $entity): self
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * counts records
     * @return int|null
     */
    public function count(): ?int
    {
        $count = $this->from('posts')->count();
    }
}