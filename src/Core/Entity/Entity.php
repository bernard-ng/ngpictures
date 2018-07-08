<?php
namespace Ng\Core\Entity;


class Entity
{

    /**
     * definie un attribut dynamiquement
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        $method = "get".ucfirst($key);
        if (method_exists($this, $method)) {
            $this->$key = $this->$method();
            return $this->$key;
        }
        return null;
    }

    /**
     * on recupere le temps bien formater
     * @return string
     */
    public function getTime(): string
    {
        return date("D d M  Y", strtotime($this->date_created));
    }
}
