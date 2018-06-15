<?php
use Ng\Core\Router\Router;
use Ngpictures\Ngpictures;
use Ng\Core\Exception\RouterException;
use Ng\Core\Managers\LogMessageManager;

/**
 * declaration de la racine du projet
 * inclusion de configuration
 * inclusion du composer/autoload
 */
define("ROOT", dirname(__DIR__));
require(ROOT."/config/ApplicationConfig.php");
require(ROOT."/vendor/autoload.php");


/**
 * error handlers.
 * si la configuration du debug est a "false" les erreur handler
 * sont active dans le cas contraire les erreurs sont afficher
 */
if (Ngpictures::getInstance()->hasDebug()) {
    set_exception_handler([Ngpictures::getInstance(), "exceptionHandler"]);
    set_error_handler([Ngpictures::getInstance(), "errorHandler"]);
}


/**
 * initialisation router et application
 * registration des routes dans la RoutesConfig.php
 */
try {
    $router = new Router($_GET['url'] ?? $_SERVER['REQUEST_URI'], Ngpictures::getInstance());
    require(ROOT."/config/Routes/FrontendRoutes.php");
    require(ROOT."/config/Routes/BackendRoutes.php");
    $router->run();
} catch (RouterException $e) {
    LogMessageManager::register(__class__, $e);
    Ngpictures::redirect("/error/internal");
}
