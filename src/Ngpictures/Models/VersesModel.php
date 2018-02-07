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
    public function getVersesNumber(): int
    {
        return (int) $this->query(
            "SELECT id FROM {$this->table}",
            null,
            true,
            false,
            true
        );
    }
}
