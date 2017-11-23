<?php
namespace Ngpic\Controller;
use Core\Generic\Collection;
use Ngpic\Entity\UsersEntity;
use \Ngpic;

class UsersController extends NgpicController
{
    private $msg = [
        "must_login" => "Vous devez vous connecter",
        "user_not_confirmed" => "Votre compte n'a pas encore été confirmé",
        "registrationSucces" => "Un email de confirmation de compte vous a été envoyer",
        "not_found_email" => "Aucun compte ne correspond a cet email",
        "reset_mail_success" => "les instruction de rappelle de mot de passe vous ont ete envoyer par mail",
        "logout_success" => "Vous êtes déconnecté",
        "login_success" => "Vous êtes connecté",
        "already_connected" => "Vous êtes déjà connecter",
        "bad_identifier" => "Mauvais pseudo ou mot de passe",
        "dont_have_account" => "Vous n'avez pas de compte ? créez en un",
        'forbidden' => "Vous n'avez pas le droit d'access à cette page",
    ];

    public function __construct()
    {
        parent::__construct();
        $this->loadModel('users');
    }


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


    public function sign()
    {
        $validator = $this->validator;
        $errors = [];
        $session = $this->session;

        if (!empty($_POST)) {

            $validator->iskebabCase("name");
            if ($validator->isValid()) {
                $validator->isUnique("name", $this->users,"ce pseudo est déjà pris");
            }

            $validator->isEmail("email");
            if ($validator->isValid()) {
                $validator->isUnique("email", $this->users,"cet email est déjà pris");
            }
            $validator->isMatch("password","password_confirm","mot de passe invalide");
            $validator->isValidCaptcha('captcha', $this->session);

            if ($validator->isValid()) {
                $this->register($_POST['name'], $_POST['email'], $_POST['password']);

                $this->session->setFlash('success',$this->msg['registrationSucces']);
                Ngpic::redirect("/login");
            } else {
                (Ngpic::hasDebug())? var_dump($validator->getErrors()) : $errors = $validator->getErrors();
            }
        }

        $post = new Collection($_POST);

        $this->setTemplate('users/default');
        $this->viewRender('users/sign',compact(
            'post','errors','session'
        ));
        \Core\Generic\Image::generateCaptcha();
    }


    public function confirm(int $user_id, string $token)
    {
        $user_id = $this->str::escape($user_id);
        $user = $this->users->isuser_not_confirmed($user_id);
        
        if ($user && $user->confirmation_token === $token) {
            $this->users->unsetConfirmationToken($user->id);
            $this->connect($user);
            $this->login();
        } else {
            $this->session->setFlash('danger','une erreur est survenu lors de votre confirmation');
            $this->login();
        }
    }


    public function restrict(string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->session->setFlash("danger", $msg ?? $this->msg["must_login"]);
            Ngpic::redirect(true);
        }
    }


    public function isAdmin()
    {
        $this->restrict();
        if ($this->session->getValue('auth','rank') !== 'admin') {
            $this->session->setFlash('warning', $this->msg['forbidden']);
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
            $this->session->setFlash('success', $this->msg['login_success']);
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
                    $this->cookie->write("remember", $remember_token,"15D");
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
        $this->users->setRememberToken($remember_token,$user_id);
        $this->cookie->write("remember","NG.23.".$user_id.".".$remember_token,"15D");
    }


    public function login()
    {
        $this->cookieConnect();

        if ($this->isLogged()) {
            $this->session->setFlash('warning', $this->msg['already_connected']);
            Ngpic::redirect(true);
        } else {
            $this->connexion();
            $this->setTemplate('users/default');
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
        
        if($user) {
           if ($this->isConfirmed($user)) {
                if (password_verify($password, $user->password)) {
                    $this->connect($user);
                    if ($remember) {
                        $this->remember($user->id);
                    }
                    $this->session->setFlash('success', $this->msg['login_success']);
                    Ngpic::redirect('/account');
                } else {
                    $this->session->setFlash('danger', $this->msg['bad_identifier']);
                }
            } else {
                $this->session->setFlash('warning', $this->msg['user_not_confirmed']);
            }
        } else {
            $this->session->setFlash('danger', $this->msg['bad_identifier']);
        }
    }


    public function logout()
    {
        $this->cookie->delete("remember");
        $this->session->delete("auth");
        $this->session->setFlash('success', $this->msg['logout_success']);
        Ngpic::redirect(true);
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
                $this->session->setFlash('success',$this->msg['reset_mail_success']);
                
            } else {
                $this->session->setFlash('danger',$this->msg['not_found_email']);
            }
        }

        $this->viewRender('users/forgot');
    }


    public function reset(int $id, string $token)
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

                        $this->session->setFlash('success', $this->msg['resetPasswordSuccess']);
                        $this->connect($user);
                        Ngpic::redirect('/account/{$user->name}-{$user->id}');
                    } else {
                        $this->session->setFlash('danger', $this->msg['notMatchpassword']);
                    }
                }
            } else {
                $this->session->setFlash('danger', $this->msg['unvalidToken']);
                Ngpic::redirect('/forgot');
            }
        } else {
            Ngpic::redirect();
        }

        $this->viewRender('user/reset');
    }


    public function account()
    {
        $user  = $this->session->read('Auth');
        $verse = $this->callController('verses')->index();
        $this->viewRender('users/account',
            compact(
                "verse","user"
            )
        );
    }
}
