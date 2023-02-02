<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class Locale extends BaseField implements ValidateFieldsInterface
{
    use FieldsValidatorTrait;

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        $this->validatePattern(
            value: $value,
            pattern: "/^[a-zA-Z]{2}([\\\-_][a-zA-Z]{2})?$/"
        );
    }

    public function __construct($value)
    {
        parent::__construct('locale');
        $this->set($value);
    }
}