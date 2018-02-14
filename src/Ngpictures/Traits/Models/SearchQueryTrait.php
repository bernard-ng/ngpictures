<?php
namespace Ngpictures\Traits\Models;

trait SearchQueryTrait
{

    public function search(string $query)
    {
        return $this->query(
            "SELECT * FROM {$this->table} WHERE title LIKE '%{$query}%' ",
            null,
            true,
            false
        );
    }


}
