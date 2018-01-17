<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;
use Ng\Core\Generic\{Str, Session};



class UsersEntity extends Entity
{
    /**
     * le lien vers le compte d'un user
     * @return mixed|string
     */
	public function getAccountUrl()
	{
		$this->accountUrl = "/account/".Str::slugify($this->name)."-{$this->id}";
		return $this->accountUrl;
	}


    /**
     * le lien vers l'edition du profile
     * @return mixed|string
     */
    public function getEditUrl()
	{
		$session = Session::getInstance();
		$this->editUrl = "/account/edit/".Str::slugify($this->name)."-{$this->id}/".$session->read(TOKEN_KEY);
		return $this->editUrl;
	}


    /**
     * le lien vers toutes les publications d'un user
     * @return mixed
     */
    public function getPostsUrl()
    {
        $this->PostsUrl = "/account/my-posts/".Str::slugify($this->name)."-{$this->id}";
        return $this->PostUrl;
    }


    /**
     * le lien vers la liste des ses amies(followers)
     * @return mixed|string
     */
    public function getFriendsUrl()
    {
        $session = Session::getInstance();
        $this->friendsUrl = "/account/my-friends/".Str::slugify($this->name)."-{$this->id}/".$session->read(TOKEN_KEY);
        return $this->friendsUrl;
    }


    /**
     * le lien vers son avatar
     * @return mixed|string
     */
    public function getAvatarUrl()
	{
		$this->avatarUrl = "/uploads/avatars/{$this->avatar}";
		return $this->avatarUrl;
	}
}
