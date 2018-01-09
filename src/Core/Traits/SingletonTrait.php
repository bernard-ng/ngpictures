<?php
namespace Ng\Core\Traits;

trait SingletonTrait {

    private static $instance;

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
            return self::$instance;
        }
        return self::$instance;
    }
}