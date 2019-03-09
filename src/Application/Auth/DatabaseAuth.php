<?php
namespace Application\Services\Auth;

use Application\Entities\UsersEntity;
use Application\Repositories\UsersRepository;
use Framework\Http\RequestAwareAction;
use Framework\Managers\CookieManager;
use Framework\Managers\FlashMessageManager;
use Framework\Managers\Mailer\Mailer;
use Framework\Managers\SessionManager;
use Framework\Managers\StringManager;
use Psr\Container\ContainerInterface;

/**
 * Class DatabaseAuthService
 * @package Application\Services\Auth
 */
class DatabaseAuthService
{
    use RequestAwareAction;

    /**
     * le model des users, donc l'access a la base de donnee.
     * @var UsersRepository
     */
    private $users;


    /**
     * container
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var mixed|FlashMessageManager
     */
    private $flash;

    /**
     * @var mixed|SessionManager
     */
    private $session;

    /**
     * @var mixed|CookieManager
     */
    private $cookie;

    /**
     * @var mixed|StringManager
     */
    private $str;


    /**
     * DatabaseAuthService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->users = $this->container->get(UsersRepository::class);
        $this->flash = $this->container->get(FlashMessageManager::class);
        $this->session = $this->container->get(SessionManager::class);
        $this->cookie = $this->container->get(CookieManager::class);
        $this->str = $this->container->get(StringManager::class);
    }

    /**
     * connect the user to the current session
     * @param UsersEntity $user
     */
    public function connect(UsersEntity $user): void
    {
        if (!$this->isLogged()) {
            $this->session->write(AUTH_KEY, $user);
            $this->session->write(TOKEN_KEY, StringManager::setToken(60));
            $this->flash->set('success', 'users_login_success');
        }
    }

    /**
     * @return bool|UsersEntity
     */
    public function isLogged()
    {
        if ($this->session->hasKey(AUTH_KEY)) {
            return $this->session->read(AUTH_KEY);
        }
        return false;
    }


    public function isAdmin()
    {
        $this->restrict();
        if ($this->session->getValue(AUTH_KEY, 'rank') !== 'admin') {
            $this->flash->set('warning', 'users_forbidden');
            $this->redirect();
        }
    }

    /**
     * restriction des pages
     */
    public function restrict()
    {
        if (!$this->isLogged()) {
            $this->flash->set("danger", "users_not_logged");
            $this->redirect();
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
        $remember_token = $this->str->cookieToken();
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
        $this->session->write(TOKEN_KEY, $this->str->setToken(10));
        $this->flash->set('success', $msg ?? $this->flash->msg['users_edit_success']);
    }

    /**
     * renvoi le token de la session active
     * @return mixed
     */
    public function getToken()
    {
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
        $str = $this->container->get(StringManager::class);
        $name = $str->escape($name);
        $email = $str->escape($email);
        $token = $str->setToken(60);
        $password = $str->hashPassword($password);

        $this->users->add($name, $email, $password, $token);
        $users_id = $this->users->lastInsertId();
        $link = SITE_NAME . "/confirm/{$users_id}/{$token}";

        $this->container->get(Mailer::class)->accountConfirmation($link, $email);
    }
}
