<?php
namespace Ng\Core\Traits;

/**
 * Class SingletonTrait
 * @package Ng\Core\Traits
 */
trait SingletonTrait
{
    /**
     * l'instance a renvoyer chaque fois. par default null
     * @var null
     */
    private static $instance = null;


    /**
     * @return SingletonTrait
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
            return self::$instance;
        }
        return self::$instance;
    }
}
