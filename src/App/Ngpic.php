<?php
namespace Ngpictures;


use Ng\Core\Database\MysqlDatabase;

use Ng\Core\Config\Config;

use Ng\Core\Generic\{
    Session, cookie, collection,
    str, Validator, Flash
};



class Ngpic {

    /**
     * la base de donnee
     * @var
     */
    private static  $db_instance;


    /**
     * notre application
     * @var
     */
    private static $instance;


    /**
     * permet de recupere une et une meme instance
     * @return Ngpic
     */
    public static function getInstance(): self
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


    /**
     * recupere est instancie un nouveau model
     * @param string $class_name
     * @return mixed
     */
    public function getModel(string $class_name)
    {
        $class_name = "\\Ngpictures\\Models\\".ucfirst($class_name)."Model";
        return new $class_name($this->getDb());
    }


    /**
     * recupere est instancie un nouveau controller
     * @param string $name
     * @return mixed
     */
    public function getController(string $name)
    {
        $controller = "\\Ngpictures\\Controllers\\".ucfirst($name)."Controller";
        return new $controller();
    }

    /**
     * recupere une instance de flash
     * @return Flash
     */
    public function getFlash(): Flash
    {
        return new Flash($this->getSession());
    }

    /**
     * recupere une instance de validator
     * @return Validator
     */
    public function getValidator(): Validator
    {
        return new Validator($this->getDb(), $this->getFlash(), $_POST);
    }

    /**
     * recupere la session
     * @return Session
     */
    public function getSession(): Session
    {
        return Session::getInstance();
    }

    /**
     * recupere le cookie
     * @return cookie
     */
    public function getCookie(): Cookie
    {
        return Cookie::getInstance();
    }

    /**
     * recupere le gestion de chaine de charactere
     * @return str
     */
    public function getStr(): str
    {
        return new Str();
    }
    


    /***************************************************************************
    *
    *                           GENERAL APPLICATION METHODS
    *
    ****************************************************************************/


    /**
     * on a le debugger ?
     * @return mixed|null
     */
    public static function hasDebug()
    {
        $settings = Config::getInstance(ROOT."/config/EnvConfig.php");
        return $settings->get('debug');
    }

    /**
     * on active le cache ?
     * @return bool
     */
    public static function hasCache(): bool
    {
        $settings = Config::getInstance(ROOT."/config/EnvConfig.php");
        return $settings->get('cache');
    }

    /**
     * gestion de redirection
     * @param mixed $url
     */
    public static function redirect($url = null)
    {

       if (is_bool($url)) {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                //$self = strtolower($_SERVER['REQUEST_SCHEME'] ."://". $_SERVER['SERVER_NAME']);
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
