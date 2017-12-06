<?php
namespace Ng\Core\Generic;


class Flash
{
	
	private $session = null;
	private static $instance = null;

	public function __construct(Session $session)
	{
		$this->session = $session;
	}


	public static function getInstance()
	{
		if (is_null(self::$instance)) {
			self::$instance = new self(Session::getInstance());
		}
		return self::$instance;
	}




	public function set(string $type, string $message)
	{
		return $this->session->setFlash($type,$message);
	}


	public function get(string $stype, string $message)
	{
		return $this->session->getFlashes();
	}


	public function has(): bool
	{
		return $this->session->hasFlashes();
	}
}