<?php
namespace Ngpictures\Traits\Entity;

use Ng\Core\Managers\CacheBustingManager;
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
        $this->url = "/{$this->action_url}";
        $this->url .= "/{$this->slug}-{$this->id}";
        return $this->url;
    }


    /**
     * lien vers la categorie de la publication
     * @return string
     */
    public function getCategoryUrl(): string
    {
        $category = StringManager::Slugify($this->category);
        $this->categoryUrl = "/categories";
        $this->categoryUrl .= "/{$category}-{$this->categories_id}";
        return $this->categoryUrl;
    }


    /**
     * lien vers la miniature de la publication
     * @return string
     */
    public function getThumbUrl(): string
    {
        $this->thumbUrl = "/uploads";
        $this->thumbUrl .= "/{$this->file_path}/{$this->thumb}";
        $this->thumbUrl = CacheBustingManager::get($this->thumbUrl);
        return $this->thumbUrl;
    }

    public function getSmallThumbUrl(): string
    {
        $this->smallThumbUrl = "/uploads";
        $this->smallThumbUrl .= "/{$this->file_path}/thumbs/{$this->thumb}";
        $this->smallThumbUrl = CacheBustingManager::get($this->smallThumbUrl);
        return $this->smallThumbUrl;
    }


    public function getWatermarkUrl(): string
    {
        $this->watermarkUrl = "/gallery/watermark";
        $this->watermarkUrl .= "/{$this->action_type}/{$this->thumb}";
        return $this->watermarkUrl;
    }


    /**
     * lien de telechargement de la miniature de la publication
     * @return string
     */
    public function getDownloadUrl(): string
    {
        $this->downloadUrl = "/download";
        $this->downloadUrl .= "/{$this->action_type}/{$this->thumb}";
        return $this->downloadUrl;
    }


    /**
     * lien pour aimer une publication
     * @return string
     */
    public function getLikeUrl(): string
    {
        $this->likeUrl = "/likes";
        $this->likeUrl .= "/{$this->action_type}";
        $this->likeUrl .= "/{$this->slug}-{$this->id}";
        return $this->likeUrl;
    }


    /**
     * lien pour voir ceux qui aime la publication
     *
     * @return string
     */
    public function getLikersUrl(): string
    {
        $this->likersUrl = "/likes/show";
        $this->likersUrl .= "/{$this->action_type}";
        $this->likersUrl .= "/{$this->slug}-{$this->id}";
        return $this->likersUrl;
    }


    /**
     * lien pour commenter un publication
     * @return string
     */
    public function getCommentUrl(): string
    {
        $this->commentUrl = "/comments";
        $this->commentUrl .= "/{$this->action_type}";
        $this->commentUrl .= "/{$this->slug}-{$this->id}";
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


    /**
     * renvoi le woridins de commentaire
     *
     * @return string
     */
    public function getCommentsNumber(): string
    {
        $comments = Ngpictures::getInstance()->getModel('comments');
        $comments = $comments->getNumber($this->id, $this->action_type);
        return $comments;
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
        $content = StringManager::getSnipet(StringManager::truncateText($this->content, 150));
        return (StringManager::userMention($users, $content));
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
