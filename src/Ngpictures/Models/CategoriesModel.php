<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\SearchQueryTrait;

class CategoriesModel extends Model
{

    use SearchQueryTrait;

    /**
     * le nom de la table
     * @var string
     */
    protected $table = "categories";


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
