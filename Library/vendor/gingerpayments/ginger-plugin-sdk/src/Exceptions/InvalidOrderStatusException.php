<?php

namespace GingerPluginSdk\Exceptions;

class InvalidOrderStatusException extends \Exception
{
    public function __construct($actual, $expected = null)
    {
        $message = sprintf("Status {%s} is not supported for this operation.", $actual);
        if ($expected) {
            $message .= sprintf(" Supported status is {%s}.", $expected);
        }
        parent::__construct($message);
    }
}