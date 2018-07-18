<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;

class CategoriesModel extends Model
{

    /**
     * le nom de la table
     * @var string
     */
    protected $table = "categories";



    public function findLess($post_id)
    {
        return $this->query(
            "SELECT * FROM {$this->table}
            WHERE {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 4",
            [$post_id]
        );
    }


    /**
     * recupere un enregistrement avec une contrainte
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value, $one = true)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ? AND online = 1",
            [$value],
            true,
            $one
        );
    }
}
