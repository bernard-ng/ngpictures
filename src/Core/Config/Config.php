<?php
namespace Ng\Core\Config;


use Ng\Core\Traits\SingletonTrait;


/**
 * gestion de configuration du projet
 */
class Config{

    /**
    *   le tableau qui contiendra toutes le configuration
    *   initialiser.
    */
    private $settings = [];
    
    use SingletonTrait;

    /*
    *   c'est ne pas un singleton ici, on retroune une nouvelle instance
    *   a chaque fois.
    */
    public static function getInstance(string $file): Config
    {
        self::$instance = new self($file);
        return self::$instance;
    }


    /**
    * charge la configuration dans l'instance.
    * a partir d'un fichier. 
    */
    public function __construct(string $file)
    {
        $this->settings = require "$file";
    }


    /**
    * permet de recupere un valeur dans un fichier de configuration
    */
    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }
}
