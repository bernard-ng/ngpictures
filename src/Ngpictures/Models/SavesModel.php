<?php
namespace Ngpictures\Models;

use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\SessionManager;
use Ng\Core\Models\Model;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Util\TypesActionTrait;

/**
 * @property SessionManager session
 */
class SavesModel extends Model
{

    /**
     * SavesModel constructor.
     * @param MysqlDatabase $database
     */
    public function __construct(MysqlDatabase $database)
    {
        parent::__construct($database);
        $this->session = Ngpictures::getInstance()->getSession();
    }

    use TypesActionTrait;

    /**
     * le nom de la table
     * @var string $table
     */
    protected $table = 'saves';


    /**
     * permet de savoir si un user aime la publication
     *
     * @param integer $id
     * @param int $type
     * @return boolean
     */
    public function isSaved(int $id, int $type): bool
    {
        $req = $this->query(

            "SELECT * FROM {$this->table} WHERE {$this->getType($type)} = ? AND users_id = ? ",
            [$id, $this->session->getValue(AUTH_KEY,'id')],
            true,
            true
        );
        return ($req)? true : false;
    }


    public function getSaves(int $id, int $type): string
    {
        return $this->query(
            "SELECT users_id FROM {$this->table} WHERE {$this->getType($type)} = {$id}",
            [$id],
            true,
            false,
            true
        );
    }



    /**
     * recupere les id des publication enregistree
     *
     * @param string $type
     * @param integer $user_id
     * @return void
     */
    public function get(string $type, int $user_id)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE users_id = ? AND {$type} IS NOT NULL",
            [$user_id]
        );
    }
}
