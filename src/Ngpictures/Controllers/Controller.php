<?php
namespace Ngpictures\Controllers;

use Ngpictures\Managers\MessageManager;
use Ng\Core\Managers\StringManager;
use Ngpictures\Managers\PageManager;
use Psr\Container\ContainerInterface;
use Ng\Core\Managers\ValidationManager;
use Ng\Core\Interfaces\SessionInterface;
use Ng\Core\Managers\FlashMessageManager;
use Ngpictures\Services\Auth\DatabaseAuthService;
use Ng\Core\Controllers\Controller as SuperController;

/**
 * Class Controller
 * @package Ngpictures\Controllers
 */
class Controller extends SuperController
{
    /**
     * @var MessageManager
     */
    protected $msg;

    /**
     * @var mixed|FlashMessageManager
     */
    protected $flash;

    /**
     * @var mixed|SessionInterface
     */
    protected $session;

    /**
     * @var PageManager
     */
    protected $pageManager;

    /**
     * @var mixed|DatabaseAuthService
     */
    protected $authService;

    /**
     * @var mixed|ValidationManager
     */
    protected $validator;

    /**
     * @var mixed|StringManager
     */
    protected $str;


    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->str              =   $this->container->get(StringManager::class);
        $this->flash            =   $this->container->get(FlashMessageManager::class);
        $this->session          =   $this->container->get(SessionInterface::class);
        $this->validator        =   $this->container->get(ValidationManager::class);
        $this->authService      =   $this->container->get(DatabaseAuthService::class);

        /*if (!$this->authService->isLogged()) {
             $this->authService->cookieConnect();
        }*/
    }


    /**
     * permet de rendre une vue
     *
     * @param string $view
     * @param array $variables
     * @param boolean $layout
     * @return void
     */
    public function view(string $view, array $variables = [], bool $layout = true)
    {
        $this->renderer->addGlobal('pageManager', new PageManager());
        $this->renderer->addGlobal('sessionManager', $this->session);
        $this->renderer->addGlobal('flashMessageManager', $this->flash);

        if ($this->authService->isLogged()) {
            $this->renderer->addGlobal('activeUser', $this->session->read(AUTH_KEY));
            $this->renderer->addGlobal('securityToken', $this->session->read(TOKEN_KEY));
            $this->renderer->addGlobal(
                'notificationsNumber',
                $this->loadModel('notifications')->count($this->authService->isLogged()->id)->num
            );

            PageManager::setMeta(['active-user' => $this->session->getValue(AUTH_KEY, 'id')]);
            PageManager::setMeta(['active-token' => $this->session->read(TOKEN_KEY)]);
        } else {
            $this->renderer->addGlobal('activeUser', false);
            $this->renderer->addGlobal('securityToken', false);
        }

        parent::view($view, $variables);
    }
}
