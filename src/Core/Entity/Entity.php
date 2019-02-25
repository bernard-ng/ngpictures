<?php
namespace Ng\Core\Entity;

/**
 * Class Entity
 * @package Ng\Core\Entity
 */
class Entity
{

    /**
     * @param $key
     * @return null
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
     * @return string
     */
    public function getTime(): string
    {
        return date("D d M  Y", strtotime($this->date_created));
    }
}
