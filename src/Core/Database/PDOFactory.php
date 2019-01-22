<?php
namespace Core\Database;

/**
 * Class PDOFactory
 * @package Core\Database
 */
class PDOFactory
{

    /**
     * @var null|\PDO
     */
    private $PDO = null;


    /**
     * @param string $host
     * @param string $dbname
     * @param string $username
     * @param string $password
     * @return \PDO
     */
    public function __invoke(string $host, string $dbname, string $username, string $password): \PDO
    {
        if (is_null($this->PDO)) {
            try {
                $attribute = [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                    \PDO::ATTR_ORACLE_NULLS => \PDO::NULL_EMPTY_STRING,
                ];

                $PDO = new \PDO("mysql:Host={$host};dbname={$dbname};charset=utf8", $username, $password, $attribute);
                $this->PDO = $PDO;
                return $this->PDO;
            } catch (\PDOException|\Exception $e) {
                throw new \PDOException($e->getMessage());
            }
        }
        return $this->PDO;
    }
}
