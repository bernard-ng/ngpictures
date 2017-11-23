<?php


namespace Ngpic\Entity;


use Core\Entity\Entity;

/**
 * Class GaleryEntity
 * @package Ngpic\Entity
 */
class GaleryEntity extends Entity
{
	public function __construct()
    {
        $this->likes = Ngpic::getInstance()->getModel('likes');
        $this->dislikes = Ngpic::getInstance()->getModel('dislikes');
    }
}