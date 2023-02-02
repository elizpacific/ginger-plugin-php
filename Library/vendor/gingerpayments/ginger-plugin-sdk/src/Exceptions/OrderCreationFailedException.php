<?php

namespace GingerPluginSdk\Exceptions;

use Throwable;

class OrderCreationFailedException extends \Exception
{
    public string $reason, $customer_message;

    public function __construct($reason, $customer_message)
    {
        parent::__construct(
            sprintf('Failed to create an order, reason : %s', $reason));
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getCustomerMessage(): string
    {
        return $this->customer_message;
    }
}