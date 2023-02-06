<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class Country extends BaseField implements ValidateFieldsInterface
{
    use FieldsValidatorTrait;

    public function __construct($value)
    {
        parent::__construct("country");
        $this->set($value);
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        $this->validatePattern(
            value: $value,
            pattern: "/^[a-zA-Z]{2}$/"
        );
    }
}