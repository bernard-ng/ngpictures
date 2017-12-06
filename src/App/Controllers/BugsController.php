<?php
namespace Ngpictures\Controllers;


use Ngpictures\Ngpic;
use Ngpictures\Util\Page;


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