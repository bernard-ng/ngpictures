<?php
namespace Ng\Core\Exception;

use \Exception;

class QueryException extends Exception
{
	public $msg;

	public function __construct()
	{
		parent::__construct();
		$this->msg = is_null($this->getMessage())? "impossible de faire une query" : $this->getMessage();
	}
}
