<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Entities\UsersEntity;
use Application\Managers\PageManager;
use Application\Repositories\PostsRepository;
use Application\Repositories\UsersRepository;
use Application\Repositories\Validators\UsersValidator;
use Awurth\SlimValidation\Validator;
use Framework\Interfaces\CookieInterface;
use Framework\Managers\Collection;
use Framework\Managers\ImageManager;
use Framework\Managers\Mailer\Mailer;
use Framework\Managers\StringHelper;
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
     * @var mixed|CookieInterface
     */
    private $cookie;

    /**
     * UsersController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->cookie = $this->container->get(CookieInterface::class);
        $this->users = $container->get(UsersRepository::class);
    }


    /**
     *  permet de generer le profile d'un utilisateur
     *  page de vue
     * @param $name
     */
    public function profile($name)
    {
        $user = $this->users->findWith('slug', $name);
        if ($user) {
            $posts = $this->container->get(PostsRepository::class)->findWith('users_id', $user->id);

            $this->turbolinksLocation($this->url('users.profile', ['slug' => $user->slug]));
            PageManager::setDescription($user->bio);
            PageManager::setImage($user->getAvatar());
            PageManager::setTitle("Profile de " . $user->name);
            $this->view('frontend/users/account/account', compact("user", "posts"));
        } else {
            $this->notFound();
        }
    }


    public function collection($token)
    {
        if ($this->authService->getToken() == $token) {
            $user = $this->authService->isLogged();
            $collection = $this->callController('saves')->show($user->id);

            $this->turbolinksLocation("/my-collection/{$token}");
            PageManager::setTitle("Collection de " . $user->name);
            $this->view('frontend/users/account/collection', compact("user", "collection"));
        } else {
            $this->flash->set('danger', $this->flash->msg['collection_not_allowed'], false);
            $this->redirect(true, false);
        }
    }


    /**
     * les notification d'un user
     *
     * @param string $token
     * @return void
     */
    public function notification($token)
    {
        if ($this->authService->getToken() == $token) {
            $user = $this->authService->isLogged();
            $notifications = $this->callController('notifications')->show($user->id, $token);

            $this->turbolinksLocation("/my-notifications/{$token}");
            PageManager::setTitle("Notifications");
            PageManager::setDescription("Voici les notifications de ngpictures pour : {$user->name}");
            $this->view('frontend/users/account/notifications', compact("user", "notifications"));
        } else {
            $this->flash('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
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
