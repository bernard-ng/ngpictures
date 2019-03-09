<?php
namespace Framework\Managers;

use Application\Repositories\UsersRepository;
use Stringy\StaticStringy;
use Stringy\Stringy;

/**
 * Class StringHelper
 * @package Framework\Managers
 */
class StringHelper
{

    /**
     * cree un token
     * @param int $length
     * @return string
     */
    public static function setToken(int $length): string
    {
        $components = "1234567890QERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfhjklzxcvbnm";
        $token = substr(uniqid().str_shuffle(str_repeat($components, $length)), 0, $length);
        return $token;
    }


    /**
     * cree un token pour les cookie
     * @return string
     */
    public static function cookieToken(): string
    {
        return mt_rand(1000, 9999). "." . self::setToken(10);
    }

    /**
     * tronque du text
     * @param string $text
     * @param int $maxChar
     * @return string
     */
    public static function truncate($text, int $maxChar = 155)
    {
        if (strlen($text) > $maxChar) {
             $text = substr($text, 0, $maxChar);
             $text = substr($text, 0, strrpos($text, " "));
             $truncated =  $text." ...";
        } else {
             $truncated = $text;
        }
        return $truncated;
    }


    /**
     * slugifie une valeur de bernard ng a bernard-ng
     * @param string $text
     * @return string|null
     */
    public static function slugify($text = "n-a")
    {
        $str = new Stringy($text);
        return $str->slugify();
    }


    /**
     * hash un password ou tout autre valuer int str float
     * @param string $password
     * @return string
     */
    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }


    /**
     * echappe une valeur
     * @param $unescapestring
     * @return string
     */
    public static function escape($unescapestring): string
    {
        return htmlspecialchars($unescapestring);
    }


    /**
     * retire les balises html d'un contenu
     * @param string $string
     * @return string
     */
    public static function getSnipet($string)
    {
        return strip_tags($string, '<a>');
    }


    /**
     * verifie si la version slug correspond a celle non slug
     * @param string $url
     * @param string $name
     * @return string
     */
    public static function checkUserUrl(string $url, string $name): string
    {
        $name = self::slugify($name);
        return $name == $url;
    }
}
