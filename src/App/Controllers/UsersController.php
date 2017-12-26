<?php
namespace Ngpictures\Controllers;

use Ng\Core\Generic\{Collection, Image};
use Ngpictures\Entity\UsersEntity;
use Ngpictures\Ngpic;
use Ngpictures\Util\Page;



class UsersController extends NgpicController
{

    /**
     * charge le model d'utilisateur
     * UsersController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->loadModel('users');
    }

    /***************************************************************************
    *
    *                    ACCOUNT CREATION && SETTINGS
    *
    ****************************************************************************/


    /**
     * confirmation d'un utilisateur
     * @param $user_id
     * @param string $token
     */
    public function confirm($user_id, string $token)
    {
        $user_id = $this->str::escape($user_id);
        $user = $this->users->isNotConfirmed($user_id);
        
        if ($user && $user->confirmation_token === $token) {
            $this->users->unsetConfirmationToken($user->id);
            $this->connect($user);
            $this->login();
        } else {
            $this->flash->set('danger', $this->msg['user_confirmation_failed']);
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
        $user = $this->users->find($id);

        if ($user) {
            if ($this->users->checkRestToken($user->reset_token, $user->id) === $token) {
                if (isset($_POST) and !empty($_POST)) {
                    $post = new Collection($_POST);
                    $validator = $this->validator;

                    $validator->isMatch('password','password_confirm', $this->msg['user_password_notMatch']);
                    if ($validator->isValid()) {
                        $this->users->resetPassword($post->get('password'), $user->id);

                        $this->flash->set('success', $this->msg['user_reset_password_success']);
                        $this->connect($user);
                        Ngpic::redirect($user->accountUrl);
                    }
                }
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
        Page::setName("Rénitialisation mot de passe | Ngpictures");
        $this->viewRender('user/reset');
    }


    /**
     * mot de pass oubliee
     */
    public function forgot()                                   //bug #1 a regler.
    {
        $post = new Collection($_POST);

        if ($post->has('email')) {
            $email = $this->str::escape($post->get('email'));
            $user = $this->users->findWith('email',$email);

            if ($user && $user->confrimed_at !== null) {
                $this->users->setResetToken($this->str::setToken(60),$user->id);

                $link = "/reset/{$user->id}/{$user->reset_token}";
                //$this->mail::resetpassword($link)
                $this->flash->set('success',$this->msg['user_reset_mail_success']);
                
            } else {
                $this->flash->set('danger',$this->msg['user_email_notFound']);
            }
        }

        Page::setName('Mot de passe oublié | Ngpictures');
        $this->viewRender('users/forgot');
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
        $this->users->add($name,$email,$password,$token);

        //$user_id = $this->users->lastRegisterUser();
        //$link = "confirm/{$user_id}/{$token}";
        //$this->mail::confirmation($link);
        //Ngpic::redirect('/login');
    }


    /**
     * creation d'un compte
     * page de vue
     */
    public function sign()
    {
        if ($this->isLogged()) {
            $this->flash->set('warning', $this->msg['user_already_connected']);
            Ngpic::redirect($this->isLogged()->accountUrl);
        } else {
            $validator = $this->validator;
            $post = new Collection($_POST);

            if (!empty($_POST)) {

                $validator->iskebabCase("name");
                if ($validator->isValid()) {
                    $validator->isUnique("name", $this->users, $this->msg['user_username_tokken']);
                }

                $validator->isEmail("email");
                if ($validator->isValid()) {
                    $validator->isUnique("email", $this->users, $this->msg['user_usermail_tokken']);
                }
                $validator->isMatch("password","password_confirm", $this->msg['user_password_notMatch']);

                if ($validator->isValid()) {
                    $this->register($post->get('name'), $post->get('email'), $post->get('password'));
                    $this->flash->set('success', $this->msg['user_registration_success']);
                    Ngpic::redirect("/login");
                } else {
                    var_dump($this->validator->getErrors());
                }
            }
            Page::setName("Inscription | Ngpictures");
            $this->setLayout('users/default');
            $this->viewRender('users/sign', compact('post'));
        }
    }


    
    /***************************************************************************
    *
    *                   LOGIN SYSTEM && RESTRICTIONS
    *
    ****************************************************************************/

    /**
     * interdire l'access a certaines pages
     * @param string|null $msg
     */
    public function restrict(string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->flash->set("danger", $msg ?? $this->msg["user_must_login"]);
            Ngpic::redirect(true);
        }
    }


    /**
     * admettre une action seulement pour un admin
     */
    public function isAdmin()
    {
        $this->restrict();
        if ($this->session->getValue('auth','rank') !== 'admin') {
            $this->flash->set('warning', $this->msg['user_forbidden']);
            Ngpic::redirect(true);
        }
    }

    /**
     * permet de dire si un utilisateur est online
     * @return bool|mixed|null
     */
    private function isLogged()
    {
        if (!$this->session->read("auth")) {
            return false;
        }
        return $this->session->read("auth");
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
            $this->session->write('auth', $user);
            $this->session->write('token', $this->str::setToken(60));
            $this->flash->set('success', $msg ?? $this->msg['user_login_success']);
        }
    }


    /**
     * permet de connecter un utilisateur a partir d'un cookie
     */
    public function cookieConnect()
    {
        if ($this->cookie->hasKey("remember") && !$this->isLogged()) {
            $remember_token = $this->cookie->read("remember");
            $parts = explode(".", $remember_token);
            $user = $this->users->find($parts[2]);
            
            if ($user) {
                $expected = "NG.23.".$user->id.".".$user->remember_token;
                if ($expected === $remember_token) {
                    $this->connect($user);
                    $this->cookie->write("remember", $remember_token);
                } else {
                   $this->cookie->delete("remember");
                }
            } else {
                $this->cookie->delete("remember");
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
        $this->cookie->write("remember","NG.23.{$user_id}.{$remember_token}");
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
            $this->flash->set('warning', $this->msg['user_already_connected']);
            Ngpic::redirect($this->isLogged()->accountUrl);
        } else {
            if (isset($_POST) && !empty($_POST)) {
                $password = $post->get('password');
                $name = $this->str::escape($post->get('name'));
                $remember = intval($post->get('remember'));

                if ($post->has('password') && $post->has('name')) {
                    $user  = $this->users->findAlternative(['name','email'], $name);
                    if($user) {
                        if ($user->confirmed_at !== null) {
                            if (password_verify($password, $user->password)) {
                                $this->connect($user);
                                if ($remember) {
                                    $this->remember($user->id);
                                }
                                $this->flash->set('success', $this->msg['user_login_success']);
                                Ngpic::redirect($user->accountUrl);
                            } else {
                                $this->flash->set('danger', $this->msg['user_bad_identifier']);
                            }
                        } else {
                            $this->flash->set('warning', $this->msg['user_not_confirmed']);
                        }
                    } else {
                        $this->flash->set('danger', $this->msg['user_bad_identifier']);
                    }
                }
            }

            Page::setName('Connexion | Ngpictures');
            $this->setLayout('users/default');
            $this->viewRender('users/login',compact('post')); 
        }
    }


    /**
     * permet de deconnecter un utilisateur
     */
    public function logout()
    {
        $this->cookie->delete("remember");
        $this->session->delete("auth");
        $this->session->delete("token");
        $this->flash->set('success', $this->msg['user_logout_success']);
        Ngpic::redirect("/login");
    }


    /***************************************************************************
    *
    *                         ACCOUNT MANAGEMENT
    *
    ****************************************************************************/


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
        
            if ($user && $this->str::checkUserUrl($username, $user->name) == true ) {

                $verse = $this->callController('verses')->index();
                Page::setName($user->name . " | Ngpictures");
                $this->setLayout('users/account');
                $this->viewRender('users/account', compact("verse","user"));
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }


    /**
     * permet de generer la page d'edition d'un utilisateur
     * @param string $username
     * @param $id
     * @param string $token
     */
    public function edit(string $username, $id, string $token)
    {
        if ($token === $this->session->read('token')) {
            $user = $this->users->find($id);
            
            if ($user && $this->str::checkUserUrl($username, $user->name) == true  ) {
                $post = new Collection($_POST);
                $file = new Collection($_FILES);

                if (isset($_POST) && !empty($_POST)) {
                    $bio = $this->str::escape($post->get('bio')) ?? $user->bio;

                    if ($post->get('name') && $post->get('name') !== $user->name) {
                        $this->validator->isKebabCase('name');
                        if ($this->validator->isValid()) {
                            $this->validator->isUnique('name', $this->users, $this->msg['user_username_tokken']);
                            $name = $this->str::escape($post->get('name'));
                        }
                    } else {
                        $name = $user->name;
                    }

                    if ($post->get('email') && $post->get('email') !== $user->email) {
                        $this->validator->isEmail('email');
                        if ($this->validator->isValid()) {
                            $this->validator->isUnique('email', $this->users, $this->msg['user_mail_tokken']);
                            $email = $this->str::escape($post->get('email'));
                        }
                    }

                    if ($post->get('phone') && $post->get('phone') !== $user->phone) {
                        $this->validator->isUnique('phone', $this->users, $this->msg['user_phone_tokken']);
                        $phone = $this->str::escape($post->get('phone'));
                    } else {
                        $phone = $user->phone;
                    }

                    if ($this->validator->isValid()) {
                        $this->users->update($user->id, compact('name','email','phone','bio'));
                        $user = $this->users->find($user->id);
                        $this->session->write('auth', $user);
                        $this->flash->set('success', $this->msg['user_edit_success']);
                        Ngpic::redirect($user->accountUrl);
                    }
                } elseif (!empty($file->get('thumb'))) {

                    $name = "{$user->name}-{$id}";
                    $isUploaded = Image::upload($file, 'avatars', "ngpictures-{$name}", 'medium');

                    if ($isUploaded) {
                        $this->users->update($user->id, ['avatar' => "ngpictures-{$name}.jpg"]);
                        $user = $this->users->find($user->id);
                        $this->session->write('auth', $user);
                        $this->flash->set('success', $this->msg['user_edit_success']);
                        Ngpic::redirect($user->accountUrl);
                    }
                }
                Page::setName('Edition du profile | Ngpictures');
                $this->setLayout('users/edit');
                $this->viewRender('users/edit', compact('user'));
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }
}
