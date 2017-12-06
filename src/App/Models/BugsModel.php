<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;


class BugsModel extends Model
{

    protected $table = "bugs";

    public function lastByUnresolved()
    {
        return $this->query("SELECT * FROM {$this->table} WHERE status = 0 ORDER BY id DESC ");
    }




}