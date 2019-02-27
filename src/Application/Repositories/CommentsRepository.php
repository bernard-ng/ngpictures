<?php
namespace Application\Repositories;

use Application\Entities\CommentsEntity;
use Framework\Repositories\Repository;
use Application\Traits\Util\TypesActionTrait;

/**
 * Class CommentsRepository
 * @package Application\Repositories
 */
class CommentsRepository extends Repository
{
    use TypesActionTrait;

    /**
     * @var string
     */
    protected $table = "comments";

    /**
     * @var string
     */
    protected $entity = CommentsEntity::class;


    /**
     * @param $id
     * @param string $field
     * @param $start
     * @param $end
     * @return string
     */
    public function get(int $id, string $field, int $start, int $end)
    {
        return "SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY date_created DESC LIMIT {$start}, {$end}";
    }


    /**
     * @param int $id
     * @param string $type
     * @return mixed
     */
    public function count(int $id, string $type)
    {
        return "SELECT COUNT('id') AS num FROM {$this->table} WHERE {$type} = {$id}";
    }

    public function countComments($user_id)
    {
        return "SELECT COUNT('id') as num FROM {$this->table} WHERE users_id = ?";
    }
}
