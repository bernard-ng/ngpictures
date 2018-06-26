<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;
use Psr\Container\ContainerInterface;
use Ng\Core\Interfaces\SessionInterface;
use Ngpictures\Services\Auth\DatabaseAuthService;
use Ng\Core\Controllers\Controller as SuperController;


class Controller extends SuperController
{
    protected $msg;
    protected $flash;
    protected $session;
    protected $pageManager;
    protected $authService;

    /**
     * construction
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->app              =   $this->container->get(Ngpictures::class);
        $this->authService      =   $this->container->get(DatabaseAuthService::class);
        $this->pageManager      =   $this->container->get(PageManager::class);
        $this->session          =   $this->container->get(SessionInterface::class);

        if(!$this->authService->isLogged()) {
            $this->authService->cookieConnect();
        }

        $this->renderer->addGlobal('pageManager', $this->pageManager);
        $this->renderer->addGlobal('sessionManager', $this->session);
        $this->renderer->addGlobal('flashMessageManager', $this->flash);
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
        //$variables['verse']                 =   $this->callController('verses')->index();

        if ($this->authService->isLogged()) {
            $variables['activeUser']        =   $this->session->read(AUTH_KEY);
            $variables['securityToken']     =   $this->session->read(TOKEN_KEY);

            $this->pageManager::setMeta(['active-user' => $this->session->getValue(AUTH_KEY, 'id')]);
            $this->pageManager::setMeta(['active-token' => $this->session->read(TOKEN_KEY)]);
        } else {
            $variables['activeUser']        =   false;
            $variables['securityToken']     =   false;
        }

        parent::viewRender($view, $variables, $layout);
    }
}
