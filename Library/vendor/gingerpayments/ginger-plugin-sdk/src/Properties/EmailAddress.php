<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class EmailAddress extends BaseField implements ValidateFieldsInterface
{
    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new OutOfPatternException($this->getPropertyName());
        }
    }

    public function __construct($value)
    {
        parent::__construct('email_address');
        $this->set($value);
    }
}