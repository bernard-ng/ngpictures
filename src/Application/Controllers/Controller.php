<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Application\Controllers;

use Application\Auth\DatabaseAuth;
use Application\Managers\MessageManager;
use Application\Managers\PageManager;
use Framework\Controllers\Controller as FrameworkController;
use Framework\Interfaces\SessionInterface;
use Framework\Managers\FlashMessageManager;

use Psr\Container\ContainerInterface;

/**
 * Class Controller
 * @package Application\Controllers
 */
class Controller extends FrameworkController
{

    /**
     * @var SessionInterface|mixed
     */
    protected $session;

    /**
     * @var FlashMessageManager
     */
    protected $flash;

    /**
     * @var DatabaseAuth|mixed
     */
    protected $auth;

    /**
     * Controller constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->session = $container->get(SessionInterface::class);
        $this->flash = $container->get(FlashMessageManager::class);
        $this->auth = $container->get(DatabaseAuth::class);
    }

    /**
     * @param string $view
     * @param array $variables
     * @return mixed|void
     */
    public function view(string $view, array $variables = [])
    {
        $this->renderer->addGlobal('page', new PageManager());
        $this->renderer->addGlobal('flash', $this->flash);
        parent::view($view, $variables);
    }


    /**
     * check if a user logged
     */
    protected function loggedOnly()
    {
        $user = $this->auth->getUser();
        if (is_null($user)) {
            $this->flash->error('login');
            $this->route('auth.login');
        }
    }

    protected function notFound()
    {
        $error = $this->container->get(ErrorController::class);
        return $error->e404();
    }
}
