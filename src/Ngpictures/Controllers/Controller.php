<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ng\Core\Managers\StringManager;
use Ngpictures\Managers\PageManager;
use Psr\Container\ContainerInterface;
use Ng\Core\Managers\ValidationManager;
use Ng\Core\Interfaces\SessionInterface;
use Ng\Core\Managers\FlashMessageManager;
use Ngpictures\Services\Auth\DatabaseAuthService;
use Ng\Core\Controllers\Controller as SuperController;


class Controller extends SuperController
{
    protected $msg;
    protected $flash;
    protected $session;
    protected $pageManager;
    protected $authService;
    protected $validator;


    /**
     * construction
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->str              =   $this->container->get(StringManager::class);
        $this->flash            =   $this->container->get(FlashMessageManager::class);
        $this->session          =   $this->container->get(SessionInterface::class);
        $this->validator        =   $this->container->get(ValidationManager::class);
        $this->pageManager      =   $this->container->get(PageManager::class);
        $this->authService      =   $this->container->get(DatabaseAuthService::class);

        if(!$this->authService->isLogged()) {
            $this->authService->cookieConnect();
        }
    }


    /**
     * permet de rendre une vue
     *
     * @param string $view
     * @param array $variables
     * @param boolean $layout
     * @return void
     */
    public function viewRender(string $view, array $variables = [], bool $layout = true)
    {
        $this->renderer->addGlobal('pageManager', $this->pageManager);
        $this->renderer->addGlobal('sessionManager', $this->session);
        $this->renderer->addGlobal('flashMessageManager', $this->flash);
        $this->renderer->addGlobal('verse', $this->callController('verses')->index());

        if ($this->authService->isLogged()) {
            $this->renderer->addGlobal('activeUser', $this->session->read(AUTH_KEY));
            $this->renderer->addGlobal('securityToken', $this->session->read(TOKEN_KEY));
            $this->pageManager::setMeta(['active-user' => $this->session->getValue(AUTH_KEY, 'id')]);
            $this->pageManager::setMeta(['active-token' => $this->session->read(TOKEN_KEY)]);
        } else {
            $this->renderer->addGlobal('activeUder', false);
            $this->renderer->addGlobal('securityToken', false);
        }

        parent::viewRender($view, $variables, $layout);
    }
}
