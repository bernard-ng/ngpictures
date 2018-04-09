<?php
namespace Ngpictures\Controllers;

use Ng\Core\Managers\Collection;
use Ng\Core\Managers\ImageManager;
use Ngpictures\Managers\PageManager;
use Ng\Core\Managers\Mailer\Mailer;
use Ngpictures\Entity\UsersEntity;
use Ngpictures\Ngpictures;

class UsersController extends Controller
{

    /**
     * charge le model d'utilisateur
     * UsersController constructor.
     */
    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
        $this->loadModel('users');
    }


    /***************************************************************************
    *                    ACCOUNT CREATION && SETTINGS
    ****************************************************************************/
    /**
     * confirmation d'un utilisateur
     * @param $users_id
     * @param string $token
     */
    public function confirm(int $users_id, string $token)
    {
        $token  =   $this->str::escape($token);
        $user   =   $this->users->isNotConfirmed(intval($users_id));

        if ($user && $user->confirmation_token === $token) {
            $this->users->unsetConfirmationToken($user->id);
            $this->connect($user);
            $this->login();
        } else {
            $this->flash->set('danger', $this->msg['users_confirmation_failed']);
            $this->login();
        }
    }


    /**
     * permet de reset un mot de pass pour un utilisateur
     * @param $id
     * @param string $token
     */
    public function reset($id, string $token)
    {
        $user   =   $this->users->find(intval($id));
        $token  =   $this->str::escape($token);

        if ($user && $user->reset_token == $token) {
            $post = new Collection($_POST);

            if (isset($_POST) and !empty($_POST)) {
                if (!empty($post->get('password')) && !empty($post->get('password_confirm'))) {
                    $this->validator = $this->validator;
                    $this->validator->isMatch('password', 'password_confirm', $this->msg['users_bad_password']);
                    if ($this->validator->isValid()) {
                        $password = $this->str::hashPassword($post->get('password'));
                        $this->users->resetPassword($password, $user->id);

                        $this->flash->set('success', $this->msg['users_reset_success']);
                        $this->connect($user);
                        $this->app::redirect($user->accountUrl);
                    }
                } else {
                    $this->flash->set('danger', $this->msg['form_all_required']);
                }
            }

            $this->pageManager::setName("Rénitialisation du mot de passe");
            $this->setLayout('users/default');
            $this->viewRender('front_end/users/account/reset', compact('post'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * mot de pass oubliee
     */
    public function forgot()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            if (!empty($post->get('email'))) {
                $email  =    $this->str::escape($post->get('email'));
                $user   =    $this->users->findWith('email', $email);

                if ($user && $user->confirmed_at != null) {
                    $this->users->setResetToken($this->str::setToken(60), $user->id);
                    $user   =   $this->users->find($user->id);
                    $link   =   SITE_NAME."/reset/{$user->id}/{$user->reset_token}";

                    (new Mailer())->resetPassword($link, $email);
                    $this->flash->set('success', $this->msg['users_reset_success']);
                    $this->app::redirect('/login');
                } else {
                    $this->flash->set('danger', $this->msg['users_email_notFound']);
                }
            } else {
                $this->flash->set('danger', $this->msg['form_all_required']);
            }
        }

        $this->pageManager::setName('Mot de passe oublié');
        $this->setLayout('users/default');
        $this->viewRender('front_end/users/account/forgot', compact('post'));
    }


    /**
     * cree un nouvel utilisateur
     * @param string $name
     * @param string $email
     * @param string $password
     */
    private function register(string $name, string $email, string $password)
    {
        $name       =   $this->str::escape($name);
        $email      =   $this->str::escape($email);
        $token      =   $this->str::setToken(60);
        $password   =   $this->str::hashPassword($password);

        $this->users->add($name, $email, $password, $token);
        $users_id = $this->users->lastInsertId();
        $link = SITE_NAME."/confirm/{$users_id}/{$token}";

        (new Mailer())->accountConfirmation($link, $email);
        $this->flash->set('success', $this->msg['form_registration_submitted']);
        $this->app::redirect('/login');
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
            $this->validator->setRule("email", 'valid_email');
            $this->validator->setRule("name", ["alpha_dash", "min_length[5]"]);
            $this->validator->setRule("password", ["min_length[8]", "must_match[password_confirm]"]);

            if ($this->validator->isValid()) {
                $this->validator->unique("name", $this->users, $this->msg['users_username_token']);
                $this->validator->unique("email", $this->users, $this->msg['users_mail_token']);

                if ($this->validator->isValid()) {
                    $this->register($post->get('name'), $post->get('email'), $post->get('password'));
                    $this->flash->set('success', $this->msg['users_registration_success']);
                    $this->app::redirect("/login");
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->flash->set("danger", $this->msg['form_multi_errors']);
                }
            } else {
                $errors = new Collection($this->validator->getErrors());
                $this->flash->set("danger", $this->msg['form_multi_errors']);
            }
        }

        $this->pageManager::setName("Inscription");
        $this->setLayout('users/default');
        $this->viewRender('front_end/users/sign', compact('post'));
    }



    /***************************************************************************
    *                   LOGIN SYSTEM && RESTRICTIONS
    ****************************************************************************/
    /**
     * interdire l'access a certaines pages
     * @param string|null $msg
     */
    public function restrict(string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->flash->set("danger", $msg ?? $this->msg["users_not_logged"]);
            $this->app::redirect(true);
        }
    }


    /**
     * admettre une action seulement pour un admin
     */
    public function isAdmin()
    {
        $this->restrict();
        if ($this->session->getValue(AUTH_KEY, 'rank') !== 'admin') {
            $this->flash->set('warning', $this->msg['users_forbidden']);
            $this->app::redirect(true);
        }
    }

    /**
     * permet de dire si un utilisateur est online
     * @return bool|mixed|null
     */
    private function isLogged()
    {
        if ($this->session->hasKey(AUTH_KEY)) {
            return $this->session->read(AUTH_KEY);
        }
        return false;
    }


    /**
     * permet de connecter un utilisateur
     * et de definir son token csrf
     * @param UsersEntity $user
     * @param string $msg
     */
    private function connect(UsersEntity $user, string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->session->write(AUTH_KEY, $user);
            $this->session->write(TOKEN_KEY, $this->str::setToken(10));
            $this->flash->set('success', $msg ?? $this->msg['users_login_success']);
        }
    }


    /**
     * permet de mettre a jour la connexion un utilisateur
     * et de definir son token csrf
     * @param UsersEntity $user
     */
    private function updateConnexion(UsersEntity $user, string $msg = null)
    {
        $this->session->write(AUTH_KEY, $user);
        $this->session->write(TOKEN_KEY, $this->str::setToken(10));
        $this->flash->set('success', $msg ?? $this->msg['users_edit_success']);
    }


    /**
     * permet de connecter un utilisateur a partir d'un cookie
     */
    public function cookieConnect()
    {
        if ($this->cookie->hasKey(COOKIE_REMEMBER_KEY) && !$this->isLogged()) {
            $remember_token = $this->cookie->read(COOKIE_REMEMBER_KEY);
            $user = $this->users->find(explode(".", $remember_token)[2]);  //user id

            if ($user) {
                $expected = "NG.23.{$user->id}.{$user->remember_token}";
                if ($expected === $remember_token) {
                    $this->connect($user);
                    $this->cookie->write(COOKIE_REMEMBER_KEY, $remember_token);
                } else {
                    $this->cookie->delete(COOKIE_REMEMBER_KEY);
                }
            } else {
                $this->cookie->delete(COOKIE_REMEMBER_KEY);
            }
        }
    }


    /**
     * definit un remember token
     * @param int $users_id
     */
    private function remember(int $users_id)
    {
        $remember_token = $this->str::cookieToken();
        $this->users->setRememberToken($remember_token, $users_id);
        $this->cookie->write(COOKIE_REMEMBER_KEY, "NG.23.{$users_id}.{$remember_token}");
    }


    /**
     * permet de connecter un utilisateur
     * page de vue
     */
    public function login()
    {
        $this->cookieConnect();
        $post       =   new Collection($_POST);
        $errors     =   new Collection();

        if ($this->isLogged()) {
            $this->flash->set('warning', $this->msg['users_already_connected']);
            $this->app::redirect($this->isLogged()->accountUrl);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', 'required');
                $this->validator->setRule('password', 'required');

                if ($this->validator->isValid()) {
                    $name       =   $this->str::escape($post->get('name'));
                    $remember   =   intval($post->get('remember'));
                    $password   =   $post->get('password');

                    $user  = $this->users->findAlternative(['name','email'], $name);
                    if ($user) {
                        if ($user->confirmed_at !== null) {
                            if (password_verify($password, $user->password)) {
                                $this->connect($user);
                                if ($remember) {
                                    $this->remember($user->id);
                                }

                                $this->flash->set('success', $this->msg['users_login_success']);
                                $this->app::redirect($user->accountUrl);
                            } else {
                                $this->flash->set('danger', $this->msg['users_bad_identifier']);
                            }
                        } else {
                            $this->flash->set('warning', $this->msg['users_not_confirmed']);
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['users_bad_identifier']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->flash->set('danger', $this->msg['form_multi_errors']);
                }
            }

            $this->pageManager::setName('Connexion');
            $this->setLayout('users/default');
            $this->viewRender('front_end/users/login', compact('post', 'errors'));
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
        $this->flash->set('success', $this->msg['users_logout_success']);
        $this->app::redirect("/login");
    }


    // ACCOUNT MANAGEMENT
    //****************************************************************************/
    /**
     *  permet de generer le profile d'un utilisateur
     *  page de vue
     * @param $username
     *
     */
    public function account(string $username, $id)
    {
        if (!empty($username)) {
            $user = $this->users->find(intval($id));

            if ($user) {
                $verse  =   $this->callController('verses')->index();
                $posts  =   $this->loadModel('posts')->findWith('users_id', $user->id, false);

                $this->pageManager::setName($user->name);
                $this->setLayout('users/account');
                $this->viewRender('front_end/users/account/account', compact("verse", "user", "posts"));
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }


    /**
     * permet de generer la page d'edition d'un utilisateur
     * @param string $token
     */
    public function edit(string $token)
    {
        $this->restrict();
        if ($token === $this->session->read(TOKEN_KEY)) {
            $user       =   $this->session->read(AUTH_KEY);
            $post       =   new Collection($_POST);
            $file       =   new Collection($_FILES);
            $errors     =   new Collection();

            if (isset($_POST) && !empty($_POST)) {
                $this->validator->setRule('name', ['required','apha_dash', 'min_length[3]']);
                $this->validator->setRule('email', ['required', 'valid_email']);
                //$this->validator->setRule('phone', 'numeric');
                //$this->validator->setRule('website', 'valid_url');

                if ($this->validator->isValid()) {
                    if ($post->get('name') !== $user->name) {
                        $this->validator->unique('name', $this->users, $this->msg['users_username_token']);
                    } elseif ($post->get('email') !== $user->email) {
                        $this->validator->unique('email', $this->users, $this->msg['users_email_token']);
                    } elseif ($post->get('phone') !== $user->phone) {
                        $this->validator->unique('phone', $this->users, $this->msg['users_phone_token']);
                    }

                    if ($this->validator->isValid()) {
                        $name       =    $this->str::escape($post->get('name'));
                        $email      =    $this->str::escape($post->get('email'));
                        $bio        =    $this->str::escape($post->get('bio'))      ??  null;
                        $phone      =    $this->str::escape($post->get('phone'))    ??  null;
                        //$website    =    $this->str::escape($post->get('website'))  ??  null;

                        $this->users->update($user->id, compact('name', 'email', 'phone', 'bio'));
                        $user = $this->users->find($user->id);

                        $this->updateConnexion($user, $this->msg['users_edit_success']);
                        $this->app::redirect($user->accountUrl);
                    } else {
                        $errors = new Collection($this->validator->getErrors());
                        $this->flash->set('danger', $this->msg['form_multi_errors']);
                    }
                } else {
                    $errors = new Collection($this->validator->getErrors());
                    $this->flash->set('danger', $this->msg['form_multi_errors']);
                }
            } elseif (!empty($file->get('thumb'))) {
                $name           =   $user->id;
                $isUploaded     =   ImageManager::upload($file, 'avatars', "ngpictures-avatar-{$name}", 'medium');

                if ($isUploaded) {
                    $this->users->update($user->id, ['avatar' => "ngpictures-avatar-{$name}.jpg"]);
                    $user = $this->users->find($user->id);

                    $this->updateConnexion($user, $this->msg['users_edit_success']);
                    $this->app::redirect($user->accountUrl);
                }
            }

            $this->pageManager::setName('Edition du profile');
            $this->setLayout('users/edit');
            $this->viewRender('front_end/users/account/edit', compact('user', 'errors'));
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}
