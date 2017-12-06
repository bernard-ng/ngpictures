<?php
namespace Ng\Core\Controllers;


class Controller
{
    protected   $viewPath,
                $layout;

    
    public function viewRender(string $view, array $variables = [], bool $layout = true) 
    {
        ob_start();
        extract($variables);
        require ("{$this->viewPath}{$view}.php");
        $content = ob_get_clean();

        if ($layout === true) {
            require ("{$this->viewPath}layout/{$this->layout}.php");
        }
    }   
}
