<?php
namespace Ng\Core\Managers;

use Ng\Core\Exception\ConfigManagerException;

class ConfigManager
{

    /**
    *   le tableau qui contiendra toutes le configuration initialiser.
    */
    private $settings = [];


    /**
    * charge la configuration dans l'instance. a partir d'un fichier.
    */
    public function __construct(string $filename)
    {
        if (file_exists($filename)) {
            $this->settings = require "$filename";
            $this->collection = new Collection($this->settings);
        } else {
            throw new ConfigManagerException("{$filename} not found");
        }
    }


    /**
    * permet de recupere un valeur dans un fichier de configuration
    */
    public function get(string $key)
    {
        return $this->collection->get($key);
    }
}
