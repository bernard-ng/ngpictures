<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;


class IdeasModel extends Model
{

    protected $table = "ideas";

    public function latest(int $start = 0, int $limit = 4)
    {
        return $this->query(
            "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT {$start},{$limit} "
        );
    }
}