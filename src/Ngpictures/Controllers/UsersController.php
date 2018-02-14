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
     * @param $user_id
     * @param string $token
     */
    public function confirm(int $user_id, string $token)
    {
        $token = $this->str::escape($token);
        $user = $this->users->isNotConfirmed(intval($user_id));
        
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
        $user = $this->users->find(intval($id));
        $token = $this->str::escape($token);

        if ($user && $user->reset_token == $token) {
            $post = new Collection($_POST);

            if (isset($_POST) and !empty($_POST)) {
                if (!empty($post->get('password')) && !empty($post->get('password_confirm'))) {
                    $validator = $this->validator;
                    $validator->isMatch('password', 'password_confirm', $this->msg['users_bad_password']);
                    if ($validator->isValid()) {
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
                $email = $this->str::escape($post->get('email'));
                $user = $this->users->findWith('email', $email);

                if ($user && $user->confirmed_at != null) {
                    $this->users->setResetToken($this->str::setToken(60), $user->id);
                    $user = $this->users->find($user->id);
                    $link = SITE_NAME."/reset/{$user->id}/{$user->reset_token}";

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
        $password = $this->str::hashPassword($password);
        $name = $this->str::escape($name);
        $email = $this->str::escape($email);
        $token = $this->str::setToken(60);
        $this->users->add($name, $email, $password, $token);
        
        $user_id = $this->users->lastInsertId();
        $link = SITE_NAME."/confirm/{$user_id}/{$token}";

        (new Mailer())->accountConfirmation($link, $email);
        $this->flash->set('success', $this->msg['users_registration_success']);
        $this->app::redirect('/login');
    }


    /**
     * creation d'un compte
     * page de vue
     */
    public function sign()
    {
        $post = new Collection($_POST);

        if (isset($_POST) && !empty($_POST)) {
            $validator = $this->validator;
            $validator->iskebabCase("name");
            if ($validator->isValid()) {
                $validator->isUnique("name", $this->users, $this->msg['users_username_token']);
            }

            $validator->isEmail("email");
            if ($validator->isValid()) {
                $validator->isUnique("email", $this->users, $this->msg['users_mail_token']);
            }
            $validator->isGreaterThan("password", 8, $this->msg['users_short_password']);
            $validator->isMatch("password", "password_confirm", $this->msg['users_bad_password']);

            if ($validator->isValid()) {
                $this->register($post->get('name'), $post->get('email'), $post->get('password'));
                $this->flash->set('success', $this->msg['users_registration_success']);
                $this->app::redirect("/login");
            } else {
                var_dump($this->validator->getErrors());
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
            $this->session->write(TOKEN_KEY, $this->str::setToken(60));
            $this->flash->set('success', $msg ?? $this->msg['users_login_success']);
        }
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
     * @param int $user_id
     */
    private function remember(int $user_id)
    {
        $remember_token = $this->str::cookieToken();
        $this->users->setRememberToken($remember_token, $user_id);
        $this->cookie->write(COOKIE_REMEMBER_KEY, "NG.23.{$user_id}.{$remember_token}");
    }


    /**
     * permet de connecter un utilisateur
     * page de vue
     */
    public function login()
    {
        $this->cookieConnect();
        $post = new Collection($_POST);

        if ($this->isLogged()) {
            $this->flash->set('warning', $this->msg['users_already_connected']);
            $this->app::redirect($this->isLogged()->accountUrl);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $password = $post->get('password');
                $name = $this->str::escape($post->get('name'));
                $remember = intval($post->get('remember'));

                if ($post->has('password') && $post->has('name')) {
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
                }
            }

            $this->pageManager::setName('Connexion');
            $this->setLayout('users/default');
            $this->viewRender('front_end/users/login', compact('post'));
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
     * @param $id
     */
    public function account($username, $id)
    {
        if (!empty($username) && !empty($id)) {
            $user = $this->users->find(intval($id));

        
            if ($user && $this->str::checkUserUrl($username, $user->name) == true) {
                $verse = $this->callController('verses')->index();
                $posts = $this->loadModel('posts')->findWithUser($user->id);

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
     * @param string $username
     * @param $id
     * @param string $token
     */
    public function edit(string $username, int $id, string $token)
    {
        if ($token === $this->session->read(TOKEN_KEY)) {
            $user = $this->users->find(intval($id));
            
            if ($user && $this->str::checkUserUrl($username, $user->name) == true) {
                $post = new Collection($_POST);
                $file = new Collection($_FILES);

                if (isset($_POST) && !empty($_POST)) {
                    $bio = $this->str::escape($post->get('bio')) ?? $user->bio;

                    if ($post->get('name') && $post->get('name') !== $user->name) {
                        $this->validator->isKebabCase('name');
                        if ($this->validator->isValid()) {
                            $this->validator->isUnique('name', $this->users, $this->msg['users_username_token']);
                            $name = $this->str::escape($post->get('name'));
                        }
                    } else {
                        $name = $user->name;
                    }

                    if ($post->get('email') && $post->get('email') !== $user->email) {
                        $this->validator->isEmail('email');
                        if ($this->validator->isValid()) {
                            $this->validator->isUnique('email', $this->users, $this->msg['users_mail_token']);
                            $email = $this->str::escape($post->get('email'));
                        }
                    }

                    if ($post->get('phone') && $post->get('phone') !== $user->phone) {
                        $this->validator->isUnique('phone', $this->users, $this->msg['users_phone_token']);
                        $phone = $this->str::escape($post->get('phone'));
                    } else {
                        $phone = $user->phone;
                    }

                    if ($this->validator->isValid()) {
                        $this->users->update($user->id, compact('name', 'email', 'phone', 'bio'));
                        $user = $this->users->find($user->id);

                        $this->session->write(AUTH_KEY, $user); // updating active user is session
                        $this->flash->set('success', $this->msg['users_edit_success']);
                        $this->app::redirect($user->accountUrl);
                    }
                } elseif (!empty($file->get('thumb'))) {
                    $name = "{$user->name}-{$id}";
                    $isUploaded = ImageManager::upload($file, 'avatars', "ngpictures-{$name}", 'medium');

                    if ($isUploaded) {
                        $this->users->update($user->id, ['avatar' => "ngpictures-{$name}.jpg"]);
                        $user = $this->users->find($user->id);
                        
                        $this->session->write(AUTH_KEY, $user); // updating active user is session
                        $this->flash->set('success', $this->msg['users_edit_success']);
                        $this->app::redirect($user->accountUrl);
                    }
                }

                $this->pageManager::setName('Edition du profile');
                $this->setLayout('users/edit');
                $this->viewRender('front_end/users/account/edit', compact('user'));
            } else {
                $this->flash->set('danger', $this->msg['undefined_error']);
                $this->app::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['undefined_error']);
            $this->app::redirect(true);
        }
    }
}