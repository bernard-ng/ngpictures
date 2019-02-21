<?php
namespace Ngpictures\Traits\Util;

use Ngpictures\Ngpictures;
use Ng\Core\Interfaces\SessionInterface;

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
