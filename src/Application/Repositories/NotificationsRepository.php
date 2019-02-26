<?php
namespace Application\Repositories;

use Framework\Repositories\Repository;

class NotificationsRepository extends Repository
{

    /**
     * @inheritDoc
     */
    protected $table = "notifications";


    public function add(int $type, $notification, $user_id, $pub_id)
    {
        return $this->query(
            "INSERT INTO {$this->table} SET type = ?, notification = ?, users_id = ?, publication_id = ?, date_created = NOW()",
            [$type, $notification, $user_id, $pub_id]
        );
    }


    /**
     * exist-il une notification ?
     *
     * @param integer $type
     * @param string $notification
     * @param integer $user_id
     * @return boolean
     */
    public function hasNotification(int $type, string $notification, int $user_id): bool
    {
        return boolval($this->query(
            "SELECT * FROM {$this->table} WHERE type = ? and (notification = ? and users_id = ?)",
            [$type, $notification, $user_id]
        ));
    }


    /**
     * marque les notifications comme lues
     *
     * @param integer $user_id
     * @return void
     */
    public function setRead(int $user_id)
    {
        return $this->query(
            "UPDATE {$this->table} SET status = 1 WHERE users_id = ? ",
            [$user_id]
        );
    }


    public function count($user_id)
    {
        return $this->query(
            "SELECT COUNT(id) AS num FROM {$this->table} WHERE seen = 0 AND users_id = ?",
            [$user_id],
            true,
            true
        );
    }

    /**
     * supprime toutes les notifcations d'un user
     *
     * @param integer $user_id
     * @return void
     */
    public function delete(int $user_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE users_id = ? ",
            [$user_id]
        );
    }
}
