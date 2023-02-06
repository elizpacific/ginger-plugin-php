<?php

namespace GingerPluginSdk\Exceptions;

use Exception;


class OutOfEnumException extends Exception
{
     public function __construct($key, $real_value, $expected_value)
    {
        $message = sprintf("{%s}: `%s` is not one of %s", $key, $real_value, $expected_value);
        parent::__construct($message);
    }
}