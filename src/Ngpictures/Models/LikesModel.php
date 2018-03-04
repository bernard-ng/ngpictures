<?php
namespace Ngpictures\Models;

use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Models\Model;
use Ng\Core\Managers\Collection;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Util\TypesActionTrait;

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
     * @param $user_id
     * @return mixed
     */
    public function add(int $id, int $type, $user_id)
    {
        return $this->query(
            "INSERT INTO {$this->table}(user_id,{$this->getType($type)},date_created) VALUES(?,?,NOW())",
            [$user_id,$id]
        );
    }


    /**
     * retire un like
     * @param int $id
     * @param int $type
     * @param $user_id
     * @return mixed
     */
    public function remove(int $id, int $type, $user_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE {$this->getType($type)} = ? AND user_id = ? ",
            [$id,$user_id],
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
            "SELECT id,user_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}",
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
            "SELECT user_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}",
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
     * @param int|null $user_id
     * @return boolean
     */
    public function isLiked(int $id, int $t, $user_id = null): bool
    {
        $req = $this->query(

            "SELECT * FROM {$this->table} WHERE {$this->getType($t)} = ? AND user_id = ? ",
            [$id,$user_id],
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

        if ($isLiked && $likes > 2) {
            return "Vous et {$liked} personnes aimez ça";
        } elseif ($isLiked && $likes == 1) {
            return "Vous aimez ça";
        } elseif (!$isLiked && $likes >= 2) {
            return "{$likes} personnes aiment ça";
        } elseif (!$isLiked && $likes == 1) {
            return "Une personne aime ça";
        } else {
            return "{$likes} j'aime";
        }
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
