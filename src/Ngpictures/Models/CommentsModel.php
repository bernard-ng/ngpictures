<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ng\Core\Managers\Collection;
use Ngpictures\Traits\Util\TypesActionTrait;

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
    public function findWith(string $field, $value, $one = true)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY date_created DESC",
            [$value],
            true,
            $one
        );
    }


    /**
     * renvoi le nombre de commentaire
     *
     * @param integer $id
     * @param string $type
     * @return void
     */
    public function getNumber(int $id, string $type)
    {
        return $this->query(
            "SELECT id FROM {$this->table} WHERE {$this->getType($type)} = {$id}",
            [$id],
            true,
            false,
            true
        );
    }
}
