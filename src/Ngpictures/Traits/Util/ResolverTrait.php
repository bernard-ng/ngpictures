<?php
namespace Ngpictures\Traits\Util;


trait ResolverTrait {

    function model(string $name)
    {
        $namespace = "\\Ngpictures\\Models\\";
        $class      = ucfirst($name) . "Model";
        return $namespace . $class;
    }

    function controller(string $name)
    {
        $namespace = "\\Ngpictures\\Controllers\\";
        $class = ucfirst($name) . "Controller";
        return $namespace . $class;
    }

    function entity(string $name)
    {
        $namespace = "\\Ngpictures\\Entities\\";
        $class = ucfirst($name) . "Entity";
        return $namespace . $class;
    }
}
