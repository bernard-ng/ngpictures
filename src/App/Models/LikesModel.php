<?php
namespace Ngpictures\Models;


use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Models\Model;
use Ng\Core\Generic\Collection;
use Ngpictures\Ngpictures;



class LikesModel extends Model
{
    /**
     * nom de la table
     * @var string
     */
    protected $table = "likes";

    
    /**
     * les differents type de publication
     * @var array
     */
    private $types = [ 1 => 'article_id','gallery_id','blog_id'];


    /**
     * renvoi le type de la publication
     * @param int $type
     * @return mixed
     */
    private function getType(int $type)
    {
        $types = new Collection($this->types);
        return $types->get($type);
    }


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
            [$id], true, false, true
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


        switch ($isLiked && $likes) {
            case $isLiked && $likes > 2 :
                return "Vous et {$liked} personnes aimez ça";
                break;

            case $isLiked && $likes == 1 :
                return "Vous aimez ça";
                break;

            case $isLiked && $likes == 2 :
                return "Vous et une autre personne aimez ça";
                break;

            case !$isLiked && $likes >= 2 :
                return "{$likes} personnes aiment ça";
                break;

            case !$isLiked && $likes == 1 :
                return "Une personne aime ça";
                break;
            
            default:
                return "{$likes} j'aime";
                break;
        }
    }

    public function isMentionnedLike($id,$t): string
    {
        if ($this->isLiked($id, $t, $this->session->getValue(AUTH_KEY, 'id'))) {
            return 'active';
        } else {
            return '';
        }
    }
}
