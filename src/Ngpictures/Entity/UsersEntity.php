<?php
namespace Ngpictures\Entity;

use Ng\Core\Entity\Entity;
use Ngpictures\Ngpictures;
use Ng\Core\Managers\StringManager;
use Ng\Core\Managers\SessionManager;
use Ng\Core\Interfaces\SessionInterface;
use Ng\Core\Managers\CacheBustingManager;
use Ngpictures\Traits\Util\ResolverTrait;

class UsersEntity extends Entity
{

    use ResolverTrait;

    /**
     * le lien vers le compte d'un user
     * @return mixed|string
     */
    public function getAccountUrl(): string
    {
        $this->accountUrl = "/";
        $this->accountUrl .= StringManager::slugify($this->name)."-{$this->id}";
        return $this->accountUrl;
    }


    /**
     * lien pour s'abonner au current user
     * @return string
     */
    public function getFollowingUrl(): string
    {
        $this->followingUrl = "/following/";
        $this->followingUrl .= StringManager::slugify($this->name)."-{$this->id}";
        return $this->followingUrl;
    }


    /**
     * le current user est il follow ?
     *
     * @return string
     */
    public function getIsFollowed(): string
    {
        $following = Ngpictures::getDic()->get($this->model('following'));
        return $following->isMentionnedFollow($this->id);
    }


    /**
     * le lien vers l'edition du profile
     * @return mixed|string
     */
    public function getEditUrl(): string
    {
        $this->editUrl = "/settings/";
        $this->editUrl .= Ngpictures::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        return $this->editUrl;
    }


    /**
     * le lien vers la liste des ses amies(followers)
     * @return mixed|string
     */
    public function getFollowersUrl(): string
    {
        $this->followersUrl = "/my-followers/";
        $this->followersUrl .= Ngpictures::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        return $this->followersUrl;
    }


    /**
     * lien vers les abonnements du current user
     *
     * @return string
     */
    public function getFollowingsUrl(): string
    {
        $this->followingsUrl = "/my-following/";
        $this->followingsUrl .= Ngpictures::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        return $this->followingsUrl;
    }


    /**
     * lien vers le publication du current user
     *
     * @return string
     */
    public function getPostsUrl(): string
    {
        $this->postsUrl = "/my-posts/";
        $this->postsUrl .= Ngpictures::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        return $this->postsUrl;
    }


    /**
     * lien pour ajouter une publication
     *
     * @return string
     */
    public function getAddPostUrl(): string
    {
        $this->addPostsUrl = "/submit-photo/";
        return $this->addPostsUrl;
    }


    /**
     * lien pour supprimer une publication
     *
     * @return string
     */
    public function getDeletePostsUrl(): string
    {
        $this->deletePostsUrl = "/delete-post/";
        $this->deletePostsUrl .= Ngpictures::getDic()->get(SessionInterface::class)->read(TOKEN_KEY);
        return $this->deletePostUrl;
    }


    /**
     * le lien vers son avatar
     * @return mixed|string
     */
    public function getAvatarUrl(): string
    {
        $this->avatarUrl = "/uploads/avatars/{$this->avatar}";
        $this->avatarUrl = CacheBustingManager::get($this->avatarUrl);
        return $this->avatarUrl;
    }
}
