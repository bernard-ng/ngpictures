<?php
namespace Ng\Core\Interfaces;

interface CookieInterface
{
    /**
     * permet d'ecrir dans la session
     *
     * @param string $key
     * @param string $value
     **/
    public function write(string $key, string $value);


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
