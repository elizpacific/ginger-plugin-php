<?php

namespace GingerPluginSdk\Exceptions;

use Exception;
use Throwable;

class OutOfPatternException extends Exception
{
    public function __construct($property)
    {
        $message = sprintf('Property `%s` is out of the pattern.', $property);
        parent::__construct($message);
    }
}