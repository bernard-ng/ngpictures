<?php

use function \DI\get;
use function \DI\object;
use function \DI\factory;

use ReCaptcha\ReCaptcha;
use Ngpictures\Models\UsersModel;
use Ng\Core\Renderer\TwigRenderer;
use Ng\Core\Database\MysqlDatabase;
use Ng\Core\Managers\CookieManager;
use Ng\Core\Managers\SessionManager;
use Ngpictures\Managers\MessageManager;
use Ng\Core\Database\DatabaseInterface;
use Ng\Core\Interfaces\CookieInterface;
use Ng\Core\Renderer\RendererInterface;
use Ng\Core\Interfaces\SessionInterface;
use Ng\Core\Managers\FlashMessageManager;


return [

    'site.name'         =>  'Ngpictures',
    'site.owner'        =>  'Bernard Ngandu',
    'site.email'        =>  'ngandubernard@gmail.com',
    'site.contact'      =>  'ngpictures@larytech.com',
    'site.category'     =>  'Photographie & Blog',
    'site.lang'         =>  'fr_FR',
    'site.country'      =>  'République Democratique du Congo',
    'site.copyritght'   =>  '<a href="http://ngpictures.pe.hu">Bernard Ng</a>',
    'site.description'  =>  "
        Ngpictures est une galerie d'art photographique et un mini résaux social où
        vous pouvez voir et partager vos propres photos, lire et écrire vos posts sur les sujets qui vous intéresses,
        étant chrétiens l'application vous propose une fonctionnalité incroyable,
        godfirst : partagez et lisez la parole de Dieu avec plus de 500 versets choisis pour vous à l'avance.",

    'ftp.user'      => 'bernard@larytech.com',
    'ftp.pass'      => 'm^7#IEv665kV',

    'database.name' =>  (ENV === 'production')? 'larytech_ngbd' : 'ngpictures',
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

    ReCaptcha::class => object()->constructor(RECAPTCH_API_KEY),
    Glooby\Pexels\Client::class => object()->constructor(PEXELS_API_KEY),
    FlashMessageManager::class => object()->constructor(
        get(SessionInterface::class),
        get(MessageManager::class)
    ),
    RendererInterface::class => object(TwigRenderer::class),
    SessionInterface::class  => object(SessionManager::class),
    CookieInterface::class   => object(CookieManager::class),
];
