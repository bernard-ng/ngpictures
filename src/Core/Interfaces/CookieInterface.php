<?php
namespace Ng\Core\Interfaces;

/**
 * Interface CookieInterface
 * @package Ng\Core\Interfaces
 */
interface CookieInterface
{
    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function write(string $key, string $value);


    /**
     * @param string $key
     * @return mixed
     */
    public function delete(string $key);


    /**
     * @param string $key
     * @return mixed
     */
    public function read(string $key);


    /**
     * @param string $key
     * @return mixed
     */
    public function hasKey(string $key);
}
