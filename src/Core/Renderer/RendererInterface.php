<?php
namespace Ng\Core\Renderer;


interface RendererInterface
{

    /**
     * rendre une vue
     * @param string $view
     * @param array $variables
     * @return mixed
     */
    public function render(string $view, array $variables = []);


    /**
     * ajouter des variables global pour une vue
     * @param string $key
     * @param $value
     * @return mixed
     */
    public function addGlobal(string $key, $value);
}