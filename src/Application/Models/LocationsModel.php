<?php
namespace Application\Models;

use Framework\Models\Model;

class LocationsModel extends Model
{

    /**
     * le nom de la table
     * @var string
     */
    protected $table = "locations";


    /**
     * recupere les location de plusieur photographes
     *
     * @param string $list
     * @return void
     */
    public function findList(string $list)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE photographers_id IN ({$list})");
    }
}
