<?php
namespace Core\Generic;

class Session
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

    public function setFlash($type,$message)
    {
        return $_SESSION['flash'][$type] = $message;
    }

    public function hasFlashes()
    {
        return isset($_SESSION['flash']);
    }

    public function getFlashes()
    {
        $flashes = $_SESSION['flash'];
        $this->delete('flash');
        return $flashes;
    }

    public function getValue($key,$value)
    {
        return $_SESSION[$key]->$value ?? null;
    }

    public function write($key,$value)
    {
        $_SESSION[$key] = $value;
    }

    public function read($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete($key)
    {
        unset($_SESSION[$key]);
    }

}
