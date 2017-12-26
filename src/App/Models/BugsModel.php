<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;


class BugsModel extends Model
{

    protected $table = "bugs";

    public function latest(int $start = 0, int $limit = 4)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE status = 0 ORDER BY id DESC LIMIT {$start},{$limit} "
        );
    }




}