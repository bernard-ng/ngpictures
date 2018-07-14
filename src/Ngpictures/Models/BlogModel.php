<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;

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
            "SELECT * FROM {$this->table} WHERE {$field} = ? and online = 1",
            [$value],
            true,
            $one
        );
    }
}
