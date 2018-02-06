<?php
use Ng\Core\Router\Router;


define("ROOT", dirname(__DIR__));
require(ROOT."/config/ApplicationConfig.php");
require(ROOT."/vendor/autoload.php");

$router = new Router($_GET['url'] ?? $_SERVER['REQUEST_URI'] ?? '/home');
require(ROOT."/config/RoutesConfig.php");
$router->run();
