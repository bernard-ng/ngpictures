<?php
namespace Ng\Core\Config;


/**
 * Class Config
 * FR - ceci est la class qui gère la configuration du site à la base de donnée
 * EN - this class administrates database connexion and the website configuration
 * @package Core
 * @author Bernad ng <ngandubernard@gmail.com>
 */
class Config{

    private $settings = [];
    private static $instance;

    public function __construct(string $file)
    {
        $this->settings = require "$file";
    }


    public static function getInstance(string $file): Config
    {
        self::$instance = new self($file);
        return self::$instance;
    }

   
    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }

}
