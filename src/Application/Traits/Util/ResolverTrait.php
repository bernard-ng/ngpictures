<?php
namespace Application\Traits\Util;

trait ResolverTrait
{

    function model($name)
    {
        $namespace = "\\Application\\Repositories\\";
        $class      = ucfirst($name) . "Repository";
        return $namespace . $class;
    }

    function controller($name)
    {
        $namespace = "\\Application\\Controllers\\";
        $class = ucfirst($name) . "Controller";
        return $namespace . $class;
    }

    function entity($name)
    {
        $namespace = "\\Application\\Entities\\";
        $class = ucfirst($name) . "Entity";
        return $namespace . $class;
    }
}
