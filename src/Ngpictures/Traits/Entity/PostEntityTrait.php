<?php
namespace Ngpictures\Traits\Entity;

use Ng\Core\Managers\StringManager;
use Ngpictures\Ngpictures;

trait PostEntityTrait
{
    /**
     * lien vers la publication
     * @return string
     */
    public function getUrl(): string
    {
        $this->url = "/{$this->action_url}/{$this->slug}-{$this->id}";
        return $this->url;
    }


    /**
     * lien vers la categorie de la publication
     * @return string
     */
    public function getCategoryUrl(): string
    {
        $category= StringManager::Slugify($this->category);
        $this->categoryUrl = "/categories/{$category}-{$this->category_id}";
        return $this->categoryUrl;
    }


    /**
     * lien vers la miniature de la publication
     * @return string
     */
    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads/{$this->file_path}/{$this->thumb}";
        return $this->thumbUrl;
    }


    /**
     * lien de telechargement de la miniature de la publication
     * @return string
     */
    public function getDownloadUrl(): string
    {
        $this->downloadUrl = "/download/{$this->action_type}/{$this->thumb}";
        return $this->downloadUrl;
    }


    /**
     * lien pour aimer une publication
     * @return string
     */
    public function getLikeUrl(): string
    {
        $this->likeurl = "/likes/{$this->action_type}/{$this->slug}-{$this->id}";
        return $this->likeurl;
    }


    /**
     * lien pour commenter un publication
     * @return string
     */
    public function getCommentUrl(): string
    {
        $this->commentUrl = "/comments/{$this->action_type}/{$this->slug}-{$this->id}";
        return $this->commentUrl;
    }


    /**
     * renvoi le slug + id de la publication
     * @return string
     */
    public function getSI(): string
    {
        return "{$this->slug}-{$this->id}";
    }


    /**
     * renvoi le nombre de like d'un publication
     * @return string
     */
    public function getLikes(): string
    {
        $likes = Ngpictures::getInstance()->getModel('likes');
        return $likes->getLikeSentence($this->id, $this->action_type);
    }


    public function getCommentsNumber(): string
    {
        $comments = Ngpictures::getInstance()->getModel('comments');
        $comments = $comments->getNumber($this->id, $this->action_type);
        $words = ($comments > 1)? " commentaires" : " commentaire";
        return $comments." {$words}";
    }


    /**
     * renvoi "active" si on aime la publication
     * @return string
     */
    public function getIsLike(): string
    {
        $likes = Ngpictures::getInstance()->getModel('likes');
        return $likes->isMentionnedLike($this->id, $this->action_type);
    }


    /**
     * renvoi une partie de la publication, on truncate le text
     * et verifie les mentions des users
     * @return string
     */
    public function getSnipet(): string
    {
        $users = Ngpictures::getInstance()->getModel('users');
        $content = StringManager::getSnipet(StringManager::truncateText($this->content, 300));
        return StringManager::userMention($users, $content);
    }


    /**
     * renvoi le text complet et verifie les mentions des users
     * @return string
     */
    public function getFullText(): string
    {
        $users = Ngpictures::getInstance()->getModel('users');
        return StringManager::userMention($users, $this->content);
    }
}
