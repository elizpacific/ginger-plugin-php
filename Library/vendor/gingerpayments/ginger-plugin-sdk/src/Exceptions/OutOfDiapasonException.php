<?php

namespace GingerPluginSdk\Exceptions;

use Exception;
use Throwable;

final class OutOfDiapasonException extends Exception
{
     public function __construct($propertyName, $value, $min, $max = null)
    {
        $message = sprintf('Value of the property `%s` out of diapason, the input value is %s : should be greater than %s', $propertyName, $value, $min);
        $message .= $max ? sprintf(", and less then %s.", $max) : '.';
        parent::__construct($message);
    }
}