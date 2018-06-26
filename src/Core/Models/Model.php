<?php
namespace Ng\Core\Models;


use Ng\Core\Database\DatabaseInterface;

class Model
{

    /**
     * nom de la table
     * @var string
     */
    protected $table;


    /**
     * connection de la base de donnee
     * @var Database
     */
    protected $database;


    /**
     * Model constructor.
     * @param DatabaseInterface
     */
    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }


    /**
     * renvoi le nom de la table
     * @return string
     */
    public function getTable(): string
    {
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
     */
    public function query(string $statement, array $data = null, bool $class = true, bool $one = false, bool $rowCount = false)
    {
        $class = ($class === true)? str_replace("Model", "Entity", get_class($this)) : false;
        $class = str_replace("Entitys", "Entity", $class);

        if ($data === null) {
            return $this->database->query($statement, $class, $one, $rowCount);
        } else {
            return $this->database->prepare($statement, $data, $class, $one, $rowCount);
        }
    }


    /**
     * mise a jour des champs d'une table
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data = [])
    {
        $fields = [];
        $values = [];
        foreach ($data as $k => $v) {
            $fields[] = "{$k} = ?";
            $values[] = "{$v}";
        }
        $fields = implode(', ', $fields);
        $values[] = $id;

        return $this->query("UPDATE {$this->table} SET {$fields} WHERE id = ? ", $values);
    }


    /**
     * creation de donnee
     * @param array $data
     * @param boolean $date_created
     * @return mixed
     */
    public function create(array $data = [], bool $date_created = true)
    {
        $fields = [];
        $values = [];
        foreach ($data as $k => $v) {
            $fields[] = "{$k} = ?";
            $values[] = $v;
        }
        $values = implode(', ', $fields);

        return ($date_created)?
            $this->query("INSERT INTO {$this->table} SET $values , date_created = NOW() ", $values) :
            $this->query("INSERT INTO {$this->table} SET $values ", $values);
    }


    /**
     * suppression des donnees
     * @param int $id
     * @return mixed
     */
    public function delete(int $id)
    {
        return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }


    /**
     * dernier id insert dans la base des donnees
     * @return mixed
     */
    public function lastInsertId()
    {
        return $this->database->lastInsertId();
    }


    /**
     * recupere tout les enregistrements
     * @return mixed
     */
    public function all()
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY id DESC");
    }


    /**
     * recupere un enregistrement
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE id = ?",
            [$id],
            true,
            true
        );
    }


    /**
     * recupere un enregistrement avec une contrainte
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWith(string $field, $value, $one = true)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE {$field} = ?",
            [$value],
            true,
            $one
        );
    }


    /**
     * recupere une publication grace aux htags
     *
     * @param string $tag
     * @return mixed
     */
    public function findwithTag(string $tag)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE content LIKE ?",
            ["%{$tag}%"]
        );
    }


    /**
     * recupere les publication similaire
     * @todo ameliorer cette methode.
     *
     * @param integer $id
     * @return void
     */
    public function findSimilars(int $id)
    {
        return $this->query(
            "SELECT *
            FROM {$this->table}
            WHERE (categories_id = (
                SELECT categories_id
                FROM {$this->table}
                WHERE id = ?
            ) AND id <> ? ) AND online = 1
            ORDER BY RAND() LIMIT 5 ",
            [$id, $id]
        );
    }


    /**
     * query les donnes par rapport a une liste
     * de resultat.
     *
     * @param string $list
     * @return mixed
     */
    public function findList(string $list)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE id IN ({$list}) ",
            null
        );
    }


    /**
     * recupere les data superieur a l'id donne
     *
     * @param integer $lastId
     * @param string $limit
     * @return mixed
     */
    public function findGreater(int $lastId, string $limit)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE id < ? AND online = 1 ORDER BY id DESC LIMIT {$limit}",
            [$lastId]
        );
    }


    /**
     * recupere un enregistrement suivant l'id et un autre champ
     * @param string $field
     * @param $value
     * @return mixed
     */
    public function findWithId(string $field, $value)
    {
        return $this->query("SELECT * FROM {$this->table} WHERE id = ? AND {$field} = ?", [$value]);
    }


    /**
     * renvoi par defaut le 4 dernier enregistrement
     * @param int $from
     * @param int $to
     * @return mixed
     */
    public function latest(int $from = 0, int $to = 4)
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 1 ORDER BY id DESC LIMIT {$from},{$to}",
            null,
            true,
            false
        );
    }


    /**
     * renvoi le dernier enregistrement
     * @return mixed
     */
    public function last()
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 1 ORDER BY id DESC",
            null,
            true,
            true
        );
    }


    /**
     * tout les enregistrements en ligne
     * @return mixed
     */
    public function lastOnline()
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 1 ORDER BY id DESC ",
            null,
            true,
            false
        );
    }


    public function lastOffline()
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 0 ORDER BY id DESC ",
            null,
            true,
            false
        );
    }


    /**
     * recupere est classe selon la contrainte
     * @param string $field
     * @param string $order
     * @param int|null $from
     * @param int|null $to
     * @return mixed
     */
    public function orderBy(string $field, string $order = 'DESC', int $from = null, int $to = null)
    {
        if ($from === null && $to === null) {
            return $this->query(
                "SELECT * FROM {$this->table} ORDER BY {$field} {$order}",
                null,
                true,
                false
            );
        }
        return $this->query("SELECT * FROM {$this->table} ORDER BY {$field} {$order} LIMIT {$from},{$to}");
    }
}
