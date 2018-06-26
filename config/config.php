<?php

use function \DI\get;
use function \DI\object;
use function \DI\factory;

use Ngpictures\Models\UsersModel;
use Ng\Core\Renderer\TwigRenderer;
use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\CookieManager;
use Ng\Core\Managers\SessionManager;
use Ng\Core\Database\DatabaseInterface;
use Ng\Core\Interfaces\CookieInterface;
use Ng\Core\Renderer\RendererInterface;
use Ng\Core\Interfaces\SessionInterface;


return [

    'database.name' =>  (ENV === 'production')? 'larytech_ngbd' : 'ngbdd',
    'database.host' =>  (ENV === 'production')? 'larytech.com' : '127.0.0.1',
    'database.user' =>  (ENV === 'production')? 'larytech_ngandu' : 'root',
    'database.pass' =>  (ENV === 'production')? '/&sF^2`Wjhquq2Hm~k`,' : '',

    DatabaseInterface::class => object(MysqlDatabase::class)->constructor(
        get('database.name'),
        get('database.host'),
        get('database.user'),
        get('database.pass')
    ),
    \PDO::class => factory([MysqlDatabase::class, 'getPDO']),


    RendererInterface::class => object(TwigRenderer::class),
    SessionInterface::class  => object(SessionManager::class),
    CookieInterface::class   => object(CookieManager::class),
];
