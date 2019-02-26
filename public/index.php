<?php
use DI\ContainerBuilder;
use Doctrine\Common\Cache\FilesystemCache;
use Ngpictures\Ngpictures;

/**
 * inclusion de configuration
 * inclusion du composer/autoload
 */
require(dirname(__DIR__)."/config/constant.php");
require(dirname(__DIR__)."/config/ini.php");
require(ROOT."/vendor/autoload.php");

$container = new ContainerBuilder();

if (ENV === 'production') {
    $container->setDefinitionCache(new FilesystemCache(ROOT."/cache/phpdi"));
    $container->writeProxiesToFile(true, ROOT."/cache/proxies");
}
$container->addDefinitions(ROOT."/config/config.php");
$container = $container->build();

$application = new Ngpictures($container);
if (ENV === 'production') {
    set_exception_handler([$application, "exceptionHandler"]);
    set_error_handler([$application, "errorHandler"]);
}

if (php_sapi_name() !== 'cli') {
    $application->run();
}
