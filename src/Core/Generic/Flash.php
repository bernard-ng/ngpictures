<?php
namespace Ng\Core\Generic;


use Ng\Core\Traits\SingletonTrait;

class Flash
{

    use SingletonTrait;
	private $session = null;


    /**
     * Flash constructor.
     * @param Session $session
     */
	public function __construct(Session $session)
	{
		$this->session = $session;
	}


    /**
     * @param string $type
     * @param string $message
     */
	public function set(string $type, string $message)
	{
        $_SESSION[FLASH_KEY][$type] = $message;
    }


    /**
     * @return mixed
     */
	public function get()
	{
        $flashes = $_SESSION[FLASH_KEY];
        $this->session->delete('flash');
        return $flashes;
	}


    /**
     * @return bool
     */
	public function has(): bool
	{
        return isset($_SESSION[FLASH_KEY]);
	}
}
