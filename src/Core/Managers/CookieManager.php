<?php
namespace Ng\Core\Managers;

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
        setcookie($name, serialize($value), time() * 60 * 24 * 5);
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
