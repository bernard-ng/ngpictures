<?php
namespace Core\Generic;

class Str
{
    
    public static function setToken(int $length): string
    {
        $composants = "1234567890QERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfhjklzxcvbnm";
        $token = substr(uniqid().str_shuffle(str_repeat($composants,$length)), 0, $length );
        return $token;
    }

    public static function cookieToken(): string
    {
        return mt_rand(1000,9999).".".self::setToken(10);
    }

    public static function KebabCase(string $string): string
    {
        //&grave; &acute; &circ; &uml; &cedil; &tilde; &ring;
        $removed = preg_replace("#À|À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å#", "a", $string);
        $removed = preg_replace("#Ò|Ó|Ô|Õ|Ö|Ø|ò|ó|ô|õ|ö|ø#","o",$removed);
        $removed = preg_replace("#È|É|Ê|Ë|è|é|ê|ë#","e",$removed);
        $removed = preg_replace("#Ç|ç#","c", $removed);
        $removed = preg_replace("#Ì|Í|Î|Ï|ì|í|î|ï#","i",$removed);
        $removed = preg_replace("#Ù|Ú|Û|Ü|ù|ú|û|ü#","u",$removed);
        $removed = preg_replace("#Ý|ý|ÿ#","y",$removed);
        $removed = preg_replace("#Ñ|ñ#","n",$removed);
    
        $formated = trim($removed);
        if (preg_match("/[ ]+/",$formated)) {
            $formated = implode(explode(" ", $formated), "_");
        }
        return $formated;
    }


    public static function toUrl(string $string): string
    {
        $url = trim($string,'_');
        $formated = preg_replace("#_#","-", $url);
        return $formated;
    }

    
    public static function truncateText(string $text, int $maxChar = 155): string
    {
        if (strlen($text) > $maxChar) {
             $text = substr($text, 0, $maxChar);
             $text = substr($text, 0, strrpos($text, " "));
             $truncated =  $text."...";
        } else {
             $truncated = $text;
        }
        return $truncated;
    }


    public static function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public static function escape($unescapestring)
    {
        return htmlspecialchars($unescapestring);
    }

    public static function getSnipet($string): string
    {
        $snipet = preg_replace('#<p>|</p>#', '', $string);
        $snipet = preg_replace('#<h1>|<h2>|<h3>|<h4>|<h5>|</h1>|</h2>|</h3>|</h4>|</h5>#', '', $snipet);
        $snipet = preg_replace('#<ul>|<ol>|</ul>|</ol>#', '', $snipet);
        $snipet = preg_replace('#<img>#', '', $snipet);
        $snipet = preg_replace('#<blocquote>|</blocquote>#', '', $snipet);
        $snipet = preg_replace('#<em>|</em>#', '', $snipet);
        return $snipet;
    }
}
