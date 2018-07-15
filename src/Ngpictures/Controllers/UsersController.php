<?php
namespace Ngpictures\Controllers;

use ReCaptcha\ReCaptcha;
use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ng\Core\Managers\Mailer\Mailer;
use Psr\Container\ContainerInterface;
use Ng\Core\Interfaces\CookieInterface;

class UsersController extends Controller
{

    /**
     * charge le model d'utilisateur
     * UsersController constructor.
     * @param Ngpictures $app
     * @param PageManager $pageManager
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->cookie = $this->container->get(CookieInterface::class);
        $this->loadModel('users');
    }


    /**
     * confirmation d'un utilisateur
     * @param $users_id
     * @param string $token
     */
    public function confirm($users_id, $token)
    {
        $this->authService->confirm($users_id, $token);
    }


    /**
     * permet de reset un mot de pass pour un utilisateur
     * @param $users_id
     * @param string $token
     * @return void
     */
    public function reset($users_id, string $token)
    {
        $user   =   $this->users->find(intval($users_id));
        $token  =   $this->str->escape($token);
        $errors =   new Collection();

        if ($user && $user->reset_token == $token) {
            $post = new Collection($_POST);

            if (isset($_POST) and !empty($_POST)) {
                $this->validator->setRule('password', ["matches[password_confirm]", "min_length[6]"]);
                $this->validator->setRule('password_confirm', ["matches[password]", "min_length[6]"]);

                if ($this->validator->isValid()) {
                    $password = $this->str->hashPassword($post->get('password'));
                    $this->users->resetPassword($password, $user->id);

                    $this->flash->set('success', $this->flash->msg['users_reset_success'], false);
                    $this->authService->reConnect($user);
                    $this->redirect($user->accountUrl);
                } else {
                    $this->sendFormError();
                }
            }

            $this->pageManager::setTitle("Rénitialisation du mot de passe");
            $this->view('frontend/users/account/reset', compact('post', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }


    /**
     * mot de pass oubliee
     */
    public function forgot()
    {
        $post = new Collection($_POST);
        $errors = new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule('email', ['valid_email']);

            if ($this->validator->isValid()) {
                $email  =    $this->str->escape($post->get('email'));
                $user   =    $this->users->findWith('email', $email);

                if ($user && $user->confirmed_at != null) {
                    $this->users->setResetToken($this->str->setToken(60), $user->id);
                    $user   =   $this->users->find($user->id);
                    $link   =   SITE_NAME."/reset/{$user->id}/{$user->reset_token}";

                    $this->container->get(Mailer::class)->resetPassword($link, $email);
                    $this->flash->set('success', $this->flash->msg['form_reset_submitted'], false);
                    $this->redirect('/login');
                } else {
                    $this->flash->set('danger', $this->flash->msg['users_email_notFound']);
                }
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->isAjax() ?
                    $this->setFlash($errors->asJson(), 403) :
                    $this->flash->set('danger', $this->flash->msg['form_multi_errors']);
            }
        }

        $this->turbolinksLocation("/forgot");
        $this->pageManager::setTitle('Mot de passe oublié');
        $this->view('frontend/users/account/forgot', compact('post', 'errors'));
    }


    /**
     * creation d'un compte
     * page de vue
     */
    public function sign()
    {
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if (isset($_POST) && !empty($_POST)) {
            $this->validator->setRule("email", 'valid_email', 'required');
            $this->validator->setRule("name", ['required', "alpha_dash", "min_length[3]"]);
            $this->validator->setRule("password", ["matches[password_confirm]" ,'required', "min_length[6]"]);
            $this->validator->setRule('password_confirm', ["matches[password]" ,'required', "min_length[6]"]);

            if ($this->validator->isValid()) {
                $this->validator->unique("name", $this->users, $this->flash->msg['users_username_token']);
                $this->validator->unique("email", $this->users, $this->flash->msg['users_mail_token']);

                if ($this->validator->isValid()) {
                    $this->authService->register($post->get('name'), $post->get('email'), $post->get('password'));
                    $this->flash->set('success', $this->flash->msg['form_registration_submitted'], false);
                    $this->redirect("/login");
                } else {
                    $this->sendFormError();
                }
            } else {
                $this->sendFormError();
            }
        }

        $this->turbolinksLocation("/sign");
        $this->pageManager::setTitle("Inscription");
        $this->view('frontend/users/sign', compact('post', 'errors'));
    }


    /**
     * permet de connecter un utilisateur
     * page de vue
     */
    public function login()
    {
        $this->authService->cookieConnect();
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if ($this->authService->isLogged()) {
            $this->flash->set('warning', $this->flash->msg['users_already_connected'], false);
            $this->redirect($this->authService->isLogged()->accountUrl, false);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', 'required');
                $this->validator->setRule('password', 'required');

                if ($this->validator->isValid()) {
                    $name       =   $this->str->escape($post->get('name'));
                    $remember   =   intval($post->get('remember'));
                    $password   =   $post->get('password');

                    $user  = $this->users->findAlternative(['name','email'], $name);
                    if ($user) {
                        if (password_verify($password, $user->password)) {
                            if ($user->confirmed_at !== null) {
                                $this->authService->connect($user);
                                $remember ? $this->authService->remember($user->id) : '';
                                $this->redirect($user->accountUrl, true);
                            } else {
                                $this->flash->set('danger', $this->flash->msg['users_not_confirmed']);
                            }
                        } else {
                            $this->flash->set('danger', $this->flash->msg['users_bad_identifier']);
                        }
                    } else {
                        $this->flash->set('danger', $this->flash->msg['users_bad_identifier']);
                    }
                } else {
                    $this->sendFormError();
                }
            }

            $this->turbolinksLocation("/login");
            $this->pageManager::setTitle('Connexion');
            $this->view('frontend/users/login', compact('post', 'errors'));
        }
    }


    /**
     * permet de deconnecter un utilisateur
     */
    public function logout()
    {
        $this->cookie->delete(COOKIE_REMEMBER_KEY);
        $this->session->delete(AUTH_KEY);
        $this->session->delete(TOKEN_KEY);
        $this->flash->set('success', $this->flash->msg['users_logout_success'], false);
        $this->redirect("/login", false);
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
                $posts = $this->loadModel('posts')->findWithUser($user->id);
                $recent = null;

                if (count($posts) > 6) {
                    $recent = $this->loadModel('posts')->get($user->id, 6);
                }

                $this->turbolinksLocation($user->accountUrl);
                $this->pageManager::setTitle("Profile de " . $user->name);
                $this->view('frontend/users/account/account', compact("user", "posts", "collection"));
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
            $this->pageManager::setTitle("Collection de " . $user->name);
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
            $this->pageManager::setTitle("Notifications");
            $this->pageManager::setDescription("Voici les notifications de ngpictures pour : {$user->name}");
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
            $user       =   $this->authService->isLogged();
            $post       =   new Collection($_POST);
            $file       =   new Collection($_FILES);
            $errors     =   new Collection();

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
                        $name       =    $this->str->escape($post->get('name'));
                        $email      =    $this->str->escape($post->get('email'));
                        $bio        =    $this->str->escape($post->get('bio'))      ??  "Hey suis sur Ngpictures 2.0";
                        $phone      =    $this->str->escape($post->get('phone'))    ??  null;

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
            $this->pageManager::setTitle('Paramètres');
            $this->view('frontend/users/account/edit', compact('user', 'errors'));
        } else {
            $this->flash->set('danger', $this->flash->msg['undefined_error']);
            $this->redirect(true);
        }
    }
}
