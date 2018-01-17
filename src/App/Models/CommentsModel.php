<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;


class CommentsModel extends Model
{
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
    public function findWith(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY date_created DESC",[$value]);
    }
}
