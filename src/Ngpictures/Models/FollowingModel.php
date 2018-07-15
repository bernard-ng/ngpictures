<?php
namespace Ngpictures\Models;

use Ng\Core\Models\Model;
use Ngpictures\Ngpictures;
use Ng\Core\Database\DatabaseInterface;
use Ng\Core\Interfaces\SessionInterface;

class FollowingModel extends Model
{

    public function __construct(DatabaseInterface $db)
    {
        parent::__construct($db);
        $this->session = Ngpictures::getDic()->get(SessionInterface::class);
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
     * count les followers
     *
     * @param int $user_id
     * @return void
     */
    public function countFollowers($user_id)
    {
        return $this->query(
            "SELECT COUNT(follower_id) AS num FROM {$this->table} WHERE followed_id = ? ",
            [$user_id],
            true,
            true
        );
    }


    /**
     * count les followings
     *
     * @param int $user_id
     * @return void
     */
    public function countFollowings($user_id)
    {
        return $this->query(
            "SELECT COUNT(followed_id) AS num FROM {$this->table} WHERE follower_id = ? ",
            [$user_id],
            true,
            true
        );
    }

    /**
     * le user est follow ?
     *
     * @param integer $id
     * @param int|null $users_id
     * @return boolean
     */
    public function isFollowed(int $id, $users_id = null) : bool
    {
        return boolval($req = $this->query(
            "SELECT id FROM {$this->table} WHERE followed_id = ? AND follower_id = ? ",
            [$id, $users_id],
            true,
            true
        ));
    }


    /**
     * le user est follow ?
     * methode pour les entity
     * @param int $id
     * @return string
     */
    public function isMentionnedFollow(int $id) : string
    {
        return $this->isFollowed($id, $this->session->getValue(AUTH_KEY, 'id'));
    }
}
