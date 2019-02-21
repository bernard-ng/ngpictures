<?php
namespace Application\Models;

use Framework\Models\Model;
use Application\Traits\Models\FindQueryTrait;

class BlogModel extends Model
{

    use FindQueryTrait;

    /**
     * nom de la table
     * @var string
     */
    protected $table = "blog";


    /**
     * recupere un enregistrement avec une contrainte
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value, $one = true)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ? AND online = 1 ORDER BY id DESC",
            [$value],
            true,
            $one
        );
    }
}
