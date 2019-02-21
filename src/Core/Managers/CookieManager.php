<?php
namespace Ng\Core\Managers;

use DateTime;
use Ng\Core\Interfaces\CookieInterface;
use Ng\Core\Traits\SingletonTrait;

class CookieManager implements CookieInterface
{

    use SingletonTrait;

    /**
     * permet de savoir si une key est definit
     * @param string $name
     * @return bool
     */
    public function hasKey(string $name)
    {
        return isset($_COOKIE[$name]);
    }


    /**
     * ecrire dans le tableau cookie
     * @param string $name
     * @param string $value
     */
    public function write(string $name, string $value)
    {
        setcookie($name, serialize($value), (new DateTime('now + 15day'))->format('U'));
    }


    /**
     * lecture d'une key
     * @param string $name
     * @return mixed|null
     */
    public function read(string $name)
    {
        return unserialize($_COOKIE[$name]) ?? null;
    }


    /**
     * suppression d'un key
     * @param string $name
     */
    public function delete(string $name)
    {
        setcookie($name, null, -1);
    }
}