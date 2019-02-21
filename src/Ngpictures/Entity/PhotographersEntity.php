<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;

class PhotographersEntity extends Entity
{

    public function getUrl()
    {
        $this->url = "/photographers/profile/";
        $this->url .= "{$this->label}-{$this->id}";
        return $this->url;
    }
}
