<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;

class VersesEntity extends Entity
{
    /**
     * permet de separer le chapitre du verset
     * afin de donner la vrai reference
     * @return string
     */
    public function getReference()
    {
        return implode(' ', explode('.', $this->ref));
    }
}
