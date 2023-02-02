<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

final class Currency extends BaseField implements ValidateFieldsInterface
{
    use FieldsValidatorTrait;

    public function __construct($value)
    {
        $this->propertyName = 'currency';
        $this->set($value);
        parent::__construct('currency');
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validate($value)
    {
        $this->validatePattern(
            value: $value,
            pattern: "/[A-Z]{3}/"
        );
    }
}