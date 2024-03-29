<?php
namespace Framework\Interfaces;

/**
 * Interface SessionInterface
 * @package Framework\Interfaces
 */
interface SessionInterface
{
    /**
     * @param string $key
     * @param string $value
     * @return mixed
     */
    public function getValue(string $key, string $value);

    /**
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function write(string $key, $value);

    /**
     * @param string $key
     * @return void
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
