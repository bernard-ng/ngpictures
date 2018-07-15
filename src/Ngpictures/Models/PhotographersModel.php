<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;

class PhotographersModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "photographers";


    public function all()
    {
        return $this->query(
            "SELECT {$this->table}.*, users.name as name
            FROM {$this->table}
            LEFT JOIN users ON {$this->table}.users_id = users.id
            ORDER BY {$this->table}.id DESC ",
            null,
            true,
            false
        );
    }
}
