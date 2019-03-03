<?php
/**
 * This file is a part of Ngpictures
 * (c) Bernard Ngandu <ngandubernard@gmail.com>
 *
 */

namespace Framework\Managers;

use Framework\Http\RequestAwareAction;
use Framework\Interfaces\SessionInterface;
use Application\Managers\MessageManager;


/**
 * Class FlashMessageManager
 * @package Framework\Managers
 */
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
    public $msg;


    /**
     * Flash constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session  = $session;
        $this->msg      = new MessageManager();
    }

    /**
     * @param string $type
     * @param string $message
     * @param bool $ajax
     * @param int $status
     */
    public function set(string $type, string $message, $ajax = false, $status = 200)
    {
        if ($ajax) {
            http_response_code($status);
            echo $this->msg[$message];
            die();
        } else {
            $_SESSION[FLASH_MESSAGE_KEY][$type] = $this->msg[$message];
        }
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
