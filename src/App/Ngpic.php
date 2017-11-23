<?php

use Core\Database\MysqlDatabase;
use Core\Config\Config;
use \Core\Generic\{Session,cookie,collection,str,Validator};

/**
 * Class Ngpic
 * FR - c'est la class generique de l'application
 * EN - this is the generic class of the application
 * @package Ngpic
 * @author Bernard ng
 */
class Ngpic {

	private static  $db_instance,
                    $instance;
    
    public static $pageName = "Ngpictures";


    
    //factoring

    public static function getInstance(): Ngpic
    {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}


    public function getDb(): MysqlDatabase
    {
		$setting = Config::getInstance(ROOT."\Config\DatabaseConfig.php");

		if (!isset(self::$db_instance)) {
			self::$db_instance = new MysqlDatabase(

				$setting->get("db_name"),
                $setting->get("db_host"),
				$setting->get("db_user"),
				$setting->get("db_pass")

			);
		}
		return self::$db_instance;
	}

 
    public function getModel(string $class_name)
    {
        $class_name = "\\Ngpic\\Model\\".ucfirst($class_name)."Model";
        return new $class_name($this->getDb());
    }


    public function getController(string $name)
    {
        $controller = "\\Ngpic\\Controller\\".ucfirst($name)."Controller";
        return new $controller();
    }


    public function getValidator(): Validator
    {
        return new Validator($this->getDb(), $_POST);
    }

    public function getSession(): Session
    {
        return Session::getInstance();
    }

    public function getCookie(): Cookie
    {
        return Cookie::getInstance();
    }

    public function getStr(): str
    {
        return new Str();
    }

    // general application methods...


    public static function hasDebug()
    {
        $settings = Config::getInstance(ROOT."/Config/EnvConfig.php");
        return $settings->get('debug');
    }


    public static function hasCache(): bool
    {
        $settings = Config::getInstance(ROOT."/Config/EnvConfig.php");
        return $settings->get('cache');
    }


    public static function getPageName(): string
    {
        return self::$pageName;
    }

    public static function getTitle(): string
    {
        $title = explode('|', self::getPageName());
        return trim($title[0]);
    }


    public static function setPageName(string $name): string
    {
        self::$pageName = $name;
        return self::getPageName();
    }


    public static function redirect($url = null)
    {
       if ($url === true) {
           if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
                header("location:{$_SERVER['HTTP_REFERER']}");
           } else {
               header('location:/home');
           }
       } else {
            is_null($url)? header('location:/home') : header("location:{$url}");
            exit();
       }
        
    }
}
