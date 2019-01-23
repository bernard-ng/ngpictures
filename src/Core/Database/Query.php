<?php
namespace Core\Database;


use Envms\FluentPDO\Query as EnvmsQuery;


/**
 * Class Query
 * @package Core\Database
 */
class Query extends EnvmsQuery
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
}