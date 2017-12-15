<?php
namespace Ng\Core\Entity;



class Entity
{
    
    public function __get($key)
    {
        $method = "get".ucfirst($key);
        if (method_exists($this, $method)) {
        	$this->$key = $this->$method();
        	return $this->$key;
        }
    }


    public function getTime(): string
    {
        $date = new \DateTime();
        return date("D d M  Y", strtotime($this->date_created));
    }


    public function getUsername(): string
	{
		//return $this->users->find($this->user_id)->name;
        return "username";
	}


    public function getUserAccountUrl(): string
    {
        //return $this->users->find($this->user_id)->accountUrl;
        return "account";
    }


    public function getUserAvatarUrl(): string
    {
        //return "/uploads/avatars/{$this->avatar}";
        return "/uploads/avatars/default.jpg";
    }


    public function getUserGalleryUrl(): string 
    {
        //return $this->users->find($this->user_id)->galleryUrl;
        return "gallery";
    }

    


    
    
}