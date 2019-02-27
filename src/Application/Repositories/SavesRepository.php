<?php
namespace Application\Repositories;

use Application\Entities\SavesEntity;
use Framework\Repositories\Repository;

/**
 * Class SavesRepository
 * @package Application\Repositories
 */
class SavesRepository extends Repository
{

    /**
     * @var string $table
     */
    protected $table = 'saves';

    /**
     * @var
     */
    protected $entity = SavesEntity::class;


    public function isSaved(int $id, int $type): bool
    {
        return "SELECT * FROM {$this->table} WHERE {$this->getType($type)} = ? AND users_id = ? ";
    }

    public function getSaves(int $id, int $type): string
    {
        return "SELECT users_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}";
    }

    public function get(string $type, int $user_id)
    {
        return "SELECT * FROM {$this->table} WHERE users_id = ? AND {$type} IS NOT NULL";
    }
}
