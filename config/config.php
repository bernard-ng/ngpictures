<?php

use function DI\factory;
use function DI\get;
use function DI\object;


return [
    'site.name' => 'Ngpictures',
    'site.owner' => 'Bernard Ngandu',
    'site.email' => 'ngandubernard@gmail.com',
    'site.contact' => 'ngpictures@larytech.com',
    'site.description' => " 
        L'expression de la photographie africaine, les meilleures photos partagées par des photographes talentueux.
        Ngpictures est une galerie photo pour photographes et passionnés de la photographie,
        Nous vous proposons de découvrir la photographie africaine autrement. ",

    'ftp.user' => 'bernard@larytech.com',
    'ftp.pass' => 'm^7#IEv665kV',

    'database.name' => (ENV === 'production') ? 'larytech_ngbd' : 'ngpictures2.1.1',
    'database.host' => (ENV === 'production') ? 'larytech.com' : '127.0.0.1',
    'database.user' => (ENV === 'production') ? 'larytech_ngandu' : 'root',
    'database.pass' => (ENV === 'production') ? 'E[~}oyE%Ao([' : '',


    \PDO::class => factory(\Framework\Database\PDOFactory::class),

    \Awurth\SlimValidation\Validator::class => object()->constructor(false),
    Glooby\Pexels\Client::class => object()->constructor(PEXELS_API_KEY),

    \Framework\Managers\FlashMessageManager::class => object()->constructor(
        get(\Framework\Managers\SessionManager::class),
        get(\Application\Managers\MessageManager::class)
    ),

    \Framework\Renderer\RendererInterface::class => factory(\Framework\Renderer\TwigRendererFactory::class),
    \Framework\Interfaces\SessionInterface::class => get(\Framework\Managers\SessionManager::class),
    \Framework\Interfaces\CookieInterface::class => get(\Framework\Managers\CookieManager::class),
    \Framework\Auth\AuthInterface::class => get(\Application\Auth\DatabaseAuth::class),
    \League\Event\EmitterInterface::class => factory(\Framework\Events\EmitterFactory::class)
];
