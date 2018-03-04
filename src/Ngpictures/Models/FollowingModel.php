<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Ngpictures;
use Ng\Core\Database\MysqlDatabase;

class FollowingModel extends Model
{

    public function __construct(MysqlDatabase $db)
    {
        parent::__construct($db);
        $this->session = Ngpictures::getInstance()->getSession();
    }


    /**
     * nom de la table
     * @var string
     */
    protected $table = "following";


    /**
     * ajouter un follower
     * @param int $followed_id
     * @param int $follower_id
     * @return mixed
     */
    public function add(int $followed_id, int $follower_id)
    {
        return $this->query(
            "INSERT INTO {$this->table} (followed_id, follower_id, date_created) VALUES(?,?,NOW())",
            [$followed_id, $follower_id]
        );
    }


    /**
     * retire un follower
     * @param int $followed_id
     * @param int $follower_id
     * @return mixed
     */
    public function remove(int $followed_id, int $follower_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
            [$followed_id, $follower_id],
            true,
            true
        );
    }


    /**
     * le user est follow ?
     *
     * @param integer $id
     * @param int|null $user_id
     * @return boolean
     */
    public function isFollowed(int $id, $user_id = null): bool
    {
        $req = $this->query(
            "SELECT id FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
            [$id,$user_id],
            true,
            true
        );
        return ($req)? true : false;
    }


    /**
     * le user est follow ?
     * methode pour les entity
     * @param int $id
     * @return string
     */
    public function isMentionnedFollow(int $id): string
    {
        return $this->isFollowed($id, $this->session->getValue(AUTH_KEY, 'id'));
    }
}
