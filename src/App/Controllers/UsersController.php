<?php
namespace Ngpictures\Controllers;

use Ng\Core\Generic\Collection;
use Ngpictures\Entity\UsersEntity;
use Ngpictures\Ngpic;
use Ngpictures\Util\Page;
use Facebook\Facebook;



class UsersController extends NgpicController
{
    
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


    private function register(string $name, string $email, string $password)
    {
        $password = $this->str::hashPassword($password);
        $name = $this->str::escape($name);
        $email = $this->str::escape($email);
        $token = $this->str::setToken(60);

        $this->users->add($name,$email,$password,$token);
        
        $user_id = $this->users->lastRegisterUser();
        $link = "confirm/{$user_id}/{$token}";
        //$this->mail::confirmation($link);
        Ngpic::redirect($link);
    }


    public function confirm($user_id, $token)
    {
        $user_id = $this->str::escape($user_id);
        $user = $this->users->isNotConfirmed($user_id);
        
        if ($user && $user->confirmation_token === $token) {
            $this->users->unsetConfirmationToken($user->id);
            $this->connect($user);
            $this->login();
        } else {
            var_dump($user);die();
            $this->flash->set('danger', $this->msg['user_confirmation_failed']);
            $this->login();
        }
    }

    public function reset($id, $token)
    {
        $user = $this->users->find($id);

        if ($user) {
            if ($this->checkRestToken($user->reset_token, $user->id) === $token) {
                if (isset($_POST) and !empty($_POST)) {
                    $post = new Collection($_POST);
                    $validator = $this->validator;

                    $validator->isMatch('password','password_confirm');
                    if ($validator->isValid()) {
                        $this->resetPassword($post->get('password'),$user->id);

                        $this->flash->set('success', $this->msg['user_reset_password_success']);
                        $this->connect($user);
                        Ngpic::redirect($user->accountUrl);
                    } else {
                        $this->flash->set('danger', $this->msg['user_password_notMatch']);
                    }
                }
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect(true);
            }
        } else {
            Ngpic::redirect();
        }

        Page::setName("Rénitialisation mot de passe | Ngpictures");
        $this->viewRender('user/reset');
    }


    public function forgot()                                   //bug #1 a regler.
    {
        $post = new Collection($_POST);

        if ($post->has('email')) {
            $email = $this->str::escape($post->get('email'));
            $user = $this->users->findWith('email',$email);

            if ($user && $this->isConfirmed($user)) {
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


    public function sign()
    {
        $validator = $this->validator;
        $errors = [];
        $session = $this->session;

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
            //$validator->isValidCaptcha('captcha', $this->session);

            if ($validator->isValid()) {
                $this->register($_POST['name'], $_POST['email'], $_POST['password']);

                $this->flash->set('success', $this->msg['user_registration_success']);
                Ngpic::redirect("/login");
            } else {
                $this->flash->set('danger', "une erreur");
                (Ngpic::hasDebug())? var_dump($validator->getErrors()) : $errors = $validator->getErrors();
            }
        }

        $post = new Collection($_POST);

        Page::setName("Inscription | Ngpictures");
        $this->setLayout('users/default');

        $this->viewRender('users/sign',compact(
            'post','errors','session'
        ));
    }


    
    /***************************************************************************
    *
    *                   LOGIN SYSTEM && RESTRICTIONS
    *
    ****************************************************************************/


    public function restrict($msg = null)
    {
        if (!$this->isLogged()) {
            $this->flash->set("danger", $msg ?? $this->msg["user_must_login"]);
            Ngpic::redirect(true);
        }
    }


    public function isAdmin()
    {
        $this->restrict();
        if ($this->session->getValue('auth','rank') !== 'admin') {
            $this->flash->set('warning', $this->msg['user_forbidden']);
            Ngpic::redirect('/error-403');
        }
    }


    private function isLogged()
    {
        if (!$this->session->read("auth")) {
            return false;
        }
        return $this->session->read("auth");
    }

    private function isConfirmed(UsersEntity $user): bool
    {
        if($user->confirmed_at === null) {
            $this->restrict($this->msg["user_not_confirmed"]);
            return false;
        }
        return true;
    }


    private function connect(UsersEntity $user)
    {
        if (!$this->isLogged()) {
            $this->session->write("auth", $user);
            $this->flash->set('success', $this->msg['user_login_success']);
        }
    }


    public function cookieConnect()
    {
        if ($this->cookie->hasKey("remember") && !$this->isLogged()) {
            $remember_token = $this->cookie->read("remember");
            $parts = explode(".", $remember_token);
            $this->users->find($parts[2]); // parts[2] => user_id
            
            if ($user) {
                $expected = "NG.23.".$user_id.".".$user->remember_token;
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


    private function remember(int $user_id)
    {
        $remember_token = $this->str::cookieToken($user_id);
        $this->users->setRememberToken($remember_token, $user_id);
        $this->cookie->write("remember","NG.23.{$user_id}.{$remember_token}");
    }


    public function login()
    {
        $this->cookieConnect();

        if ($this->isLogged()) {
            $this->flash->set('warning', $this->msg['user_already_connected']);
            Ngpic::redirect($this->isLogged()->accountUrl);
        } else {
            $this->connexion();

            Page::setName('Connexion | Ngpictures');
            $this->setLayout('users/default');
            $this->viewRender('users/login'); 
        }
    }

    private function connexion()
    {
        $post = new Collection($_POST);
        $password = $post->get('password');
        $remember = $post->get('remember');

        $name = $this->str::escape($post->get('name'));
        $remember = intval($post->get('remember'));
        $user  = $this->users->findAlternative(['name','email'], $name);
        
       if (!empty($password) && !empty($name)) {
            if($user) {
               if ($this->isConfirmed($user)) {
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


    public function logout()
    {
        $this->cookie->delete("remember");
        $this->session->delete("auth");
        $this->flash->set('success', $this->msg['user_logout_success']);
        Ngpic::redirect(true);
    }


    
    /***************************************************************************
    *
    *                          FACEBOOK GRAPH API 2.11
    *
    ****************************************************************************/

    /*public function facebookConnect(){
        $fb = new Facebook(
            'app_id' => '1951395041776982',
            'app_secret' => '55d44750aa7ebaeed280e44c3ae1a1e7',
            'default_graph_version' => 'v2.11',
        );
    }*/


    /***************************************************************************
    *
    *                         ACCOUNT MANAGEMENT
    *
    ****************************************************************************/
    

    public function account($username, $id)
    {
        if (is_string($username) && !empty($username) && !empty($id)) {
            $user = $this->users->find(intval($id));
        
            if ($user && $this->str::checkUserUrl($username, $user->name) == true ) {
                $verse = $this->callController('verses')->index();
                
                $this->setLayout('users/account');
                $this->viewRender('users/account',
                    compact(
                        "verse","user"
                    )
                );
            } else {
                $this->flash->set('danger', $this->msg['indefined_error']);
                Ngpic::redirect();
            }
        } else {
            $this->flash->set('danger', $this->msg['indefined_error']);
            Ngpic::redirect(true);
        }
    }
}
