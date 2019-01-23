<?php

declare(strict_types=1);

namespace Core\Session;

/**
 * Interface SessionInterface
 * @package Core\Session
 */
interface SessionInterface
{

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void;

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key): void;
}
