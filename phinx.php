<?php

/** @var \Psr\Container\ContainerInterface $container */
$container = require 'config/container.php';
$config = $container->get('config');

return [
    'paths' => [
        'migrations' => $config['database.migrations'],
        'seeds' => $config['database.seeds']
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',

        'production' => [
            'adapter' => 'mysql',
            'host' => $config['database.host'],
            'name' => $config['database.name'],
            'user' => $config['database.user'],
            'pass' => $config['database.pass'],
            'port' => 3306,
            'charset' => 'utf8'
        ],

        'development' => [
            'adapter' => 'mysql',
            'host' => $config['database.host'],
            'name' => $config['database.name'],
            'user' => $config['database.user'],
            'pass' => $config['database.pass'],
            'port' => 3306,
            'charset' => 'utf8'
        ],
    ],

    'version_order' => 'creation'
];
