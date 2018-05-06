<?php
namespace Ng\Core\Controllers;

class Controller
{
    protected $viewPath;
    protected $layout;


    /**
     * rendu de la vue
     * @param string $view
     * @param array $variables
     * @param boolean $layout
     */
    public function viewRender(string $view, array $variables = [], bool $layout = true)
    {
        ob_start();
        extract($variables);
        require("{$this->viewPath}{$view}.php");
        $page_content = ob_get_clean();

        if ($layout === true) {
            require("{$this->viewPath}layout/{$this->layout}.php");
        } else {
            echo $page_content;
        }
    }


    /**
     * defini si la request est faite en ajax
     *
     * @return boolean
     */
    public function isAjax(): bool
    {
        return (
            isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) ? true : false ;
    }


    /**
     * en cas d'erreur en ajax
     * @param string $msg
     * @param int|null $code
     */
    public function ajaxFail(string $msg, int $code = null)
    {
        if (is_null($code)) {
            header('HTTP/1.1 500 Internal Server Error');
        } else {
            http_response_code($code);
        }
        echo $msg;
        exit();
    }


    /**
     * renvoi a ajax l'url de redirction
     * @param string $url
     */
    protected function ajaxRedirect(string $url)
    {
        echo $url;
        exit();
    }
}
