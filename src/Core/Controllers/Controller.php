<?php
namespace Ng\Core\Controllers;

use Ng\Core\Renderer\TwigRenderer;


class Controller
{
    protected $viewPath;
    protected $layout;
    protected $renderer;


    public function __construct()
    {
        $this->renderer = new TwigRenderer();
    }


    /**
     * rendu de la vue
     * @param string $view
     * @param array $variables
     * @return mixed
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function viewRender(string $view, array $variables = [])
    {
        return $this->renderer->render($view, $variables);
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
