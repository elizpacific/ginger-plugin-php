<?php

namespace GingerPluginSdk\Exceptions;

use Throwable;

class RefundFailedException extends \Exception
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}