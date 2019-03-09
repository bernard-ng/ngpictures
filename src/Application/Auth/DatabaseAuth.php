<?php
namespace Application\Auth;

use Application\Entities\UsersEntity;
use Application\Repositories\UsersRepository;
use Framework\Auth\AuthInterface;
use Framework\Auth\User;
use Framework\Http\RequestAwareAction;
use Framework\Managers\CookieManager;
use Framework\Managers\FlashMessageManager;
use Framework\Managers\Mailer\Mailer;
use Framework\Managers\SessionManager;
use Framework\Managers\StringHelper;
use Psr\Container\ContainerInterface;

/**
 * Class DatabaseAuthService
 * @package Application\Services\Auth
 */
class DatabaseAuth implements AuthInterface
{
    use RequestAwareAction;

    /**
     * @var UsersRepository|mixed
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
    }

    /**
     * connect the user to the current session
     * @param User $user
     */
    public function connect(User $user): void
    {
        if (!$this->getUser()) {
            $this->session->write(AUTH_KEY, $user);
            $this->session->write(TOKEN_KEY, StringHelper::setToken(60));
            $this->flash->success('users_login_success');
        }
    }


    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        if ($this->session->hasKey(AUTH_KEY)) {
            return $this->session->read(AUTH_KEY);
        }
        return null;
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
        if (!$this->getUser()) {
            $this->flash->set("danger", "users_not_logged");
            $this->redirect();
        }
    }

    /**
     * permet de connecter un utilisateur a partir d'un cookie
     */
    public function cookieConnect()
    {
        if ($this->cookie->hasKey(COOKIE_REMEMBER_KEY) && !$this->getUser()) {
            $remember_token = $this->cookie->read(COOKIE_REMEMBER_KEY);
            $user = $this->users->findWith('remember_token', $remember_token);
            if ($user) {
                $this->connect($user);
                $this->cookie->write(COOKIE_REMEMBER_KEY, $remember_token);
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
        $remember_token = StringHelper::cookieToken();
        $this->users->setRememberToken($remember_token, $users_id);
        $this->cookie->write(COOKIE_REMEMBER_KEY, "NG.23.{$users_id}.{$remember_token}");
    }

    /**
     * permet de mettre a jour la connexion un utilisateur
     * et de definir son token csrf
     * @param User $user
     */
    public function updateConnexion(User $user)
    {
        $this->session->write(AUTH_KEY, $user);
        $this->session->write(TOKEN_KEY, StringHelper::setToken(60));
        $this->flash->success('users_edit_success');
    }

    /**
     * renvoi le token de la session active
     * @return mixed
     */
    public function getToken()
    {
        return $this->session->read(TOKEN_KEY);
    }
}
