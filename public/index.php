<?php

use DI\ContainerBuilder;
use Doctrine\Common\Cache\FilesystemCache;
use Application\Application;

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

$application = new Application($container);
if (php_sapi_name() !== 'cli') {
    $application->run();
}
