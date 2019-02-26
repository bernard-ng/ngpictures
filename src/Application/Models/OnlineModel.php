<?php
namespace Application\Models;

use Framework\Models\Model;

class OnlineModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "online";


    /**
     * supprime les users offline
     * @param int $time
     * @return  mixed
     */
    public function delete(int $time)
    {
        return $this->query(
            "DELETE FROM {$this->online} WHERE online_time < ?",
            [$time]
        );
    }
}
