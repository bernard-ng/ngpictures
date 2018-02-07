<?php
namespace Ngpictures\Traits\Util;

use Ng\Core\Managers\Collection;

trait TypesActionTrait
{

    /**
     * les types d'action ou module qu'on peut commenter
     * aimer et partager.
     * @var array
     */
    private $types = [ 1 => 'articles','gallery','blog'];


    /**
     * id du user qui effectue l'action
     * @var null
     */
    private $user_id = null;


    /**
     * permet de recuperer un action grace a son index
     * @param int $type
     * @return string
     */
    private function getType(int $type): string
    {
        $model = new Collection($this->types);
        return $model->get($type);
    }
}
