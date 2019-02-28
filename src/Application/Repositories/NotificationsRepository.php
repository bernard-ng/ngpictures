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
    }

    public function hasNotification(int $type, string $notification, int $user_id): bool
    {
    }

    public function setRead(int $user_id)
    {
    }

    public function count()
    {
    }

    public function delete(int $user_id)
    {
    }
}
