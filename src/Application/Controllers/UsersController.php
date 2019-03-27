<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Entities\PostsEntity;
use Application\Entities\UsersEntity;
use Application\Managers\PageManager;
use Application\Repositories\CollectionsRepository;
use Application\Repositories\NotificationsRepository;
use Application\Repositories\PostsRepository;
use Application\Repositories\UsersRepository;
use Framework\Interfaces\CookieInterface;
use Framework\Managers\Collection;
use Framework\Managers\ImageManager;
use Psr\Container\ContainerInterface;

/**
 * Class UsersController
 * @package Application\Controllers
 */
class UsersController extends Controller
{

    /**
     * @var UsersRepository
     */
    private $users;

    /**
     * @var \Framework\Auth\User|UsersEntity|null
     */
    private $currentUser;

    /**
     * UsersController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->users = $container->get(UsersRepository::class);
        $this->currentUser = $this->auth->getUser();
    }


    /**
     *  permet de generer le profile d'un utilisateur
     *  page de vue
     * @param $username
     */
    public function profile($username)
    {
        $user = $this->users->findWith('slug', $username);
        if ($user) {
            $postsRepository = $this->container->get(PostsRepository::class);
            $posts = $postsRepository->findWithUser($user->id);
            $postsCount = count($posts);

            if ($postsCount > 8) {
                $randomPosts = $postsRepository->getRandomWithUser($user->id);
            }

            $this->turbolinksLocation($this->url('users.profile', ['slug' => $user->slug]));
            PageManager::setTitle("Profile de " . ucwords($user->name));
            PageManager::setDescription($user->bio);
            PageManager::setImage($user->getAvatar());
            $this->view('frontend/users/account/account', compact("user", "posts", "postsCount", "randomPosts"));
        } else {
            $this->notFound();
        }
    }

    /**
     * @param string $username
     */
    public function collections(string $username)
    {
        $user = $this->users->findWith('slug', $username);
        if ($user) {
            $postsRepository = $this->container->get(PostsRepository::class);
            $collections = $this->container->get(CollectionsRepository::class)->findWith('users_id', $user->id);
            $collectionsTotalCount = count($collections);

            if ($collections) {
                foreach ($collections as $collection) {
                    /** @var PostsEntity $thumb */
                    $thumb = $postsRepository->findWith('collections_id', $collection->id)[0];
                    $collectionsThumbs[$collection->id] =
                        (is_null($thumb)) ? "/imgs/default.jpeg" : $thumb->getSmallThumb();
                }

                foreach ($collections as $collection) {
                    $collectionsCount[$collection->id] = $postsRepository->countWith('collections_id', $collection->id);
                }
            }

            $this->turbolinksLocation($this->url('users.posts.collections', ['slug' => $user->slug]));
            PageManager::setTitle("Les Collections de " . $user->name);
            PageManager::setDescription($user->bio);
            PageManager::setImage($user->getAvatar());
            $this->view(
                'frontend/users/account/collection',
                compact("user", "collections", "collectionsCount", "collectionsThumbs", "collectionsTotalCount")
            );
        } else {
            $this->notFound();
        }
    }


    /**
     * les notification d'un user
     *
     * @param string $name
     * @return void
     */
    public function notifications(string $name)
    {
        $this->loggedOnly();
        $user = $this->users->findWith('slug', $name);
        if ($this->currentUser->id == $user->id) {
            $notifications = $this->container->get(NotificationsRepository::class)->findWith('users_id', $user->id);
            $this->turbolinksLocation($this->url('users.notifications', ['slug' => $user->slug]));

            PageManager::setTitle("Mes Notifications");
            PageManager::setDescription("Voici les notifications de ngpictures pour : {$user->name}");
            PageManager::setImage($user->getAvatar());
            $this->view('frontend/users/account/notifications', compact("user", "notifications"));
        } else {
            $this->flash->error("users_forbidden");
            $this->redirect();
        }
    }


    /**
     * permet de generer la page d'edition d'un utilisateur
     * @param string $token
     */
    public function edit($token)
    {
        $this->authService->restrict();
        if ($token === $this->authService->getToken()) {
            $user = $this->authService->isLogged();
            $post = $this->request->input();
            $file = new Collection($_FILES);
            $errors = new Collection();

            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', ['required', 'min_length[3]']);
                $this->validator->setRule('email', ['required', 'valid_email']);

                if ($this->validator->isValid()) {
                    if ($post->get('name') !== $user->name) {
                        $this->validator->unique('name', $this->users, $this->flash->msg['users_username_token']);
                    } elseif ($post->get('email') !== $user->email) {
                        $this->validator->unique('email', $this->users, $this->flash->msg['users_email_token']);
                    } elseif ($post->get('phone') !== $user->phone) {
                        $this->validator->unique('phone', $this->users, $this->flash->msg['users_phone_token']);
                    }

                    if ($this->validator->isValid()) {
                        $name = $this->str->escape($post->get('name'));
                        $email = $this->str->escape($post->get('email'));
                        $bio = $this->str->escape($post->get('bio'))      ??  "Hey suis sur Ngpictures 2.0";
                        $phone = $this->str->escape($post->get('phone'))    ??  null;

                        $this->users->update($user->id, compact('name', 'email', 'phone', 'bio'));
                        $user = $this->users->find($user->id);
                        $this->authService->updateConnexion($user, $this->flash->msg['users_edit_success']);
                        $this->redirect($user->accountUrl);
                    } else {
                        $this->sendFormError();
                    }
                } else {
                    $this->sendFormError();
                }
            } elseif (!empty($file->get('thumb'))) {
                $isUploaded = $this->container->get(ImageManager::class)->upload($file, 'avatars', "ngpictures-avatar-{$user->id}", 'medium');

                if ($isUploaded) {
                    $this->users->update($user->id, ['avatar' => "ngpictures-avatar-{$user->id}.jpg"]);
                    $user = $this->users->find($user->id);
                    $this->authService->updateConnexion($user, $this->flash->msg['users_edit_success']);
                    $this->redirect($user->accountUrl);
                } else {
                    $this->flash->set('danger', $this->flash->msg['files_not_uploaded']);
                }
            }

            $this->turbolinksLocation("/settings/{$token}");
            PageManager::setTitle('Paramètres');
            $this->view('frontend/users/account/edit', compact('user', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }
}
