<?php
namespace Ng\Core\Managers;

use Ng\Core\Interfaces\SessionInterface;
use Ng\Core\Traits\SingletonTrait;
use Ngpictures\Managers\MessageManager;

class FlashMessageManager
{
    /**
     * la session
     * @var SessionInterface
     */
    private $session;

    /**
     * les message
     * @var MessageManager
     */
    private $msg;


    /**
     * Flash constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session, MessageManager $msg)
    {
        $this->session  = $session;
        $this->msg      = $msg;
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
