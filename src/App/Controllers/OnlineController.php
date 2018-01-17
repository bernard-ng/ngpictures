<?php
namespace Ngpictures\Controllers;


class OnlineController extends NgpicController
{
	private $number = null;
	private $users = null;

	public function __construct()
	{
	    parent::__construct();
		$this->loadModel('online');
	}

	public function index($id)
    {
        $now = date("U");
        $session_time = $now - 15;

        $user_id = $id;
        $isOnline = $this->online->findWith('user_id', $id);

        if (!$isOnline) {
            $this->online->create(
                ["user_id" => $user_id, "online_time" => $now]
            );
        } else{
            $this->online->update(
                $user_id, ["time" => $now]
            );
        }

        $this->online->delete($session_time);
    }

}
