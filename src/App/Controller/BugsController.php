<?php
namespace Ngpic\Controller;

use Core\Controller\Controller;

class BugsController extends NgpicController
{
    public function __construct()
    {
    	parent::__construct();
    	$this->callController('users')->restrict();
    }

    protected $table = "bugs";


    public function add()
    {

    }

    public function delete()
    {
    	$this->callController('users')->isAdmin();
    }


    public function index()
    {
    	$this->callController('users')->isAdmin();
    }
}