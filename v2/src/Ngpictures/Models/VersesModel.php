<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;

class VersesModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "verses";


    /**
     * renvoi le nombre de verset
     * @return int
     */
    public function getVersesNumber()
    {
        return $this->query(
            "SELECT COUNT(id) AS numbers FROM {$this->table}",
            null,
            true,
            true
        );
    }
}
