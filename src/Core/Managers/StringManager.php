<?php
namespace Ng\Core\Managers;

use Ngpictures\Models\UsersModel;


class StringManager
{

    /**
     * cree un token
     * @param int $length
     * @return string
     */
    public function setToken(int $length): string
    {
        $components = "1234567890QERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfhjklzxcvbnm";
        $token = substr(uniqid().str_shuffle(str_repeat($components, $length)), 0, $length);
        return $token;
    }


    /**
     * cree un token pour les cookie
     * @return string
     */
    public function cookieToken(): string
    {
        return mt_rand(1000, 9999).".".$this->setToken(10);
    }

    /**
     * tronque du text
     * @param string $text
     * @param int $maxChar
     * @return string
     */
    public function truncate($text, int $maxChar = 155)
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
    public function slugify($text = "n-a")
    {
        $text = preg_replace('#[^\pL\d]+#u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('#[^-\w]+#', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('#-+#', '-', $text);
        $text = strtolower($text);
        if (empty($text)) {
            return null;
        }
        return $text;
    }


    /**
     * hash un password ou tout autre valuer int str float
     * @param string $password
     * @return string
     */
    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }


    /**
     * echappe une valeur
     * @param $unescapestring
     * @return string
     */
    public function escape($unescapestring): string
    {
        return htmlspecialchars($unescapestring);
    }


    /**
     * retire les balises html d'un contenu
     * @param string $string
     * @return string
     */
    public function getSnipet($string)
    {
        return strip_tags($string, '<a>');
    }


    /**
     * verifie si la version slug correspond a celle non slug
     * @param string $url
     * @param string $name
     * @return string
     */
    public function checkUserUrl(string $url, string $name): string
    {
        $name = $this->slugify($name);
        return $name == $url;
    }


    /**
     * mention d'un utilisateur
     * @param UsersModel $users
     * @param $text
     * @return string
     */
    public function userMention(UsersModel $users, $text)
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
     * recupere les htags dans une publications
     *
     * @param string $text
     * @return string
     */
    public function htag($text)
    {
        return preg_replace_callback(
            "~#([A-Za-z0-9_]+)~",
            function ($matches) {
                return "<a href='/htag/{$matches[1]}'>{$matches[0]}</a>";
            }, $text
        );
    }


    /**
     * php trimer relatif
     * @param string $time
     * @return string
     */
    public function relativeTime(string $time): string
    {
        setlocale(LC_TIME, 'fr');
        $time = $this->escape(strtotime($time));
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
    public function truncateNumber(int $number): string
    {
        $number = intval($this->escape($number));

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
}
