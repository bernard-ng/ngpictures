<?php
namespace Ng\Core\Entity;

use Ngpictures\Ngpictures;

class Entity
{
    /**
     * definie un attribut dynamiquement
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        $method = "get".ucfirst($key);
        if (method_exists($this, $method)) {
            $this->$key = $this->$method();
            return $this->$key;
        }
        return null;
    }

    /**
     * @var null
     */
    private $user = null;


    /**
     * renvoi un mm utilisateur pour chaque obj
     * @return null
     */
    private function getUser()
    {
        if ($this->user !== null) {
            return $this->user;
        } else {
            $this->user = Ngpictures::getInstance()
                ->getModel('users')
                ->find($this->user_id ?? $this->id);
            return $this->user;
        }
    }


    /**
     * on recupere le temps bien formater
     * @return string
     */
    public function getTime(): string
    {
        return date("D d M  Y", strtotime($this->date_created));
    }


    /**
     * recupere les infos d'un user
     * @param string $info
     * @return mixed
     */
    public function userInfos(string $info)
    {
        return $this->getUser()->$info;
    }
}
