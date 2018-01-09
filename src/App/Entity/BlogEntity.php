<?php
namespace Ngpictures\Entity;


use Ng\Core\Entity\Entity;
use Ng\Core\Generic\Str;
use Ngpictures\Ngpic;


class BlogEntity extends Entity
{
    public function __construct()
    {
        parent::__construct();
        $this->like = Ngpic::getInstance()->getModel('likes');
        $this->users = Ngpic::getInstance()->getModel('users');
    }


    public function getUrl(): string
    {
        $this->url = "/blog/{$this->slug}-{$this->id}";
        return $this->url;
    }


    public function getCategoryUrl(): string
    {
        $category= Str::Slugify($this->category);
        $this->categoryUrl = "/categories/{$category}-{$this->category_id}";
        return $this->categoryUrl;
    }


    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads/blog/{$this->thumb}";
        return $this->thumbUrl;
    }


    public function getdownloadUrl(): string
    {
        $this->downloadUrl = "/download/3/{$this->thumb}";
        return $this->downloadUrl;
    }


    public function getLikeUrl(): string
    {
        $this->likeurl = "/likes/3/{$this->slug}-{$this->id}";
        return $this->likeurl;
    }


    public function getCommentUrl(): string
    {
        $this->commentUrl = "/comments/3/{$this->slug}-{$this->id}";
        return $this->commentUrl;
    }


    public function getSI(): string
    {
        return "{$this->slug}-{$this->id}";
    }


    public function getLikes(): string
    {
        return $this->like->getLikeSentence($this->id, 3);
    }


    public function getIsLike(): string
    {
        return $this->like->isMentionnedLike($this->id, 3);
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
