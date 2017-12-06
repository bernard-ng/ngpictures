<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;


class CommentsModel extends Model
{
    protected $table = "comments";

    public function findWith(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY date_created DESC",[$value]);
    }
}