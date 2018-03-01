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
     * @param int $t
     * @param $user_id
     * @return mixed
     */
    public function remove(int $id, int $t, $user_id)
    {
        return $this->query(
            "DELETE FROM {$this->table} WHERE {$this->getType($t)} = ? AND user_id = ? ",
            [$id,$user_id],
            true,
            true
        );
    }

    public function getLikes(int $id, int $t): int
    {
        return $this->query(
            "SELECT id,user_id FROM {$this->table} WHERE {$this->getType($t)} = {$id}",
            [$id],
            true,
            false,
            true
        );
    }


    public function getLikers(int $id, int $t)
    {
        return $this->query(
            "SELECT user_id FROM {$this->table} WHERE {$this->getType($t)} = {$id}",
            [$id],
            true,
            false,
            false
        );
    }

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

    public function getLikeSentence(int $id, int $t): string
    {
        $isLiked = $this->isLiked($id, $t, $this->session->getValue(AUTH_KEY, 'id'));
        $likes =  $this->getLikes($id, $t);
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

    public function isMentionnedLike($id, $t): string
    {
        if ($this->isLiked($id, $t, $this->session->getValue(AUTH_KEY, 'id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}
