<?php
namespace Ng\Core\Exception;

use \Exception;

class PrepareException extends Exception
{
    public function __construct()
    {
        parent::__construct();
        $this->msg = is_null($this->getMessage())? "impossible de faire un prepare" : $this->getMessage();
    }
}
