<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;



class NgGalleryModel extends Model
{

    protected $table = "ng_gallery";


    public function last()
    {
        return $this->query(
        	"SELECT * FROM {$this->table} ORDER BY date_created DESC LIMIT 0,1",
            null, true, true
        );
    }


    public function latest(int $from = 0, int $to = 4)
    {
        return $this->query("
            SELECT {$this->table}.*, categories.title as category 
            FROM {$this->table} 
            LEFT JOIN categories ON category_id = categories.id
            ORDER BY id DESC LIMIT {$from},{$to}",
            null, true, false 
        );
    }
}