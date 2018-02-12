<?php
namespace Ng\Core\Managers;

use \ArrayAccess;
use \ArrayIterator;
use \IteratorAggregate;

class Collection implements IteratorAggregate, ArrayAccess
{

    /**
     * les tableau a transform en objet
     * @var array
     */
    private $items;


    /**
     * Collection constructor.
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }


    /**
     * permet de recupere la clef d'un tableau.
     *
     * @param mixed $key recupere la clef d'un tableau.
     * @return $value
     **/
    public function get($key)
    {
        $index = explode(".", $key);
        return $this->getValue($index, $this->items);
    }


    /**
     * renvoi une valeur d'un tableau
     * @param array $indexes
     * @param $value
     * @return null
     */
    private function getValue(array $indexes, $value)
    {
        $key = array_shift($indexes);
        if (empty($indexes)) {
            if (!array_key_exists($key, $value)) {
                return null;
            }
            return $value[$key];
        } else {
            return $this->getValue($indexes, $value[$key]);
        }
    }


    /**
     * permet de definir une clef dans un tableau
     *
     * @param mixed $key la clef a definir.
     * @return void
     **/
    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }
    

    /**
     * verifie si un tableau a une clef
     *
     * @param mixed $key clef a verifier
     * @return bool
     **/
    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }


    /**
     * list les elements d'un tableau par rapport a une valeur
     *
     * @param mixed $key la clef
     * @param mixed $key la valeur cherchée
     * @return Collection
     **/
    public function lists($key, $value): Collection
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[$this->item[$key]] = $item[$value];
        }
        return new self($result);
    }


    /**
     * liste les valeurs d'un tableau par rapport a une clef
     *
     * @param mixed $key la clef
     * @return Collection
     **/
    public function extract($key): Collection
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[] = $item[$key];
        }
        return new self($result);
    }
    

    public function offsetExists($offset)
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }
    
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->items[$offset]);
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }
}
