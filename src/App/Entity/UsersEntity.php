<?php
namespace Ngpic\Entity;


use Core\Entity\Entity;

/**
 * Class UsersEntity
 * @package Ngpic\Entity
 */
class UsersEntity extends Entity
{
	public function getAccountUrl()
	{
		return "/account/{$this->name}-{$this->id}";
	}
}