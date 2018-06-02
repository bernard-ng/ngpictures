<?php
namespace Ngpictures\Services\Auth;


use Ng\Core\Managers\Mailer\Mailer;
use Ngpictures\Entity\UsersEntity;
use Ngpictures\Models\UsersModel;
use Ngpictures\Ngpictures;


class DatabaseAuthService extends AuthService
{
    /**
     * le model des users, donc l'access a la base de donnee.
     * @var UsersModel
     */
    protected $users;


    /**
     * DatabaseAuthService constructor.
     * @param Ngpictures $app
     * @param UsersModel $users
     */
    public function __construct(Ngpictures $app, UsersModel $users)
    {
        parent::__construct($app);
        $this->users = $users;
    }


    /**
     * restriction des pages
     * @param string $msg
     */
    public function restrict($msg = null)
    {
        if (!$this->isLogged()) {
            $this->flash->set("danger", $msg ?? $this->msg["users_not_logged"]);
            $this->app::redirect(true);
        }
    }


    /**
     * confirmation de compte, via mail
     * @param int $users_id
     * @param string $token
     */
    public function confirm(int $users_id, string $token) {
        $token  =   $this->str::escape($token);
        $user   =   $this->users->isNotConfirmed(intval($users_id));

        if ($user && $user->confirmation_token === $token) {
            $this->users->unsetConfirmationToken($user->id);
            $this->connect($user);
            $this->app::redirect("/login");
        } else {
            $this->flash->set('danger', $this->msg['users_confirmation_failed']);
            $this->app::redirect("/login");
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
     * permet de connecter un utilisateur
     * et de definir son token csrf
     * @param UsersEntity $user
     * @param string $msg
     */
    public function connect(UsersEntity $user, string $msg = null)
    {
        if (!$this->isLogged()) {
            $this->session->write(AUTH_KEY, $user);
            $this->session->write(TOKEN_KEY, $this->str::setToken(10));
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
     * @param int $users_id
     */
    public function remember(int $users_id)
    {
        $remember_token = $this->str::cookieToken();
        $this->users->setRememberToken($remember_token, $users_id);
        $this->cookie->write(COOKIE_REMEMBER_KEY, "NG.23.{$users_id}.{$remember_token}");
    }


    /**
     * permet de mettre a jour la connexion un utilisateur
     * et de definir son token csrf
     * @param UsersEntity $user
     * @param string|null $msg
     */
    public function reConnect(UsersEntity $user, string $msg = null)
    {
        $this->session->write(AUTH_KEY, $user);
        $this->session->write(TOKEN_KEY, $this->str::setToken(10));
        $this->flash->set('success', $msg ?? $this->msg['users_edit_success']);
    }


    /**
     * permet de dire si un utilisateur est online
     * @return bool|mixed|null
     */
    public function isLogged()
    {
        if ($this->session->hasKey(AUTH_KEY)) {
            return $this->session->read(AUTH_KEY);
        }
        return false;
    }


    /**
     * renvoi le token de la session active
     * @return mixed
     */
    public function getToken() {
        return $this->session->read(TOKEN_KEY);
    }


    /**
     * cree un nouvel utilisateur
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function register(string $name, string $email, string $password)
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
}