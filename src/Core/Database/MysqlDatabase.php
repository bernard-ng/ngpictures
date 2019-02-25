<?php
namespace Ng\Core\Database;

use \PDO;
use \PDOException;
use Ng\Core\Managers\LogMessageManager;

/**
 * Class MysqlDatabase
 * @package Ng\Core\Database
 */
class MysqlDatabase implements DatabaseInterface
{
    /**
     * @var string
     */
    private $dbuser;

    /**
     * @var string
     */
    private $dbpass;

    /**
     * @var string
     */
    private $dbhost;

    /**
     * @var string
     */
    private $dbname;

    /**
     * @var PDO
     */
    private $PDO;


    /**
     * MysqlDatabase constructor.
     * @param string $dbname
     * @param string $dbhost
     * @param string $dbuser
     * @param string $dbpass
     */
    public function __construct(string $dbname, string $dbhost, string $dbuser, string $dbpass)
    {
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->dbuser = $dbuser;
        $this->dbpass = $dbpass;
    }


    /**
     * @return null|PDO
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
     * @param $statement
     * @param bool $entity
     * @param bool $one
     * @param bool $rowcount
     * @return array|int|mixed|null|\PDOStatement
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
     * @param $statement
     * @param $data
     * @param bool $class_name
     * @param bool $one
     * @param bool $rowcount
     * @return array|int|mixed|null|\PDOStatement
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
     * @return string
     */
    public function lastInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}
