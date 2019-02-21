<?php
namespace Application\Traits\Util;

use Application\Ngpictures;
use Framework\Interfaces\SessionInterface;

trait AuthTrait
{

    public static $token;
    public static $activeUser;

    public function __construct()
    {
        self::$token = Ngpictures::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        self::$activeUser = Ngpictures::getDic()->get(SessionInterface::class)->read(AUTH_KEY);
    }
}
