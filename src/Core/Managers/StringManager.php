<?php
namespace Ng\Core\Managers;

use Ngpictures\Models\UsersModel;

/**
 * gestion des chaines des charateres
 * Class Str
 * @package Ng\Core\Generic
 */
class StringManager
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
        return mt_rand(1000, 9999).".".self::setToken(10);
    }


    /**
     * supprime les accents et rend le string kebaba_case
     * @param string $string
     * @return string
     */
    public static function kebabCase(string $string): string
    {
        //&grave; &acute; &circ; &uml; &cedil; &tilde; &ring;
        $removed = preg_replace("#À|À|Á|Â|Ã|Ä|Å|à|á|â|ã|ä|å#", "a", $string);
        $removed = preg_replace("#Ò|Ó|Ô|Õ|Ö|Ø|ò|ó|ô|õ|ö|ø#", "o", $removed);
        $removed = preg_replace("#È|É|Ê|Ë|è|é|ê|ë#", "e", $removed);
        $removed = preg_replace("#Ç|ç#", "c", $removed);
        $removed = preg_replace("#Ì|Í|Î|Ï|ì|í|î|ï#", "i", $removed);
        $removed = preg_replace("#Ù|Ú|Û|Ü|ù|ú|û|ü#", "u", $removed);
        $removed = preg_replace("#Ý|ý|ÿ#", "y", $removed);
        $removed = preg_replace("#Ñ|ñ#", "n", $removed);
    
        $formated = trim($removed);
        if (preg_match("/[ ]+/", $formated)) {
            $formated = implode(explode(" ", $formated), "_");
        }
        return $formated;
    }


    /**
     * tronque du text
     * @param string $text
     * @param int $maxChar
     * @return string
     */
    public static function truncateText(string $text, int $maxChar = 155): string
    {
        if (strlen($text) > $maxChar) {
             $text = substr($text, 0, $maxChar);
             $text = substr($text, 0, strrpos($text, " "));
             $truncated =  $text."[...]";
        } else {
             $truncated = $text;
        }
        return $truncated;
    }


    /**
     * slugifie une valeur de bernard ng a bernard-ng
     * @param string $text
     * @return string
     */
    public static function slugify($text = "n-a"): string
    {
        $text = preg_replace('#[^\pL\d]+#u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('#[^-\w]+#', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('#-+#', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
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
    public static function getSnipet(string $string): string
    {
        $snipet = preg_replace('#<p>|</p>#', '', $string);
        $snipet = preg_replace('#<h1>|<h2>|<h3>|<h4>|<h5>|</h1>|</h2>|</h3>|</h4>|</h5>#', '', $snipet);
        $snipet = preg_replace('#<ul>|<ol>|</ul>|</ol>#', '', $snipet);
        $snipet = preg_replace('#<img>#', '', $snipet);
        $snipet = preg_replace('#<blockquote>|</blockquote>#', '', $snipet);
        $snipet = preg_replace('#<em>|</em>#', '', $snipet);
        return $snipet;
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


    /**
     * mention d'un utilisateur
     * @param UsersModel $users
     * @param $text
     * @return string
     */
    public static function userMention(UsersModel $users, $text): string
    {
        return preg_replace_callback(
            "#@([A-Za-z0-9-_]+)#",
            function ($matches) use ($users) {
                $user = $users->findWith('name', $matches[1]);
                if ($user) {
                    return "<a href='{$user->accountUrl}' title='Voir le profil'>{$matches[0]}</a>";
                }
                return $matches[0];
            },
            $text
        );
    }


    /**
     * php trimer relatif
     * @param string $time
     * @return string
     */
    public static function relativeTime(string $time): string
    {
        setlocale(LC_TIME, 'fr');
        $time = self::escape(strtotime($time));
        $time = time() - $time ;
        
        switch ($time) {
            case $time >= 3600 && $time <= 86400:
                $ago = intval($time / 3600);
                $relative_time = "il y a {$ago} ". ($ago > 1)? "heures" : "heure";
                break;

            case $time >= 60 && $time < 3600:
                $ago = intval(($time % 3600) / 60);
                $relative_time = "il y a {$ago} ". ($ago > 1)? "minutes" : "minute";
                break;

            case $time > 86400 &&  $time <= 604800:
                $ago = intval($time / 86400);
                $relative_time = "il y a {$ago} ". ($ago > 1)? "jours" : "jour";
                break;

            case $time > 604800:
                $days = substr(strftime('%d', $time), 0, 3);
                $date = (date("Y") == strftime("Y", $time))? ucfirst(strftime('%B', $time)) : ucfirst(strftime('%B', $time));
                $relative_time = "{$days} {$date}";
                break;

            default:
                $ago = intval($time % 60);
                $relative_time = "il y a {$ago} ". ($ago > 1)? "secondes" : "seconde";
                break;
        }
        return $relative_time;
    }


    /**
     * format un grand monbre en K ou M
     * @param int $number
     * @return string
     */
    public static function truncateNumber(int $number): string
    {
        $number = intval(self::escape($number));

        switch ($number) {
            case $number >= 0 && $number < 1000:
                return (string) $number;
                break;

            case $number >= 1000 && $number < 100000:
                $number = round(($number / 1000), 1);
                return "{$number}K";
                break;

            case $number >= 100000:
                $number = round(($number / 100000), 1);
                return "{$number}M";
                break;
            
            default:
                return $number;
                break;
        }
    }


    /**
     * genere des balises meta a partir d'un tableau
     * @param array $data
     */
    public static function generateMeta(array $data = [])
    {
        $array_meta = [];

        foreach ($data as $k => $v) {
            $array_meta[] = "{$k} ='$v' ";
        }

        $meta = implode(' ', $array_meta);
        echo "<meta {$meta} >";
    }
}
