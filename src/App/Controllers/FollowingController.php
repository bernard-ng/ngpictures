<?php
namespace Ngpictures\Controllers;
use \Ngpic;


class FollowingController extends NgpicController
{
   
    public function __construct(){
        parent::__construct();
        //$this->callController('users')->islogged();
        $this->user_id = intval($this->session->getValue('auth','id'));
    }


    public function index($username, $id)
    {
        if ($this->user_id !== null) {
            $f = $this->LoadModel('following');
            $user = $this->users->find($id);

            if ($user) {
                if ($f->isFollowed($user->id, $this->user_id)) {
                    $f->remove($user->id, $this->user_id);
                }
                $f->add($user->id, $this->user_id);
            } else {
                $this->session->setFlash("warning", $this->msg['user_notFound']);
                Ngpic::redirect(true);
            }
        } else {
            $this->session->setFlash("warning", $this->msg['must_login']);
            Ngpic::redirect(true);
        }
    }
}
