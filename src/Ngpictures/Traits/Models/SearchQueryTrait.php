<?php
namespace Ngpictures\Traits\Models;

trait SearchQueryTrait
{

    /**
     * permet de faire une recherche selon l'option donnee
     * begin    :   vas chercher du contenu commencant par $query
     * end      :   vas chercher du contenu finissant par $query
     * within   :   vas chercher du contenu contenant dans le titre la $query
     * concat   :   vase Chercher du contenu contenant dans le titre et le contenu la $query
     * @param string $query
     * @param string $option l'option de la rechercher
     */
    public function search(string $query, string $option = "begin")
    {
        $query      =   addslashes(htmlentities($query));
        $title      =   ($this->table == 'gallery')? 'name' : 'title';
        $content    =   ($this->table == 'gallery')? 'description' : 'content';

        switch ($option) {
            case "begin":
                return $this->query(
                    "SELECT * FROM {$this->table} WHERE {$title} LIKE ? and online = 1",
                    ["{$query}%"],
                    true,
                    false
                );
                break;

            case "end":
                return $this->query(
                    "SELECT * FROM {$this->table} WHERE {$title} LIKE ? and online = 1",
                    ["%{$query}"],
                    true,
                    false
                );
                break;

            case "within":
                return $this->query(
                    "SELECT * FROM {$this->table} WHERE {$title} LIKE ? and online = 1",
                    ["%{$query}%"],
                    true,
                    false
                );
                break;

            case "concat":
                return $this->query(
                    "SELECT * FROM {$this->table} WHERE CONCAT({$title},{$content}) LIKE ? and online = 1",
                    ["%{$query}%"],
                    true,
                    false
                );
                break;

            default:
                return null;
                break;
        }
    }
}
