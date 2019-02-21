<?php
namespace Framework\Database;

use \PDO;
use \Exception;
use \PDOException;
use Application\Ngpictures;
use Framework\Managers\LogMessageManager;

class MysqlDatabase implements DatabaseInterface
{

    /**
     * les differents params de connexion a la base de donnee
     * defini dans le fichier de configuration
     * @var string
     */

    private $dbuser;
    private $dbpass;
    private $dbhost;
    private $dbname;
    private $PDO;

    /**
     * MysqlDatabase constructor.
     * @param $db_name
     * @param string $db_host
     * @param string $db_user
     * @param string $db_pass
     */
    public function __construct(string $dbname, string $dbhost, string $dbuser, string $dbpass)
    {
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
    }


    /**
     * connexion avec pdo a la base de donnee
     * @return PDO
     */
    private function getPDO()
    {
        if ($this->PDO === null) {
            try {
                $PDO = new PDO(
                    "mysql:Host={$this->dbhost};dbname={$this->dbname};charset=utf8",
                    $this->dbuser,
                    $this->dbpass
                );
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $PDO->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
                $this->PDO = $PDO;
            } catch (PDOException $e) {
                LogMessageManager::register(__class__, $e);
                return null;
            }
        }
        return $this->PDO;
    }


    /**
     * permet de faire des requets normal
     * @param $statement
     * @param bool $class_name
     * @param bool $one
     * @param bool $rowcount
     * @return array|int|mixed|\PDOStatement
     */
    public function query($statement, $entity = true, $one = false, $rowcount = false)
    {
        try {
            $req = $this->getPDO()->query($statement);

            if (strpos($statement, "INSERT") === 0 ||
                strpos($statement, "DELETE") === 0 ||
                strpos($statement, "UPDATE") === 0
            ) {
                return $req;
            }

            ($entity === true) ? $req->setFetchMode(PDO::FETCH_OBJ) : $req->setFetchMode(PDO::FETCH_CLASS, $entity);
            $res = ($rowcount === true) ? $req->rowCount() : ($one)? $req->fetch() : $req->fetchAll();
            return $res;
        } catch (PDOException $e) {
            LogMessageManager::register(__class__, $e);
            return null;
        }
    }


    /**
     * permet de faire des requets preparés
     * @param $statement
     * @param $data
     * @param bool $class_name
     * @param bool $one
     * @param bool $rowcount
     * @return array|int|mixed|\PDOStatement
     */
    public function prepare($statement, $data, $class_name = true, $one = false, $rowcount = false)
    {
        try {
            $req = $this->getPDO()->prepare($statement);
            $req->execute($data);

            if (strpos($statement, "INSERT") === 0 ||
                strpos($statement, "DELETE") === 0 ||
                strpos($statement, "UPDATE") === 0
            ) {
                return $req;
            }

            if ($class_name === true) {
                $req->setFetchMode(PDO::FETCH_OBJ);
            } else {
                $req->setFetchMode(PDO::FETCH_CLASS, $class_name);
            }

            if ($rowcount === true) {
                $result = $req->rowCount();
            } else {
                $result = ($one)? $req->fetch() : $req->fetchAll();
            }
            return $result;
        } catch (PDOException $e) {
            LogMessageManager::register(__class__, $e);
            return null;
        }
    }


    /**
     * renvoi le dernier id insert dans la base de donnee
     * @return string
     */
    public function lastInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}
