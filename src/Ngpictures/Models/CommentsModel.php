<?php
namespace Application\Models;

use Framework\Models\Model;
use Framework\Managers\Collection;
use Application\Traits\Util\TypesActionTrait;

class CommentsModel extends Model
{
    use TypesActionTrait;

    /**
     * nom de la table
     * @var string
     */
    protected $table = "comments";


    /**
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function get($id, string $field, $start, $end)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY date_created DESC LIMIT {$start}, {$end}",
            [$id],
            true,
            false
        );
    }


    /**
     * renvoi le nombre de commentaire
     *
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function count(int $id, string $type)
    {
        return $this->query(
            "SELECT COUNT('id') AS num FROM {$this->table} WHERE {$type} = {$id}",
            [$id],
            true,
            true
        );
    }

    public function countComments($user_id)
    {
        return $this->query(
            "SELECT COUNT('id') as num FROM {$this->table} WHERE users_id = ?",
            [$user_id],
            true,
            true
        );
    }
}
