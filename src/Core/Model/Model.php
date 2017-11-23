<?php
namespace Core\Model;

use Core\Database\Database;
use Core\Entity\Entity;


/**
 * class Model
 *
 * @package Ngpic
 * @author Bernard ng;
 **/
class Model
{

    protected $table;
    protected $db;

    /**
     * Model constructor.
     * @param \Core\Database\Database
     */
    public function __construct(Database $db)
    {
        $this->db = $db;
        if (is_null($this->table)) {
            $part = explode("\\",get_class($this));
            $table = end($part);
            $this->table = strtolower(str_replace("Model","",$table));
        }
        return $this->table;
    }

    /**
     * query permet de faire de requete sql
     *
     * query cette method prend 5 params, le premier doit etre la statement sql 
     * la seconde est un tableau qui contiendra les donnee pour les requetes preparee
     * les trois autres sont des bools, qui permet just d'optimiser la req, par contre le 
     * dernier param est important il ne renvoi pas le resultat de la req mais le nombre de ligne 
     * affecter c'est au fait un rowCount.
     *
     * @param string $statement the mysql query statement
     * @param array $data for PDO prepare method 
     * @param bool $class if true FETCH_CLASS else FETCH_OBJ
     * @param bool $one if true FETCH else FETCHALL
     * @param bool $rowCount if true retrun the PDO::rowCount() 
     * @return mixed
     **/
    public function query(
        string $statement, 
        array $data = null, 
        bool $class = true, 
        bool $one = false, 
        bool $rowCount = false)
    {
        $class = ($class === true)? str_replace("Model","Entity",get_class($this)) : null;
        if ($data === null) {
            return $this->db->query($statement, $class, $one, $rowCount);
        } else {
            return $this->db->prepare($statement, $data, $class, $one, $rowCount);
        }
    }

    public function update(int $id,array $data = [])
    {
        $array_sql = [];
        $array_data = [];

        foreach ($data as $k => $v) {
            $array_sql[] = "{$k} = ?";
            $array_data[] = $v;
        }

        $sql = implode(', ',$array_sql);
        $array_data[] = $id;
        
        return $this->query("UPDATE {$this->table} SET $sql WHERE id = ? ", $array_data);
    }

    public function setThumb(int $id ,string $thumb)
    {
        return $this->query(
            "UPDATE {$this->table} SET thumb = ? WHERE id = ?",
            [$thumb,$id]
        );
    }

    public function create(array $data = [])
    {
        $array_sql = [];
        $array_data = [];

        foreach ($data as $k => $v) {
            $array_sql[] = "{$k} = ?";
            $array_data[] = $v;
        }

        $sql = implode(', ',$array_sql);
        return $this->query("INSERT INTO {$this->table} SET $sql , date_created = NOW() ", $array_data);
    }

    public function delete(int $id)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?",[$id],true,true);
    }


    // General methods
    public function getTable(): string
    {
        return $this->table;
    }
    
    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }


    // Query methods

    public function all()
    {
        return $this->query("SELECT * FROM {$this->table}");
    }


    public function count(string $field = null, int $id = null)
    {
        if ($field && $id !== null) {
            return $this->query("
                SELECT * FROM {$this->table} WHERE {$field} = ?",
                [$id],
                true,false,true
            );
        } else {
            return $this->query(
                "SELECT * FROM {$this->table}",
                null, true, false, true 
            );
        }
    }

    
    public function find(int $id)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ?",[$id],true,true);
    }


    public function findWith(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE {$field} = ?",[$value]);
    }


    public function findWithId(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ? AND {$field} = ?",[$value]);
    }


    public function findAlternative(array $field, $value)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE ({$field[0]} = :{$field[0]} OR {$field[1]} = :{$field[0]})",
            [$field[0] => $value],
            true, true
        );
    }

    public function lastest(int $from = 0, int $to = 4)
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY date_created DESC LIMIT {$from},{$to}");
    }


    public function last(int $offset = null)
    {
        if (is_null($offset)) {
            return $this->query("SELECT * FROM {$this->table} ORDER BY date_created DESC",
                null,true,true
            );
        } else {
            return $this->query("SELECT * FROM {$this->table} ORDER BY date_created DESC LIMIT 0,{$offset}",
                null,true,false
            );
        }
    }


    public function lastByDate(string $order = 'DESC'){
        return $this->query("SELECT * FROM {$this->table} ORDER BY date_created {$order}");
    }


    public function orderBy(string $field, string $order = 'DESC', int $from = null, int $to = null)
    {
        if ($from === null && $to === null) {
            return $this->query("SELECT * FROM {$this->table} ORDER BY {$field} {$order}");
        }
        return $this->query("SELECT * FROM {$this->table} ORDER BY {$field} {$order} LIMIT {$from},{$to}");
    }
}
