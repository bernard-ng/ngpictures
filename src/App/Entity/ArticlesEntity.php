<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;

use Ng\Core\Generic\Str;

use Ngpictures\Ngpic;


class ArticlesEntity extends Entity
{
    
    public function __construct()
    {
        $this->like = Ngpic::getInstance()->getModel('likes');
        $this->users = Ngpic::getInstance()->getModel('users');
    }


    public function getUrl(): string
    {
        $this->url = "/articles/{$this->slug}-{$this->id}";
        return $this->url;
    }


    public function getLikeUrl(): string
    {
        $this->url = "/likes/{$this->slug}-{$this->id}-1";
        return $this->url;
    }


    public function getCommentUrl(): string
    {
        $this->commentUrl = "/comments/{$this->slug}-{$this->id}-1";
        return $this->commentUrl;
    }


    public function getdownloadUrl(): string
    {
        $this->downloadUrl = "/download/1/{$this->thumb}";
        return $this->downloadUrl;
    }


    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads/articles/{$this->thumb}";
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


    public function getIsLike()
    {
        return $this->like->isMentionnedLike($this->id,1);
    }


    public function getSnipet(): string
    {
        $content = Str::userMention($this->users, $this->content);
        $this->text = Str::getSnipet(Str::truncateText($content, 300));
        
        return $this->text;
    }


    public function getFullText(): string
    {
        return Str::userMention($this->users, $this->content);
    }
}
