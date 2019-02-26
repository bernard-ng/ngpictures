<?php
namespace Application\Controllers;

use Glooby\Pexels\Client;
use Psr\Container\ContainerInterface;
use Framework\Managers\LogMessageManager;

class PexelsController extends Controller
{

    /**
     * l'instance de l'api pexels
     *
     * @var Client
     */
    private $pexels;


    /**
     * construction
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->pexels = $this->container->get(Client::class);
    }


    /**
     * query the photo grace a pexels
     *
     * @param string $query
     * @param integer $size
     * @param integer $page
     * @return null|array
     */
    public function search(string $query, $size = 20, $page = 1)
    {
        $query = $this->str->escape($query);
        try {
            $pexels = $this->pexels->search($query, $size, $page);
            return json_decode($pexels->getBody())->photos;
        } catch (\Exception $e) {
            LogMessageManager::register(__FILE__, $e);
            $this->flash->set('info', $this->flash->msg['files_pexels_failed']);
            return null;
        }
    }
}
