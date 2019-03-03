<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Entities;

use Framework\Entities\Entity;
use Application\Application;
use Application\Repositories\BlogRepository;
use Application\Repositories\PostsRepository;

/**
 * Class NotificationsEntity
 * @package Application\Entities
 */
class NotificationsEntity extends Entity
{

    /**
     * @var int
     */
    public $type;

    /**
     * @return string
     */
    public function getTitle()
    {
        switch ($this->type) {
            case 1:
                return "nouvelle publication";
                break;
            case 2:
                return "nouvelle mention j'aime";
                break;
            case 3:
                return "nouveau commentaire";
                break;
            case 4:
                return "nouvel article sur le blog";
                break;
            case 5:
                return "nouvelle photo";
                break;
            case 6:
                return "nouvel abonné";
        }
    }
}
