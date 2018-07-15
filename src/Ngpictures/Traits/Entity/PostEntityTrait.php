<?php
namespace Ngpictures\Traits\Entity;

use Ng\Core\Managers\CacheBustingManager;
use Ng\Core\Managers\StringManager;
use Ngpictures\Ngpictures;
use Ngpictures\Traits\Util\ResolverTrait;

trait PostEntityTrait
{

    use ResolverTrait;

    /**
     * lien vers la publication
     * @return string
     */
    public function getUrl(): string
    {
        $this->url = "/{$this->action_url}";
        $this->url .= "/{$this->SI}";
        return $this->url;
    }


    /**
     * url d'enregistrement
     *
     * @return string
     */
    public function getSaveUrl(): string
    {
        $this->saveUrl = "saves/{$this->action_type}";
        $this->saveUrl .= "/{$this->SI}";
        return $this->saveUrl;
    }


    /**
     * url de signalement
     * @return string
     */
    public function getReportUrl(): string
    {
        $this->reportUrl = "report/{$this->action_type}";
        $this->reportUrl .= "/{$this->SI}";
        return $this->reportUrl;
    }


    /**
     * lien vers la categorie de la publication
     * @return string
     */
    public function getCategoryUrl(): string
    {
        $category = Ngpictures::getDic()->get(StringManager::class)->slugify($this->category);
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


    public function getDownloads(): string
    {
        return (string) $this->downloads;
    }


    /**
     * lien pour aimer une publication
     * @return string
     */
    public function getLikeUrl(): string
    {
        $this->likeUrl = "/likes";
        $this->likeUrl .= "/{$this->action_type}";
        $this->likeUrl .= "/{$this->SI}";
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
        $this->likersUrl .= "/{$this->SI}";
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
        $this->commentUrl .= "/{$this->SI}";
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
        $likes = Ngpictures::getDic()->get($this->model('likes'));
        return $likes->getLikeSentence($this->id, $this->action_type);
    }


    public function getNbLikes(): string
    {
        $likes = Ngpictures::getDic()->get($this->model('likes'));
        return $likes->getLikes($this->id, $this->action_type);
    }


    public function getSaves(): string
    {
        $saves = Ngpictures::getDic()->get($this->model('saves'));
        return $saves->getSaves($this->id, $this->action_type);
    }


    /**
     * renvoi le woridins de commentaire
     *
     * @return string
     */
    public function getCommentsNumber(): string
    {
        $comments = Ngpictures::getDic()->get($this->model('comments'));
        $comments = $comments->count($this->id, $this->action_url . "_id")->num;
        return $comments;
    }


    /**
     * renvoi "active" si on aime la publication
     * @return string
     */
    public function getIsLike(): string
    {
        $likes = Ngpictures::getDic()->get($this->model('likes'));
        return $likes->isMentionnedLike($this->id, $this->action_type);
    }


    /**
     * renvoi vrai is on a dja saved la publication
     * @return string
     */
    public function getIsSaved(): string
    {
        $saves = Ngpictures::getDic()->get($this->model('saves'));
        return $saves->isSaved($this->id, $this->action_type);
    }


    /**
     * renvoi une partie de la publication, on truncate le text
     * et verifie les mentions des users
     * @return string
     */
    public function getSnipet()
    {
        $str = Ngpictures::getDic()->get(StringManager::class);
        $users = Ngpictures::getDic()->get($this->model('users'));
        $content = $str->getSnipet($str->truncate($this->content, 150));
        $text = $str->userMention($users, strip_tags($content));
        return $str->htag($text);
    }


    /**
     * renvoi le text complet et verifie les mentions des users
     * @return string
     */
    public function getFullText()
    {
        $str = Ngpictures::getDic()->get(StringManager::class);
        $users = Ngpictures::getDic()->get($this->model('users'));
        $text = $str->userMention($users, strip_tags($this->content));
        return nl2br($str->htag($text));
    }

    /**
     * recupere les donnees exif d'une image
     *
     * @return string|null
     */
    public function getExifData()
    {
        return (is_null($this->exif)) ? null : json_decode($this->exif);
    }


    public function getLocationUrl()
    {
        $this->locationUrl = "/maps";
        $this->locationUrl .= "?location={$this->SI}";
        return $this->locationUrl;
    }
}
