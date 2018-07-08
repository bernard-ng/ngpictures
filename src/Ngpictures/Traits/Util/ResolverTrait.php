<?php
namespace Ngpictures\Traits\Util;


trait ResolverTrait {

    function model($name)
    {
        $namespace = "\\Ngpictures\\Models\\";
        $class      = ucfirst($name) . "Model";
        return $namespace . $class;
    }

    function controller($name)
    {
        $namespace = "\\Ngpictures\\Controllers\\";
        $class = ucfirst($name) . "Controller";
        return $namespace . $class;
    }

    function entity($name)
    {
        $namespace = "\\Ngpictures\\Entities\\";
        $class = ucfirst($name) . "Entity";
        return $namespace . $class;
    }
}
