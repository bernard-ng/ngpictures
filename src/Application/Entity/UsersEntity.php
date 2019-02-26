<?php
namespace Application\Entity;

use Framework\Entity\Entity;
use Application\Application;
use Framework\Managers\StringManager;
use Framework\Managers\SessionManager;
use Framework\Interfaces\SessionInterface;
use Framework\Managers\CacheBustingManager;
use Application\Traits\Util\ResolverTrait;
use Application\Traits\Util\AuthTrait;

class UsersEntity extends Entity
{

    use ResolverTrait;
    use AuthTrait;


    /**
     * compte les publication d'un user
     *
     * @return int
     */
    public function getPostsNumber()
    {
        $posts = Application::getDic()->get($this->model('posts'));
        $this->postsNumber = $posts->count($this->id)->num;
        return $this->postsNumber;
    }


    /**
     * compte les followers d'un user
     *
     * @return int
     */
    public function getFollowersNumber()
    {
        $following = Application::getDic()->get($this->model('following'));
        $this->followersNumber = $following->countFollowers($this->id)['num'];
        return $this->followersNumber;
    }

    /**
     * compte les followings d'un user
     *
     * @return int
     */
    public function getFollowingsNumber()
    {
        $following = Application::getDic()->get($this->model('following'));
        $this->followingsNumber = $following->countFollowings($this->id)['num'];
        return $this->followingsNumber;
    }


    /**
     * compte les likes
     *
     * @return int
     */
    public function getLikesNumber()
    {
        $likes = Application::getDic()->get($this->model('likes'));
        $this->likesNumber = $likes->count($this->id)->num;
        return $this->likesNumber;
    }


    /**
     * compte les commentaires
     *
     * @return int
     */
    public function getCommentsNumber()
    {
        $comments = Application::getDic()->get($this->model('comments'));
        $this->commentsNumber = $comments->countComments($this->id)->num;
        return $this->commentsNumber;
    }

    /**
     * le lien vers le compte d'un user
     * @return mixed|string
     */
    public function getAccountUrl() : string
    {
        $this->accountUrl = "/";
        $this->accountUrl .= Application::getDic()->get(StringManager::class)->slugify($this->name) . "-{$this->id}";
        return $this->accountUrl;
    }


    /**
     * lien pour s'abonner au current user
     * @return string
     */
    public function getFollowingUrl() : string
    {
        $this->followingUrl = "/following/";
        $this->followingUrl .= Application::getDic()->get(StringManager::class)->slugify($this->name) . "-{$this->id}";
        return $this->followingUrl;
    }


    /**
     * le current user est il follow ?
     *
     * @return string
     */
    public function getIsFollowed() : string
    {
        $following = Application::getDic()->get($this->model('following'));
        return $following->isMentionnedFollow($this->id);
    }


    /**
     * le lien vers l'edition du profile
     * @return mixed|string
     */
    public function getEditUrl() : string
    {
        $this->editUrl = "/settings/";
        $this->editUrl .= self::$token;
        return $this->editUrl;
    }


    /**
     * la lien vers la collection de photos
     * @return string
     */
    public function getCollectionUrl() : string
    {
        $this->collectionUrl = "/my-collection/";
        $this->collectionUrl .= self::$token;
        return $this->collectionUrl;
    }


    /**
     * le lien vers les notification du user
     * @return string
     */
    public function getNotificationsUrl() : string
    {
        $this->notificationsUrl = "/my-notifications/";
        $this->notificationsUrl .= self::$token;
        return $this->notificationsUrl;
    }


    /**
     * le lien vers la liste des ses amies(followers)
     * @return mixed|string
     */
    public function getFollowersUrl() : string
    {
        $this->followersUrl = "/my-followers/";
        $this->followersUrl .= self::$token;
        return $this->followersUrl;
    }


    /**
     * lien vers les abonnements du current user
     *
     * @return string
     */
    public function getFollowingsUrl() : string
    {
        $this->followingsUrl = str_replace("followers", "following", $this->followersUrl);
        return $this->followingsUrl;
    }


    /**
     * lien vers le publication du current user
     *
     * @return string
     */
    public function getPostsUrl() : string
    {
        $this->postsUrl = "/my-posts/";
        $this->postsUrl .= self::$token;
        return $this->postsUrl;
    }


    /**
     * lien pour ajouter une publication
     *
     * @return string
     */
    public function getAddPostUrl() : string
    {
        $this->addPostsUrl = "/submit-photo/";
        return $this->addPostsUrl;
    }


    /**
     * le lien vers son avatar
     * @return mixed|string
     */
    public function getAvatarUrl() : string
    {
        $this->avatarUrl = "/uploads/avatars/{$this->avatar}";
        $this->avatarUrl = CacheBustingManager::get($this->avatarUrl);
        return $this->avatarUrl;
    }
}