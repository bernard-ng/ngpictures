<?php
namespace Application\Controllers;

use Application\Managers\PageManager;
use Application\Repositories\UsersRepository;
use Psr\Container\ContainerInterface;

/**
 * Class CommunityController
 * @package Application\Controllers
 */
class CommunityController extends Controller
{

    /**
     * @var UsersRepository|mixed
     */
    private $users;

    /**
     * CommunityController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->users = $container->get(UsersRepository::class);
    }


    public function index()
    {
        $users = $this->users->getLatestConfirmed(10);
        $this->turbolinksLocation($this->url('community'));
        PageManager::setTitle("Communauté");
        PageManager::setDescription(
            "Rétrouvez la communauté de ngpictures, vos amis, les artistes et les passionnés
            de la photographie"
        );
        $this->view("frontend/community/community", compact('users'));
    }
}
