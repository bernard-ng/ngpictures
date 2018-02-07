<?php
namespace Ngpictures;

use Ngpictures\Traits\Util\SingletonTrait;
use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\{
    SessionManager,
    CookieManager,
    StringManager,
    FlashMessageManager,
    ConfigManager,
    ValidationManager
};
use Ngpictures\Managers\PageManager;


class Ngpictures
{

    /* base de donnee */
    private static $db_instance;


    use SingletonTrait;


    //FACTORING
    //****************************************************************************


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
    private function getDb(): MysqlDatabase
    {
        $setting = new ConfigManager(ROOT."\config\DatabaseConfig.php");

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
        return new $controller(self::getInstance(), new PageManager());
    }


    /**
     * recupere une instance de flash
     * @return Flash
     */
    public function getFlash(): FlashMessageManager
    {
        return new FlashMessageManager($this->getSession());
    }


    /**
     * recupere une instance de validator
     * @return ValidatorManager
     */
    public function getValidator(): ValidationManager
    {
        return new ValidationManager($this->getDb(), $this->getFlash(), $_POST);
    }


    /**
     * recupere la session
     * @return Session
     */
    public function getSession(): SessionManager
    {
        return SessionManager::getInstance();
    }


    /**
     * recupere le cookie
     * @return cookie
     */
    public function getCookie(): CookieManager
    {
        return CookieManager::getInstance();
    }


    /**
     * recupere le gestion de chaine de charactere
     * @return str
     */
    public function getStr(): StringManager
    {
        return new StringManager();
    }
    

    //GENERAL APPLICATION METHODS
    //****************************************************************************/


    /**
     * on a le debugger ?
     * @return mixed|null
     */
    public static function hasDebug()
    {
        $settings = new ConfigManager(ROOT."/config/SystemConfig.php");
        return $settings->get('sys.debug');
    }

    /**
     * on active le cache ?
     * @return bool
     */
    public static function hasCache(): bool
    {
        $settings = new ConfigManager(ROOT."/config/SystemConfig.php");
        return $settings->get('sys.cache');
    }


    /**
     * gestion de redirection
     * @param mixed $url
     */
    public static function redirect($url = null)
    {
        if (is_bool($url)) {
            if (!empty($_SERVER['HTTP_REFERER'])) {
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
