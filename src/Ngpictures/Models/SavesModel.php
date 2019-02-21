<?php
namespace Application\Models;

use Framework\Models\Model;
use Application\Ngpictures;
use Framework\Database\DatabaseInterface;
use Framework\Interfaces\SessionInterface;
use Application\Services\Auth\DatabaseAuthService;
use Application\Traits\Util\TypesActionTrait;

class SavesModel extends Model
{

    use TypesActionTrait;

    /**
     * SavesModel constructor.
     * @param DatabaseInterface $database
     */
    public function __construct(DatabaseInterface $database)
    {
        parent::__construct($database);
        $this->auth = Ngpictures::getDic()->get(DatabaseAuthService::class);
    }



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
        $user = $this->auth->isLogged();
        
        if ($user) {
            $req = $this->query(
                "SELECT * FROM {$this->table} WHERE {$this->getType($type)} = ? AND users_id = ? ",
                [$id, $user->id ],
                true,
                true
            );
            return ($req)? true : false;
        } else {
            return false;
        }
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
