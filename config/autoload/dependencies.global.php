<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'aliases' => [
            \Core\Session\SessionInterface::class => \Core\Session\PHPSession::class,
        ],


        'invokables' => [
            // Fully\Qualified\InterfaceName::class => Fully\Qualified\ClassName::class,
        ],


        'factories'  => [
            \PDO::class => \Core\Database\PDOFactory::class,
        ],
    ],
];
