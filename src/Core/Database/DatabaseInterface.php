<?php
namespace Ng\Core\Database;



interface DatabaseInterface
{


    /**
     * constructor.
     * @param $dbname
     * @param string $dbhost
     * @param string $dbuser
     * @param string $dbpass
     */
    public function __construct(string $dbname, string $dbhost, string $dbuser, string $dbpass);


    /**
     * permet de faire des requets normal
     * @param $statement
     * @param bool $class_name
     * @param bool $one
     * @param bool $rowcount
     * @return array|int|mixed|\PDOStatement
     */
    public function query($statement, $class_name = true, $one = false, $rowcount = false);



    /**
     * permet de faire des requets preparés
     * @param $statement
     * @param $data
     * @param bool $class_name
     * @param bool $one
     * @param bool $rowcount
     * @return array|int|mixed|\PDOStatement
     */
    public function prepare($statement, $data, $class_name = true, $one = false, $rowcount = false);
}
