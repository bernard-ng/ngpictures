<?php
namespace Ngpictures\Traits\Util;


trait RequestTrait
{
    /**
     * gestion de redirection
     * @param string|null|bool $url
     * @param bool $ajax
     * @param int $code de redirection.
     */
    public function redirect($url = null, $ajax = false, int $code = 200)
    {
        if (is_bool($url)) {
            if (!empty($_SERVER['HTTP_REFERER'])) {
                http_response_code($code);
                header("location:{$_SERVER['HTTP_REFERER']}");
                exit();
            } else {
                http_response_code($code);
                header('location:/');
                exit();
            }
        } else {
            if ($this->isAjax() && $ajax === true) {
                echo $url;
                exit();
            }
            http_response_code($code);
            is_null($url) ? header('location:/') : header("location:{$url}");
            exit();
        }
    }


    /**
     * gestion de turbolinks
     * @param string $name nom de la routes, location
     */
    public function turbolinksLocation(string $name)
    {
        header("Turbolinks-Location: {$name}");
    }


    /**
     * defini si la request est faite en ajax
     *
     * @return boolean
     */
    public function isAjax() : bool
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') ? true : false;
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
