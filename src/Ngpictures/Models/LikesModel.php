<?php
namespace Ngpictures\Models;

use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Models\Model;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Util\TypesActionTrait;

/**
 * @property \Ng\Core\Managers\SessionManager session
 */
class LikesModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "likes";


    use TypesActionTrait;


    /**
     * LikesModel constructor.
     * @param MysqlDatabase $db
     */
    public function __construct(MysqlDatabase $db)
    {
        parent::__construct($db);
        $this->session = Ngpictures::getInstance()->getSession();
    }


    /**
     * ajoute un like
     * @param int $id
     * @param int $type
     * @param $users_id
     * @return mixed
     */
    public function add(int $id, int $type, $users_id)
    {
        return $this->query(
            "INSERT INTO {$this->table}(users_id,{$this->getType($type)},date_created) VALUES(?,?,NOW())",
            [$users_id,$id]
        );
    }


    /**
     * retire un like
     * @param int $id
     * @param int $type
     * @param $users_id
     * @return mixed
     */
    public function remove(int $id, int $type, $users_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE {$this->getType($type)} = ? AND users_id = ? ",
            [$id,$users_id],
            true,
            true
        );
    }


    /**
     * renvoi le nom de likes
     *
     * @param integer $id
     * @param integer $type
     * @return integer
     */
    public function getLikes(int $id, int $type): int
    {
        return $this->query(
            "SELECT id,users_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}",
            [$id],
            true,
            false,
            true
        );
    }


    /**
     * renvoi les ids de likers
     *
     * @param integer $id
     * @param integer $type
     * @return void
     */
    public function getLikers(int $id, int $type)
    {
        return $this->query(
            "SELECT users_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}",
            [$id],
            true,
            false,
            false
        );
    }


    /**
     * permet de savoir si un user aime la publication
     *
     * @param integer $id
     * @param integer $t
     * @param int|null $users_id
     * @return boolean
     */
    public function isLiked(int $id, int $t, $users_id = null): bool
    {
        $req = $this->query(

            "SELECT * FROM {$this->table} WHERE {$this->getType($t)} = ? AND users_id = ? ",
            [$id,$users_id],
            true,
            true
        );
        return ($req)? true : false;
    }


    /**
     * renvoi un jolie wordings de likes
     *
     * @param integer $id
     * @param integer $type
     * @return string
     */
    public function getLikeSentence(int $id, int $type): string
    {
        $isLiked = $this->isLiked($id, $type, $this->session->getValue(AUTH_KEY, 'id'));
        $likes =  $this->getLikes($id, $type);
        $liked = $likes - 1 ;
        return ($isLiked && $likes == 1)? "Vous aimez ça" : "{$likes} j'aime";
    }


    /**
     * le user aime la publication ?
     * quel type ?
     *
     * @param integer $id
     * @param integer $type
     * @return string
     */
    public function isMentionnedLike(int $id, int $type): string
    {
        if ($this->isLiked($id, $type, $this->session->getValue(AUTH_KEY, 'id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}
