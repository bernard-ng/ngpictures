<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Traits\Models\FindQueryTrait;
use Ngpictures\Traits\Models\LastQueryTrait;

class GalleryModel extends Model
{
    use LastQueryTrait;
    use FindQueryTrait;

    /**
     * nom de la table
     * @var string
     */
    protected $table = "gallery";


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


    /**
     * recupere les publications grace aux htags
     *
     * @param string $tag
     * @return void
     */
    public function findWithTag(string $tag)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE CONCAT(description, tags) LIKE ? AND online = 1",
            ["%{$tag}%"]
        );
    }
}
