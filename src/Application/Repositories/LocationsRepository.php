<?php
namespace Application\Repositories;

use Application\Entities\LocationsEntity;
use Framework\Repositories\Repository;

class LocationsRepository extends Repository
{
    /**
     * @var string
     */
    protected $table = "locations";

    /**
     * @var string
     */
    protected $entity = LocationsEntity::class;


    public function findList(string $list)
    {
        return "SELECT * FROM {$this->table} WHERE photographers_id IN ({$list})";
    }
}
