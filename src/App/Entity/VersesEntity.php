<?php


namespace Ngpic\Entity;


use Core\Entity\Entity;

/**
 * Class GodfirstEntity
 * @package Ngpic\Entity
 */
class VersesEntity extends  Entity
{
	public function getReference()
	{
		return implode(' ',explode('.', $this->ref));
	}
}