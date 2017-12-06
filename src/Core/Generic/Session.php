<?php
namespace Ng\Core\Generic;


use Ng\Interfaces\SessionInterface;



class Session implements SessionInterface
{
    private static $instance;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    public function setFlash(string $type, string $message)
    {
        return $_SESSION['flash'][$type] = $message;
    }


    public function hasFlashes()
    {
        return isset($_SESSION['flash']);
    }


    public  function hasKey(string $name)
    {
        return isset($_SESSION[$name]);
    }

    public function getFlashes()
    {
        $flashes = $_SESSION['flash'];
        $this->delete('flash');
        return $flashes;
    }


    public function getValue(string $key, string $value)
    {
        return $_SESSION[$key]->$value ?? null;
    }


    public function write(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }


    public function read(string $key)
    {
        return $_SESSION[$key] ?? null;
    }


    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }

}
