<?php
namespace Ng\Core\Database;

use \PDO;
use Ngpictures\Ngpictures;
use \PDOException;
use \Exception;

class MysqlDatabase extends Database
{

    /**
     * les differents params de connexion a la base de donnee
     * defini dans le fichier de configuration
     * @var string
     */
    private $db_user;
    private $db_pass;
    private $db_host;
    private $db_name;
    private $PDO;

    /**
     * MysqlDatabase constructor.
     * @param $db_name
     * @param string $db_host
     * @param string $db_user
     * @param string $db_pass
     */
    public function __construct(
        string $db_name,
        string $db_host = "127.0.0.1",
        string $db_user = "root",
        string $db_pass = ""
    ) {

        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
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
                    "mysql:Host={$this->db_host};dbname={$this->db_name};charset=utf8",
                    $this->db_user,
                    $this->db_pass
                );
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                $PDO->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
                $this->PDO = $PDO;
            } catch (PDOException $e) {
                if (Ngpictures::hasDebug()) {
                    die("PDOException : {$e->getMessage()} : {$e->getLine()}");
                } else {
                    Ngpictures::redirect("/error-500");
                }
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
    public function query($statement, $class_name = true, $one = false, $rowcount = false)
    {
        try {
            $req = $this->getPDO()->query($statement);
            
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
        } catch (Exception $e) {
            (Ngpictures::hasDebug())? die("QueryException, class = {$class_name} : {$e->getMessage()}") :  Ngpictures::redirect('/e500');
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
        } catch (Exception $e) {
            (Ngpictures::hasDebug())? die("PrepareException : {$e->getMessage()}") :  Ngpictures::redirect('/e500');
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
