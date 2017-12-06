<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;



class VersesEntity extends Entity
{
	public function getReference()
	{
		return implode(' ',explode('.', $this->ref));
	}
}