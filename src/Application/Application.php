<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application;

use Application\Controllers\ErrorController;
use Framework\Managers\FlashMessageManager;
use Framework\Managers\LogMessageManager;
use Framework\Router\Router;
use Psr\Container\ContainerInterface;

/**
 * Class Application
 * @package Application
 */
class Application
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Application constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * run the application
     * @return mixed
     */
    public function run()
    {
        $router = $this->container->get(Router::class);
        (require ROOT."/config/routes/frontend.php")($router);
        (require ROOT."/config/routes/backend.php")($router);

        $route = $router->run();
        if (!is_null($route)) {
            $controller = $this->container->get($route->getController()[0]);

            $method = $route->getController()[1] ?? 'index';
            return call_user_func_array([$controller, $method], $route->getMatches());
        } else {
            $error = $this->container->get(ErrorController::class);
            return $error->e404();
        }
    }


    /**
     * @param $e
     */
    public function exceptionHandler($e)
    {
        $this->container->get(FlashMessageManager::class)->set('danger', "Oups une erreur est survenue !");
        LogMessageManager::register(__class__, $e);
        $error = $this->container->get(ErrorController::class);
        return $error->e500();
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
        $error = $this->container->get(ErrorController::class);
        return $error->e500();
    }
}
