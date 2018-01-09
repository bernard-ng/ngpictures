<?php
namespace Ngpictures\Models;


use Ng\Core\Models\Model;

class VersesModel extends Model {

    protected $table = "verses";

    public function getVersesNumber(): int
    {
    	return (int) $this->query(
    		"SELECT id FROM {$this->table}",
    		null, true, false, true
    	);
    }
}
