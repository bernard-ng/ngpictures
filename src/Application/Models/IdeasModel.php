<?php
namespace Application\Models;

use Framework\Models\Model;

class IdeasModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "ideas";

    /**
     * les dernieres idees
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function latest(int $start = 0, int $limit = 4)
    {
        return $this->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT {$start},{$limit} "
        );
    }
}
