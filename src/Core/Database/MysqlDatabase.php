<?php
namespace Ng\Core\Database;

use \PDO;
use Core\Exception\{queryException,prepareException};


/**
 * class MysqlDatabase
 * FR - connexion à la base de donnée et les différentes requètes
 * EN - database connexion and all reqs
 * @package Core\Database
 * @author Bernard ng
 **/
class MysqlDatabase extends Database
{

    private $db_user,
            $db_pass,
            $db_host,
            $db_name,
            $PDO;

    public function __construct($db_name,$db_host="127.0.0.1",$db_user="root",$db_pass="") {

        $this->db_name = $db_name;
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
    }

    private function getPDO() {

        if ($this->PDO === null) {
           try {
               $PDO = new PDO(
                    "mysql:Host={$this->db_host};dbname={$this->db_name};charset=utf8",
                    $this->db_user,
                    $this->db_pass
                );
                $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE ,PDO::FETCH_OBJ);
                $PDO->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
               $this->PDO = $PDO;
           } catch (\PDOException $e) {
               if (Ngpic::hasDebug()) {
                    die("{$e->getMessage()}</br>{$e->getLine()}");
               } else {
                    Ngpic::redirect("/error-500");
               }
           }
        }
        return $this->PDO;
    }


    public function query($statement, $class_name = true, $one = false, $rowcount = false)
    {
        try {
            $req = $this->getPDO()->query($statement);
            
             if (
                strpos($statement,"INSERT") === 0 || 
                strpos($statement,"DELETE") === 0 ||
                strpos($statement,"UPDATE") === 0
            ) {
               
                return $req;
            }

            if ($class_name === true) {
                $req->setFetchMode(PDO::FETCH_OBJ);
            } else {
                $req->setFetchMode(PDO::FETCH_CLASS,$class_name);
            }
            
            if ($rowcount === true) {
                $result = $req->rowCount();
            } else {
                $result = ($one)? $req->fetch() : $req->fetchAll();
            }
            return $result;

        } catch (queryException $e) {
            (Ngpic::hasDebug())? die("Exception : $e->msg") :  Ngpic::redirect('/e500');
        }
    }

    public function prepare($statement,$data, $class_name = true, $one = false, $rowcount = false)
    {
        try {
            $req = $this->getPDO()->prepare($statement);
            $req->execute($data);

            if (
                strpos($statement,"INSERT") === 0 || 
                strpos($statement,"DELETE") === 0 ||
                strpos($statement,"UPDATE") === 0
            ) {
                return $req;
            }

            if ($class_name === true) {
                $req->setFetchMode(PDO::FETCH_OBJ);
            } else {
                $req->setFetchMode(PDO::FETCH_CLASS,$class_name);
            }

            if ($rowcount === true) {
                $result = $req->rowCount();
            } else {
                $result = ($one)? $req->fetch() : $req->fetchAll();
            }
            return $result;

        } catch (prepareException $e) {
            (Ngpic::hasDebug())? die("Exception : $e->msg") :  Ngpic::redirect('/e500');
        }
    }

    
    public function lastInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }


}
