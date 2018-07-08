<?php
namespace Ng\Core\Managers;

use Ng\Core\Interfaces\SessionInterface;
use Ng\Core\Traits\SingletonTrait;
use Ngpictures\Managers\MessageManager;
use Ngpictures\Traits\Util\RequestTrait;

class FlashMessageManager
{

    use RequestTrait;

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
    public function __construct(SessionInterface $session, MessageManager $msg)
    {
        $this->session  = $session;
        $this->msg      = $msg;
    }


    /**
     * @param string $type
     * @param string $message
     * @param int|null|bool $code
     */
    public function set(string $type, string $message, $code = null)
    {
        if ($this->isAjax() && $code !== false) {
            if (is_null($code)) {
                switch ($type) {
                    case 'danger':
                        $code = 500;
                        break;
                    case 'warning' || 'success' || 'info':
                        $code = 200;
                        break;
                    default:
                        $code = 200;
                        break;
                }
            }
            $this->setFlash($message, $code);
        } else {
            $_SESSION[FLASH_MESSAGE_KEY][$type] = $message;
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
