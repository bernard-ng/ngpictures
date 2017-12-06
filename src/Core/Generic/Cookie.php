<?php
namespace Ng\Core\Generic;

use Ng\Interfaces\CookieInterface;
use \DateTime;

class Cookie implements CookieInterface
{
    private static $instance;

    public static  function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function getValue(string $key, string $value)
    {

    }

    public  function hasKey(string $name)
    {
        return isset($_COOKIE[$name]);
    }

    public function write(string $name, string $value)
    {
       setcookie($name, serialize($value), time() * 60 * 24 * 5);
    }

    public function read(string $name)
    {
        return unserialize($_COOKIE[$name]) ?? null;
    }

    public function delete(string $name)
    {
        setcookie($name, null, -1);
    }

}
