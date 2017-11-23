<?php
namespace Core\Controller;


class Controller
{
    protected   $viewPath,
                $template;

    
    public function viewRender(string $view, array $variables = [], bool $template = true) 
    {
        ob_start();
        extract($variables);
        require ("{$this->viewPath}{$view}.php");
        $content = ob_get_clean();

        if ($template === true) {
            require ("{$this->viewPath}templates/{$this->template}.php");
        }
    }   
}
