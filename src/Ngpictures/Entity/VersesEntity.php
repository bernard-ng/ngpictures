<?php
namespace Application\Entity;

use Application\Ngpictures;
use Framework\Entity\Entity;

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
