<?php


namespace Ngpic\Entity;


use Core\Entity\Entity;

/**
 * Class NggaleryEntity
 * @package Ngpic\Entity
 */
class NggaleryEntity extends Entity
{
	public function __construct()
    {
        $this->likes = Ngpic::getInstance()->getModel('likes');
        $this->dislikes = Ngpic::getInstance()->getModel('dislikes');
    }
}