<?php
namespace Application\Traits\Util;

use Application\Application;
use Framework\Interfaces\SessionInterface;

trait AuthTrait
{

    public static $token;
    public static $activeUser;

    public function __construct()
    {
        self::$token = Application::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        self::$activeUser = Application::getDic()->get(SessionInterface::class)->read(AUTH_KEY);
    }
}
