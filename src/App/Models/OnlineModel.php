<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;



class OnlineModel extends Model
{
    protected $table = "online";


    public function delete(int $time)
    {
    	$this->query(
    		"DELETE FROM {$this->online} WHERE online_time < ?",
    		[$time]
    	);
    }
}