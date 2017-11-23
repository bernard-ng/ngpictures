<?php
namespace Ngpic\Entity;


use Core\Entity\Entity;
use Core\Generic\Str;
use \Ngpic;

/**
 * Class NgarticlesEntity
 * @package Ngpic\Entity
 */
class NgarticlesEntity extends Entity
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
    }

    public function getUrl()
    {
        $url = "/blog/{$this->slug}-{$this->id}";
        $this->url = $url;
        return $this->url;
    }

    public function getThumbUrl()
    {
        $thumbUrl = "/uploads/blog/{$this->thumb}";
        $this->thumbUrl = $thumbUrl;
        return $this->thumbUrl;
    }

    public function getLikeUrl()
    {
        $url = "/likes/{$this->slug}-{$this->id}-3-1";
        $this->likeurl = $url;
        return $this->likeurl;
    }

    public function getDislikeUrl()
    {
        $url = "/dislikes/{$this->slug}-{$this->id}-3-2";
        $this->dislikeurl = $url;
        return $this->dislikeurl;
    }


    public function getCommentUrl(): string
    {
        $url = "/comments/{$this->slug}-{$this->id}-3";
        $this->commentUrl = $url;
        return $this->commentUrl;
    }

    public function getSI(): string
    {
        return "{$this->slug}-{$this->id}";
    }

    public function getLikes(): string
    {
        return $this->like->getLikeSentence($this->id,3);
    }

    public function getDislikes(): string
    {
        return $this->dislike->getDislikeSentence($this->id,3);
    }

    public function getML(){
        return $this->like->isMentionnedLike($this->id,3);
    }

    public function getMD(){
        return $this->dislike->isMentionnedDislike($this->id,3);
    }


    public function getText()
    {
        return $this->text = Str::getSnipet(Str::truncateText($this->content,300));
    }

}