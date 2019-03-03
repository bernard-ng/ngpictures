<?php
namespace Framework\Http;

use Application\Managers\PageManager;

/**
 * Class RequestAwareAction
 * @package Framework\Http
 */
trait RequestAwareAction
{
    /**
     * l'instance de la request.
     * @var ServerRequest;
     */
    private $currentRequest;


    /**
     * permet d'avoir access a la request.
     * @return ServerRequest
     */
    public function getRequest()
    {
        $this->currentRequest = new ServerRequest();
        return $this->currentRequest;
    }


    public function redirect($url = null, $ajax = false, int $code = 200)
    {
        $request = $this->getRequest();
        if (empty($url)) {
            if ($request->get('http.referer')) {
                header("Location: {$request->get('http.referer')}", true, 301);
                if ($this->getRequest()->ajax() && $ajax === true) {
                    echo "/";
                    exit();
                }
                exit();
            } else {
                $url = SITE_NAME;
                if ($this->getRequest()->ajax() && $ajax === true) {
                    echo $url;
                    exit();
                }
                header("Location: {$url}", true, 301);
                exit();
            }
        } else {
            if ($this->getRequest()->ajax() && $ajax === true) {
                echo $url;
                exit();
            }

            $url = SITE_NAME . "/{$url}";
            header("Location: {$url}", true, 301);
            exit();
        }
    }


    /**
     * gestion de turbolinks
     * @param string $name nom de la routes, location
     */
    public function turbolinksLocation(string $name)
    {
        PageManager::setUrl($name);
        header("Turbolinks-Location: {$name}");
    }


    /**
     * en cas d'erreur en ajax
     * @param string $msg
     * @param int|null $code
     */
    public function setFlash(string $msg, int $code = null)
    {
        if (is_null($code)) {
            header('HTTP/1.1 500 Internal Server Error');
        } else {
            http_response_code($code);
        }
        echo $msg;
        exit();
    }
}
