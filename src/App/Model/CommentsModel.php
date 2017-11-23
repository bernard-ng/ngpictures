<?php
namespace Ngpic\Model;

use Core\Model\Model;


/**
 * Class CommentsModel
 * @package Ngpic\Model
 * @author Bernard ng
 */
class CommentsModel extends Model
{
    protected $table = "comments";

    public function findWith(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$field} = ? ORDER BY date_created DESC",[$value]);
    }
}