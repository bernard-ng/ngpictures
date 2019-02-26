<?php
namespace Application;

use Framework\Exception\RouterException;
use Framework\Router\Route;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;
use Application\Traits\Util\RequestTrait;
use Framework\Managers\LogMessageManager;
use Framework\Managers\FlashMessageManager;

/**
 * Class Ngpictures
 * @package Ngpictures
 */
class Application
{

    use RequestTrait;

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
        self::$dic = $container;

        if (ENV === 'production') {
            set_exception_handler([$this, "exceptionHandler"]);
            set_error_handler([$this, "errorHandler"]);
        }
    }


    /**
     * initialisation router et application
     * registration des routes dans la RoutesConfig.php
     */
    public function run()
    {
        try {
            $router = $this->container->get(Router::class);
            require(ROOT . "/config/routes/frontend.php");
            require(ROOT . "/config/routes/backend.php");

            /** @var Route $route */
            $route = $router->run();
            if ($route) {
                if (is_array($route->getController())) {
                    $action = $route->getController()[0];
                    $method = $route->getController()[1] ?? 'index';
                    $controller = $this->container->get($action);
                    return call_user_func_array([$controller, $method], $route->getMatches());
                }
                return call_user_func_array($route->getController(), $route->getMatches());
            } else {
                header('location:/error/not-found', true, 404);
                exit();
            }
        } catch (RouterException $e) {
            LogMessageManager::register(__class__, $e);
            self::redirect("/error/internal");
        }
    }


    /**
     * gestion d'exception
     * @param $e
     */
    public function exceptionHandler($e)
    {
        $this->container->get(FlashMessageManager::class)->set('danger', "Oups une erreur est survenue !");
        LogMessageManager::register(__class__, $e);
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
        $this->container->get(FlashMessageManager::class)->set('danger', "Oups une erreur est survenue !");
        LogMessageManager::register($errfile, $errstr);
        http_response_code(500);
        self::redirect("/error/internal");
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