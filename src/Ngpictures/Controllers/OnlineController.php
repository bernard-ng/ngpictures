<?php
namespace Ngpictures\Controllers;

use Psr\Container\ContainerInterface;


class OnlineController extends Controller
{
    private $number = null;
    private $users = null;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct($container);
        $this->loadModel('online');
    }

    public function index(int $id)
    {
        $now = date("U");
        $session_time = $now - 15;

        $users_id = $id;
        $isOnline = $this->online->findWith('users_id', $id);

        if (!$isOnline) {
            $this->online->create(
                ["users_id" => $users_id, "online_time" => $now]
            );
        } else {
            $this->online->update(
                $users_id,
                ["time" => $now]
            );
        }

        $this->online->delete($session_time);
    }
}
