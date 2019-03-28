<?php

require __DIR__ . "/public/index.php";
$connection = $container->get(PDO::class);

return [
    'paths' => [
        'migrations' => [
            __DIR__ . "/data/migrations/updates",
            __DIR__ . "/data/migrations/create",
        ],
        'seeds' => [
            __DIR__ . "/data/seeds",
            __DIR__ . "/data/seeds/create",
            __DIR__ . "/data/seeds/updates",
        ],
    ],

    'environments' => [
        'default_migration_table' => 'phinx_migrations_logs',
        'default_database' => 'development',
        'development' => [
            'name' => $container->get('database.name'),
            'connection' => $connection,
            'collation' => 'utf8_unicode_ci',
            'charset' => 'utf8',
        ],
        'production' => [
            'name' => $container->get('database.name'),
            'connection' => $connection,
            'collation' => 'utf8_unicode_ci',
            'charset' => 'utf8',
        ],
    ],
];