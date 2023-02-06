<?php

namespace GingerPluginSdk\Exceptions;

use Throwable;

class RefundAlreadyDoneException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}
