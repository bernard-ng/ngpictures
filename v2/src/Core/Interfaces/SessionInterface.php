<?php
namespace Ng\Core\Interfaces;

/**
 * permet de gerer la session
 */
interface SessionInterface
{
    public static function getInstance();


    /**
     * doit commencer une session si ce n'est pas le cas
     **/
    public function __construct();

    /**
     * recupere une valeur dans la session
     *
     * @param string $key la cle dans la quel on veux recupere la valeur
     * @param string $value la valeur chercher
     * @return mixed
     **/
    public function getValue(string $key, string $value);


    /**
    * permet d'ecrir dans la session
    *
    * @param string
    * @param string $value
    **/
    public function write(string $key, $value);


    /**
     * permet de supprimer une valeur
     *
     * @param string $key la valeur a supprimer
     * @return void
     **/
    public function delete(string $key);


    /**
     * permet de lire une valeur
     *
     * @param string $key la cle a lire
     * @return mixed
     **/
    public function read(string $key);


    /**
     * permet de savoir si une cle existe
     *
     * @param string $key la valeur a verifier
     * @return bool
     **/
    public function hasKey(string $key);
}
