<?php
namespace Ng\Core\Generic;


class Ajax
{
    public function isAjax()
    {
        if (isset($_SERVER["X_REQUESTED_WITH"]) && strtolower($_SERVER["X_REQUESTED_WITH"]) = "xmlhttprequest") {
        	
            return true;
        }
        return false;
    }
}