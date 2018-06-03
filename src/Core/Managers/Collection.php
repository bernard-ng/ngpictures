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
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }


    /**
     * renvmoi un tableau de base.
     * @return array
     */
    public function asArray(): array
    {
        return $this->items;
    }


    /**
     * encode le tableau en json.
     * @return string
     */
    public function asJson(): string
    {
        return json_encode($this->items);
    }


    /**
     * renvoi une liste de donne des entites de la base de donne.
     * cree une list d'id des entity de publication...
     * @param string $glue
     * @return string
     */
    public function asList(string $glue = ', '): string
    {
        $list = [];
        foreach($this->items as $item) {

            if (is_object($item)) {
                $list[] = $item->id;
            } else {
                $list[] = $item[0];
            }
        }
        return implode($glue, $list);
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
     * renvoi des donnee sure
     * @param $key
     * @return string
     */
    public function getSafe($key)
    {
        return StringManager::escape($this->get($key));
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


    //implementation des interfaces
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
