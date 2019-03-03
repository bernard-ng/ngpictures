<?php
namespace Framework\Router;

use Framework\Http\RequestAwareAction;

/**
 * Class RouterAwareAction
 * @package Framework\Router
 */
trait RouterAwareAction
{

    /**
     * la request server actuelle.
     */
    use RequestAwareAction;


    /**
     * recupere une instance du router et on definit les routes.
     * @return Router
     */
    private function getRouter()
    {
        $router = new Router();
        (require ROOT."/config/routes/frontend.php")($router);
        (require ROOT."/config/routes/backend.php")($router);
        return $router;
    }


    /**
     * genere une erreur 404
     */
    public function redirect404()
    {
        $request = $this->getRequest();

        if ($request->ajax()) {
            http_response_code(404);
            exit();
        } else {
            http_response_code(404);
            echo "<h1>Not Found with redirect 404</h1>";
            exit();
        }
    }

    /**
     * @param string|null $url
     */
    public function redirect(?string $url = null)
    {
        $request = $this->getRequest();

        if (!is_null($url)) {
            if ($request->get('http.referer')) {
                header("Location: {$request->get('http.referer')}", true, 301);
                exit();
            } else {
                header("Location: /", true, 301);
                exit();
            }
        } else {
            header("Location: /{$url}", true, 301);
            exit();
        }
    }

    /**
     * @param string $route
     * @param array $param
     */
    public function route(string $route, array $param = [])
    {
        $url = $this->getRouter()->url($route, $param);
        $this->redirect($url);
    }

    /**
     * @param string $route
     * @param array $param
     * @return string
     */
    public function url(string $route, array $param = []) : string
    {
        return "/" . $this->getRouter()->url($route, $param);
    }
}
