<?php
namespace Ng\Core\Managers;

use Ng\Core\Traits\SingletonTrait;

class FlashMessageManager
{

    use SingletonTrait;
    private $session = null;


    /**
     * Flash constructor.
     * @param Session $session
     */
    public function __construct(SessionManager $session)
    {
        $this->session = $session;
    }


    /**
     * @param string $type
     * @param string $message
     */
    public function set(string $type, string $message)
    {
        $_SESSION[FLASH_MESSAGE_KEY][$type] = $message;
    }


    /**
     * @return mixed
     */
    public function get()
    {
        $flashes = $_SESSION[FLASH_MESSAGE_KEY];
        $this->session->delete(FLASH_MESSAGE_KEY);
        return $flashes;
    }


    /**
     * @return bool
     */
    public function has(): bool
    {
        return isset($_SESSION[FLASH_MESSAGE_KEY]);
    }
}
