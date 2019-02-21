<?php
namespace Ngpictures\Entity;

use Ngpictures\Ngpictures;
use Ng\Core\Entity\Entity;

class VersesEntity extends Entity
{
    /**
     * permet de separer le chapitre du verset
     * afin de donner la vrai reference
     * @return string
     */
    public function getReference(): string
    {
        return implode(' ', explode('.', $this->ref));
    }
}
