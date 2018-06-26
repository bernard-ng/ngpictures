<?php
namespace Ngpictures;

use Psr\Container\ContainerInterface;
use Ng\Core\Router\Router;


class Ngpictures
{

    /**
     * le container
     * @var ContainerInterface
     */
    public $container;


    /**
     * le container, redefini pour permettre autre class
     * d'avoir access au DIC sans instancie celui-ci et instancie l'application.
     * @todo ameliorer ceci et trouver une solution.
     * @var ContainerInterface
     */
    public static $dic;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        self::$dic      =   $container;
    }


    /**
     * initialisation router et application
     * registration des routes dans la RoutesConfig.php
     */
    public function run()
    {
        try {
            $router = $this->container->get(Router::class);
            require(ROOT."/config/routes/frontend.php");
            require(ROOT."/config/routes/backend.php");

            $route = $router->run();
            if ($route) {
                if (is_string($route->getController())) {
                    $action         =   explode("#", $route->getController());
                    $method         =   $action[1] ?? 'index';
                    $controller     =   $this->container->get($this->getAction($action[0]));

                    return call_user_func_array([$controller, $method], $route->getMatches());
                }
                return call_user_func_array($route->getController(), $route->getMatches());
            } else {
                //404
            }
        } catch (RouterException $e) {
            LogMessageManager::register(__class__, $e);
            self::redirect("/error/internal");
        }
    }


    private function getAction(string $action)
    {
        $namespace = __NAMESPACE__ . "\\Controllers\\";
        $class = ucfirst($action) . "Controller";
        return $namespace . $class;
    }



    //GENERAL APPLICATION METHODS
    //****************************************************************************/


    /**
     * gestion d'exception
     * @param $e
     */
    public function exceptionHandler($e)
    {
        FlashMessageManager::getInstance()->set('danger', "Oups une erreur est survenue !");
        LogMessageManager::register(__CLASS__, $e);
        http_response_code(500);
        self::redirect("/error/internal");
    }

    /**
     * gestion d'erreur
     * @param int $errno
     * @param string $errstr
     * @param string $errfile
     */
    public function errorHandler(int $errno, string $errstr, string $errfile)
    {
        FlashMessageManager::getInstance()->set('danger', "Oups une erreur est survenue !");
        LogMessageManager::register($errfile, $errstr);
        http_response_code(500);
        self::redirect("/error/internal");
    }


    /**
     * on a le debugger ?
     * @return mixed|null
     */
    public static function hasDebug()
    {
        try {
            $settings = new ConfigManager(ROOT."/config/system.php");
            return $settings->get('sys.debug');
        } catch (ConfigManagerException $e) {
            LogMessageManager::register(__class__, $e);
            self::redirect("/error/internal");
        }
    }

    /**
     * on active le cache ?
     * @return bool
     */
    public static function hasCache(): bool
    {
        try {
            $settings = new ConfigManager(ROOT."/config/system.php");
            return $settings->get('sys.cache');
        } catch (ConfigManagerException $e) {
            LogMessageManager::register(__class__, $e);
            self::redirect("/error/internal");
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

    /**
     * Get le container
     *
     * @return  ContainerInterface
     */
    public static function getDic()
    {
        return self::$dic;
    }
}
