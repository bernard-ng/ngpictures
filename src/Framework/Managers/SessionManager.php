<?php
namespace Framework\Managers;

use Framework\Interfaces\SessionInterface;

/**
 * Class SessionManager
 * @package Framework\Managers
 */
class SessionManager implements SessionInterface
{

    /**
     * Session constructor.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name("ngpictures_ssid");
            session_start();
        }
    }


    /**
     * @param string $name
     * @return bool
     */
    public function hasKey(string $name)
    {
        return isset($_SESSION[$name]);
    }


    /**
     * @param string $key
     * @param string $value
     * @return null
     */
    public function getValue(string $key, string $value)
    {
        return $_SESSION[$key]->$value ?? null;
    }


    /**
     * @param string $key
     * @param $value
     * @return mixed|void
     */
    public function write(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }


    /**
     * @param string $key
     * @return null
     */
    public function read(string $key)
    {
        return $_SESSION[$key] ?? null;
    }


    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key)
    {
        unset($_SESSION[$key]);
    }
}
