<?php

declare(strict_types=1);

namespace Core\Session;

/**
 * Class PHPSession
 * @package Core\Session
 */
class PHPSession implements SessionInterface
{

    /**
     * whether the session is active
     */
    private function ensureStarted(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_name("ngpictures_ssid");
            session_start();
        }
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            return $_SESSION[$key];
        }
        return $default;
    }

    /**
     * @param string $key
     * @param $value
     * @return void
     */
    public function set(string $key, $value): void
    {
        $this->ensureStarted();
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return void
     */
    public function delete(string $key): void
    {
        $this->ensureStarted();
        if (array_key_exists($key, $_SESSION)) {
            unset($_SESSION[$key]);
        }
    }
}
