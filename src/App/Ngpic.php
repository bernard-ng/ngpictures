<?php
namespace Ngpictures;


use Ng\Core\Database\MysqlDatabase;

use Ng\Core\Config\Config;

use Ng\Core\Generic\{
    Session, cookie, collection,
    str, Validator, Flash
};



class Ngpic {

	private static  $db_instance,
                    $instance;
    

    public static function getInstance(): Ngpic
    {
		if (self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}


    /***************************************************************************
    *
    *                                  FACTORING
    *
    ****************************************************************************/


    /**
     * initalise ou recupere la connexion a la base de donnee
     *
     *
     * on recupere la configuration dans un fichier se situant la racine
     * on failt a l'appel a Config qui va mettre la configuration dans la 
     * variable setting sous form d'objet.
     * et on passe a Mysqldatabase la config et lui initialise un PDO
     *
     * @return MysqlDatabase
     **/
    public function getDb(): MysqlDatabase
    {
		$setting = Config::getInstance(ROOT."\config\DatabaseConfig.php");

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
        $class_name = "\\Ngpictures\\Models\\".ucfirst($class_name)."Model";
        return new $class_name($this->getDb());
    }


    public function getController(string $name)
    {
        $controller = "\\Ngpictures\\Controllers\\".ucfirst($name)."Controller";
        return new $controller();
    }


    public function getFlash(): Flash { return new Flash($this->getSession()); }

    public function getValidator(): Validator { return new Validator($this->getDb(), $_POST); }

    public function getSession(): Session { return Session::getInstance(); }

    public function getCookie(): Cookie { return Cookie::getInstance(); }

    public function getStr(): str { return new Str(); }
    


    /***************************************************************************
    *
    *                           GENERAL APPLICATION METHODS
    *
    ****************************************************************************/


    public static function hasDebug()
    {
        $settings = Config::getInstance(ROOT."/config/EnvConfig.php");
        return $settings->get('debug');
    }


    public static function hasCache(): bool
    {
        $settings = Config::getInstance(ROOT."/config/EnvConfig.php");
        return $settings->get('cache');
    }


    public static function redirect($url = null)
    {
       if ($url === true) {
           if (isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER'])) {
                header("location:{$_SERVER['HTTP_REFERER']}");
                exit();
           } else {
               header('location:/home');
               exit();
           }
       } else {
            is_null($url)? header('location:/home') : header("location:{$url}");
            exit();
       }
        
    }
}
