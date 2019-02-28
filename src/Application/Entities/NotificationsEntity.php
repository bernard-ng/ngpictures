<?php
namespace Application\Entities;

use Framework\Entities\Entity;
use Application\Application;
use Application\Repositories\BlogRepository;
use Application\Repositories\PostsRepository;

class NotificationsEntity extends Entity
{

    public function getUrl()
    {
        $model = Application::getDic()->get(BlogRepository::class);
        $this->url = ''; //$model->find($this->publication_id)->url;
        return $this->url;
    }

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
