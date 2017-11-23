<?php
namespace Ngpic\Entity;
use Core\Entity\Entity;
use Core\Generic\Str;
use \Ngpic;


/**
 * Class ArticlesEntity
 * @package Ngpic\Entity
 */
class ArticlesEntity extends Entity
{
    public  $id,
            $title,
            $content,
            $user_id,
            $date_created,
            $thumb,
            $slug;

    public function __construct()
    {
        $this->like = Ngpic::getInstance()->getModel('likes');
        $this->dislike = Ngpic::getInstance()->getModel('dislikes');
        $this->users = Ngpic::getInstance()->getModel('users');
    }

    
    public function getUrl(): string
    {
        $url = "/articles/{$this->slug}-{$this->id}";
        $this->url = $url;
        return $this->url;
    }

    public function getLikeUrl(): string
    {
        $url = "/likes/{$this->slug}-{$this->id}-1-1";
        $this->url = $url;
        return $this->url;
    }

    public function getThumbUrl(): string
    {
        $thumbUrl = "/uploads/articles/{$this->thumb}";
        $this->thumbUrl = $thumbUrl;
        return $this->thumbUrl;
    }

    public function getSI(): string
    {
        return "{$this->slug}-{$this->id}";
    }

    public function getLikes(): string
    {
        return $this->like->getLikeSentence($this->id,1);
    }

    public function getDislikes(): string
    {
        return $this->dislike->getDislikeSentence($this->id,1);
    }

    public function getDislikeUrl(): string
    {
        $url = "/dislikes/{$this->slug}-{$this->id}-1-2";
        $this->url = $url;
        return $this->url;
    }

    public function getML()
    {
        return $this->like->isMentionnedLike($this->id,1);
    }

    public function getMD(){
        return $this->dislike->isMentionnedDislike($this->id,1);
    }

    public function getText(): string
    {
        return $this->text = Str::getSnipet(Str::truncateText($this->content,300));
    }


}
