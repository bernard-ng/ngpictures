<?php
namespace Application\Models;

use Framework\Models\Model;

class BugsModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "bugs";


    /**
     * les dernier bugs du site
     * @param int $start
     * @param int $limit
     * @return mixed
     */
    public function latest(int $start = 0, int $limit = 4)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE status = 0 ORDER BY id DESC LIMIT {$start},{$limit} "
        );
    }
}
