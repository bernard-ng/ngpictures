<?php
namespace Ngpictures;

use Ng\Core\Managers\StringManager;
use Ng\Core\Managers\CookieManager;
use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\ConfigManager;
use Ng\Core\Managers\SessionManager;
use Ngpictures\Managers\PageManager;
use Ng\Core\Managers\LogMessageManager;
use Ngpictures\Managers\MessageManager;
use Ng\Core\Managers\ValidationManager;
use Ng\Core\Managers\FlashMessageManager;
use Ngpictures\Traits\Util\SingletonTrait;
use Ng\Core\Exception\ConfigManagerException;

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
        try {
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
        } catch (ConfigManagerException $e) {
            die($e->getMessage());
        }
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
     * @return FlashMessageManager
     */
    public function getFlash(): FlashMessageManager
    {
        return new FlashMessageManager($this->getSession());
    }


    /**
     * recupere une instance de validator
     * @return ValidationManager
     */
    public function getValidator(): ValidationManager
    {
        return new ValidationManager();
    }


    /**
     * recupere la session
     * @return SessionManager
     */
    public function getSession(): SessionManager
    {
        return SessionManager::getInstance();
    }


    /**
     * recupere le cookie
     * @return cookieManager
     */
    public function getCookie(): CookieManager
    {
        return CookieManager::getInstance();
    }


    /**
     * recupere le gestion de chaine de charactere
     * @return stringManager
     */
    public function getStr(): StringManager
    {
        return new StringManager();
    }


    public function getMessageManager(): MessageManager
    {
        return new MessageManager();
    }


    //GENERAL APPLICATION METHODS
    //****************************************************************************/


    /**
     * gestion d'exception
     * @param $e
     */
    public function exceptionHandler($e)
    {
        FlashMessageManager::getInstance()->set('danger', "Erreur !");
        LogMessageManager::register($e->getFile(), $e->getMessage());
        self::redirect("/error-500");
    }

    /**
     * gestion d'erreur
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     */
    public function errorHandler(int $errno, string $errstr, string $errfile)
    {
        FlashMessageManager::getInstance()->set('danger', "Erreur !");
        LogMessageManager::register($errfile, $errstr);
        self::redirect("/error-500");
    }


    /**
     * on a le debugger ?
     * @return mixed|null
     */
    public static function hasDebug()
    {
        try {
            $settings = new ConfigManager(ROOT."/config/SystemConfig.php");
            return $settings->get('sys.debug');
        } catch (ConfigManagerException $e) {
            self::redirect("/error-500");
        }
    }

    /**
     * on active le cache ?
     * @return bool
     */
    public static function hasCache(): bool
    {
        try {
            $settings = new ConfigManager(ROOT."/config/SystemConfig.php");
            return $settings->get('sys.cache');
        } catch (ConfigManagerException $e) {
            self::redirect("/error-500");
        }
    }


    /**
     * gestion de redirection
     * @param mixed $url
     * @param bool $moved_permantly
     */
    public static function redirect($url = null, $moved_permantly = false)
    {
        if (is_bool($url)) {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                header("location:{$_SERVER['HTTP_REFERER']}");
                if ($moved_permantly) {
                    header("HTTP/1.1 301 Moved Permanently");
                }
                exit();
            } else {
                header('location:/home');
                if ($moved_permantly) {
                    header("HTTP/1.1 301 Moved Permanently");
                }
                exit();
            }
        } else {
            is_null($url)? header('location:/home') : header("location:{$url}");
            if ($moved_permantly) {
                header("HTTP/1.1 301 Moved Permanently");
            }
            exit();
        }
    }


    /**
     * gestion de turbolinks
     * @param string $name nom de la routes, location
     */
    public static function turbolinksLocation(string $name)
    {
        header("Turbolinks-Location: {$name}");
    }
}
