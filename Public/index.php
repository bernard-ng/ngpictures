<?php
use Ng\Core\Router\Router;
use Ngpictures\Ngpictures;
use Ng\Core\Exception\RouterException;

define("ROOT", dirname(__DIR__));
require(ROOT."/config/ApplicationConfig.php");
require(ROOT."/vendor/autoload.php");

set_exception_handler([Ngpictures::getInstance(), "exceptionHandler"]);
set_error_handler([Ngpictures::getInstance(), "errorHandler"]);

try {
    $router = new Router($_GET['url'] ?? $_SERVER['REQUEST_URI'] ?? '/home');
    require(ROOT."/config/RoutesConfig.php");
    $router->run();
} catch (RouterException $e) {
    Ngpictures::redirect("/error-500");
}
