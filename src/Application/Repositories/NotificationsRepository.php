<?php
namespace Application\Repositories;

use Application\Entities\NotificationsEntity;
use Framework\Repositories\Repository;

class NotificationsRepository extends Repository
{

    /**
     * @var string
     */
    protected $table = "notifications";

    /**
     * @var string
     */
    protected $entity = NotificationsEntity::class;


    public function add(int $type, $notification, $user_id, $pub_id)
    {
        return "INSERT INTO {$this->table} SET type = ?, notification = ?, users_id = ?, publication_id = ?, date_created = NOW()";
    }

    public function hasNotification(int $type, string $notification, int $user_id): bool
    {
        return "SELECT * FROM {$this->table} WHERE type = ? and (notification = ? and users_id = ?)";
    }

    public function setRead(int $user_id)
    {
        return "UPDATE {$this->table} SET status = 1 WHERE users_id = ? ";
    }

    public function count($user_id)
    {
        return "SELECT COUNT(id) AS num FROM {$this->table} WHERE seen = 0 AND users_id = ?";
    }

    public function delete(int $user_id)
    {
        return "DELETE FROM {$this->table} WHERE users_id = ? ";
    }
}
