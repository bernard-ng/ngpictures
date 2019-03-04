<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Entities\UsersEntity;
use Application\Managers\PageManager;
use Application\Repositories\UsersRepository;
use Application\Repositories\Validators\UsersValidator;
use Awurth\SlimValidation\Validator;
use Framework\Interfaces\CookieInterface;
use Framework\Managers\Collection;
use Framework\Managers\ImageManager;
use Framework\Managers\Mailer\Mailer;
use Framework\Managers\StringManager;
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
     * @param int $id
     * @param string $token
     */
    public function confirm($id, $token): void
    {
        $user = $this->users->findNotConfirmed(intval($id));
        if ($user && $user->confirmationToken == $token) {
            $this->users->update($user->id, ['confirmation_token' => null]);
            $this->flash->set('success', 'users_confirmation_success');
            $this->authService->connect($user);
        } else {
            $this->flash->set('danger', 'users_confirmation_failed');
            $this->redirect($this->url('auth.login'));
        }
    }


    /**
     * @param int $id
     * @param string $token
     */
    public function reset($id, $token)
    {
        $user = $this->users->find(intval($id));
        if ($user && $user->resetToken == $token) {
            if ($this->request->is('post')) {
                $input = new Collection($_POST);
                $validator = $this->container->get(Validator::class);
                $validator->validate($_POST, UsersValidator::getResetValidationRules());

                if ($validator->isValid()) {
                    $password = StringManager::hashPassword($input->get('password'));
                    $this->users->update($user->id, compact('password'));

                    $this->flash->set('success', 'users_reset_success');
                    $this->authService->reConnect($user);
                    $this->redirect($this->url('users.profile', ['id' => $user->id, 'name' => $user->slug]));
                } else {
                    $errors = $validator->getErrors();
                    $this->flash->set('danger', 'form_multi_errors');
                }
            }

            PageManager::setTitle("Rénitialisation du mot de passe");
            $this->view('frontend/users/account/reset', compact('input', 'errors'));
        } else {
            $this->flash->set('danger', 'undefined_error');
            $this->redirect();
        }
    }


    /**
     * mot de pass oubliee
     */
    public function forgot()
    {
        if ($this->request->is('post')) {
            $input = new Collection($_POST);
            $validator = $this->container->get(Validator::class);
            $validator->validate($_POST, UsersValidator::getForgotValidationRules());

            if ($validator->isValid()) {
                $email = $input->get('email');
                $user = $this->users->findWithEmail($email);

                if ($user && $user->confirmedAt != null) {
                        $this->users->update($user->id, ['reset_token' => StringManager::setToken(60)]);
                        $user = $this->users->find($user->id);
                        $link = $this->url('auth.reset', ['id' => $user->id, 'token' => $user->resetToken]);

                        $this->container->get(Mailer::class)->resetPassword($link, $email);
                        $this->flash->set('success', 'form_reset_submitted');
                        $this->redirect($this->url('auth.login'));
                } else {
                    $this->flash->set('danger', 'users_email_notFound');
                }
            } else {
                $errors = $validator->getErrors();
                $this->flash->set('danger', 'form_multi_errors');
            }
        }

        $this->turbolinksLocation($this->url('auth.forgot'));
        PageManager::setTitle('Mot de passe oublié');
        $this->view('frontend/users/account/forgot', compact('input', 'errors'));
    }


    /**
     * creation d'un compte
     * page de vue
     */
    public function sign()
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if ($this->authService->isLogged()) {
            $this->flash->set('warning', $this->flash->msg['users_already_connected'], false);
            $this->redirect($this->authService->isLogged()->accountUrl, false);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule("email", 'valid_email', 'required');
                $this->validator->setRule("name", ['required', "alpha_dash", "min_length[3]"]);
                $this->validator->setRule("password", ["matches[password_confirm]", 'required', "min_length[6]"]);
                $this->validator->setRule('password_confirm', ["matches[password]", 'required', "min_length[6]"]);

                if ($this->validator->isValid()) {
                    $this->validator->unique("name", $this->users, $this->flash->msg['users_username_token']);
                    $this->validator->unique("email", $this->users, $this->flash->msg['users_mail_token']);

                    if ($this->validator->isValid()) {
                        $this->authService->register($post->get('name'), $post->get('email'), $post->get('password'));
                        $this->flash->set('success', $this->flash->msg['form_registration_submitted'], false);
                        $this->redirect("/login", true);
                    } else {
                        $this->sendFormError();
                    }
                } else {
                    $this->sendFormError();
                }
            }

            $this->turbolinksLocation("/sign");
            PageManager::setTitle("Inscription");
            $this->view('frontend/users/sign', compact('post', 'errors'));
        }
    }


    /**
     * permet de connecter un utilisateur
     * page de vue
     */
    public function login()
    {
        $this->authService->cookieConnect();
        $user = $this->authService->isLogged();
        $idErros = [
            'name' => [$this->flash->msg['users_bad_identifier']],
            'password' =>  [$this->flash->msg['users_bad_identifier']]
        ];

        if ($user) {
            $this->flash->set('warning', 'users_already_connected');
            $this->redirect($this->url('users.profile', ['id' => $user->id, 'name' => $user->slug]));
        } else {
            if ($this->request->is('post')) {
                $input = new Collection($_POST);
                $validator = $this->container->get(Validator::class);
                $validator->validate($_POST, UsersValidator::getLoginValidationRules());

                if ($validator->isValid()) {
                    $name = $input->get('name');
                    $password = $input->get('password');

                    /** @var UsersEntity */
                    $user = $this->users->findWithEmailOrName($name);
                    if ($user) {
                        if (password_verify($password, $user->password)) {
                            if ($user->confirmedAt !== null) {
                                $this->authService->connect($user);
                                $this->authService->remember($user->id);
                                $this->redirect($this->url('users.profile', ['id' => $user->id, 'name' => $user->slug]));
                            } else {
                                $this->flash->set('danger', 'users_not_confirmed');
                            }
                        } else {
                            $errors = $idErros;
                            $this->flash->set('danger', 'users_bad_identifier');
                        }
                    } else {
                        $errors = $idErros;
                        $this->flash->set('danger', 'users_bad_identifier');
                    }
                } else {
                    $errors = $validator->getErrors();
                    $this->flash->set('danger', 'form_multi_errors');
                }
            }

            $this->turbolinksLocation($this->url('auth.login'));
            PageManager::setTitle('Connexion');
            $this->view('frontend/users/login', compact('input', 'errors'));
        }
    }

    /**
     * logout a user
     */
    public function logout()
    {
        if ($this->request->is('post')) {
            $this->cookie->delete(COOKIE_REMEMBER_KEY);
            $this->session->delete(AUTH_KEY);
            $this->session->delete(TOKEN_KEY);
            $this->flash->set('success', 'users_logout_success');
            $this->redirect($this->url('auth.login'));
        }
    }



    // Account management
    //--------------------------------------------------------------------------


    /**
     *  permet de generer le profile d'un utilisateur
     *  page de vue
     * @param string $username
     * @param int $id
     */
    public function account($username, $id)
    {
        if (!empty($username)) {
            $user = $this->users->find(intval($id));
            if ($user) {
                $photographer = $this->loadRepository('photographers')->findWith('users_id', $user->id);
                $posts = $this->loadRepository('posts')->findWithUser($user->id);
                $recent = null;

                if (count($posts) > 6) {
                    $recent = $this->loadRepository('posts')->get($user->id, 6);
                }

                $this->turbolinksLocation($user->accountUrl);
                PageManager::setDescription($user->bio);
                PageManager::setImage($user->avatarUrl);
                PageManager::setTitle("Profile de " . $user->name);
                $this->view('frontend/users/account/account', compact("user", "posts", "collection", "photographer"));
            } else {
                $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
                $this->redirect(true, false);
            }
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error'], false);
            $this->redirect(true, false);
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
            $post = new Collection($_POST);
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
                        $this->authService->reConnect($user, $this->flash->msg['users_edit_success']);
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
                    $this->authService->reConnect($user, $this->flash->msg['users_edit_success']);
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
