<?php
namespace Ngpictures\Traits\Models;

trait FindQueryTrait
{

    /**
     * vas chercher les publication en dessus de l'id passer
     * en parametre
     * @param $post_id
     * @return mixed
     */
    public function findLess($post_id)
    {
        return $this->query(
            "SELECT {$this->table}.* , categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE online = 1 AND {$this->table}.id < ? ORDER BY id DESC LIMIT 0, 4",
            [$post_id]
        );
    }


    /**
     * return la publication qui a pour id, l'id passer en parametre
     * @param int $id
     * @return mixed
     */
    public function find(int $id)
    {
        return $this->query(
            "SELECT {$this->table}.*, categories.title as category
            FROM {$this->table}
            LEFT JOIN categories ON categories_id = categories.id
            WHERE {$this->table}.id = ? ORDER BY date_created DESC LIMIT 0,1",
            [$id],
            true,
            true
        );
    }
}
