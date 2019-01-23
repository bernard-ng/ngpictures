<?php

declare(strict_types=1);

namespace Core\Database;

use Psr\Container\ContainerInterface;

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
     * @param ContainerInterface $container
     * @return \PDO
     * @internal param string $host
     * @internal param string $dbname
     * @internal param string $username
     * @internal param string $password
     */
    public function __invoke(ContainerInterface $container): \PDO
    {
        if (is_null($this->PDO)) {
            $host = $container->get('config')['database.host'];
            $dbname = $container->get('config')['database.name'];
            $username = $container->get('config')['database.username'];
            $password = $container->get('config')['database.password'];

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
