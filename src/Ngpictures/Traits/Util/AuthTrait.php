<?php
namespace Ngpictures\Traits\Util;

use Ngpictures\Ngpictures;
use Ng\Core\Interfaces\SessionInterface;
use Ngpictures\Services\Auth\DatabaseAuthService;

trait AuthTrait
{

    public static $token;
    public static $activeUser;

    public function __construct()
    {
        self::$token = Ngpictures::getDic()->make(DatabaseAuthService::class)->getToken();
        self::$activeUser = Ngpictures::getDic()->get(SessionInterface::class)->read(AUTH_KEY);
    }
}
