<?php
namespace Core\Generic;
use \DateTime;

class Cookie
{
    static private $instance;

    static public function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function setExpire($time)
    {
        //$time = (!isset($time))? "D-15" : $time;
        //$parts = explode("-",$time);
        //$period = $parts[0];
        //$duration = intval($parts[1]);
        $expire = time() * 60 * 24 * 15 ;

        /*switch ($period) {
            case "D" or 'd':
                $expire = time() * 60 * 24 * $duration;
                break;
            case "Y" or 'y':
                $expire = time() * 60 * 24 * 360 * $duration;
                break;
            case "W" or 'w':
                $expire = time() * 60 * 24 * 7 * $duration;
                break;
            default:
                $expire = time() * 60 * 24 * 15;
        }*/
        return $expire;
    }

    public  function hasKey($name)
    {
        return isset($_COOKIE[$name]);
    }

    public function write($name,$value,$time)
    {
       setcookie($name,$value,$this->setExpire($time));
    }

    public function read($name)
    {
        return isset($_COOKIE[$name])? $_COOKIE[$name] : null;
    }

    public function delete($name)
    {
        setcookie($name,null,-1);
    }

}
