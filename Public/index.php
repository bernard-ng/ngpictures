<?php
use DI\ContainerBuilder;
use Ngpictures\Ngpictures;

/**
 * inclusion de configuration
 * inclusion du composer/autoload
 */
require(dirname(__DIR__)."/config/constant.php");
require(dirname(__DIR__)."/config/ini.php");
require(ROOT."/vendor/autoload.php");

include_once WEBROOT ."/befree/config.php";
include_once WEBROOT ."/befree/project-security.php";

$container = new ContainerBuilder();
$container->addDefinitions(ROOT."/config/config.php");
$container = $container->build();

$application = new Ngpictures($container);
if (ENV === 'production') {
    set_exception_handler([$application, "exceptionHandler"]);
    set_error_handler([$application, "errorHandler"]);
}

$application->run();
