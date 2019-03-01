<?php

use function \DI\get;
use function \DI\object;
use function \DI\factory;

use Framework\Renderer\TwigRenderer;
use Framework\Managers\CookieManager;
use Framework\Managers\SessionManager;
use Application\Managers\MessageManager;
use Framework\Interfaces\CookieInterface;
use Framework\Renderer\RendererInterface;
use Framework\Interfaces\SessionInterface;
use Framework\Managers\FlashMessageManager;


return [
    'site.name'         =>  'Ngpictures',
    'site.owner'        =>  'Bernard Ngandu',
    'site.email'        =>  'ngandubernard@gmail.com',
    'site.contact'      =>  'ngpictures@larytech.com',
    'site.description'  =>  " 
        L'expression de la photographie africaine, les meilleures photos partagées par des photographes talentueux.
        Ngpictures est une galerie photo pour photographes et passionnés de la photographie,
        Nous vous proposons de découvrir la photographie africaine autrement. ",

    'ftp.user'      => 'bernard@larytech.com',
    'ftp.pass'      => 'm^7#IEv665kV',

    'database.name' =>  (ENV === 'production')? 'larytech_ngbd' : 'ngpictures2',
    'database.host' =>  (ENV === 'production')? 'larytech.com' : '127.0.0.1',
    'database.user' =>  (ENV === 'production')? 'larytech_ngandu' : 'root',
    'database.pass' =>  (ENV === 'production')? 'E[~}oyE%Ao([' : '',


    \PDO::class => factory(\Framework\Database\PDOFactory::class),

    \Awurth\SlimValidation\Validator::class => object()->constructor(false),
    Glooby\Pexels\Client::class => object()->constructor(PEXELS_API_KEY),
    FlashMessageManager::class => object()->constructor(
        get(SessionInterface::class),
        get(MessageManager::class)
    ),
    RendererInterface::class => object(TwigRenderer::class),
    SessionInterface::class  => object(SessionManager::class),
    CookieInterface::class   => object(CookieManager::class),
];
