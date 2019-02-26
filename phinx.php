<?php

use Ng\Core\Database\DatabaseInterface;

require __DIR__."/public/index.php";
$connection = $container->get(DatabaseInterface::class)->getPdo();

return  [
    'paths' => [
        'migrations' => __DIR__ ."/data/migrations",
        'seeds' => __DIR__."/data/seeds",
    ],

    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => 'development',
        'development' => [
            'name' => 'ngpictures2',
            'connection' => $connection,
            'collation' => 'utf8_unicode_ci',
            'charset' => 'utf8',
        ],
        'production' => [
            'name' => 'larytech_ngbd',
            'connection' => $connection,
            'collation' => 'utf8_unicode_ci',
            'charset' => 'utf8',
        ]
    ]
];