<?php
namespace Ngpictures\Controllers;

use Ngpictures\Ngpictures;
use Ngpictures\Managers\PageManager;

class OnlineController extends Controller
{
    private $number = null;
    private $users = null;

    public function __construct(Ngpictures $app, PageManager $pageManager)
    {
        parent::__construct($app, $pageManager);
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
