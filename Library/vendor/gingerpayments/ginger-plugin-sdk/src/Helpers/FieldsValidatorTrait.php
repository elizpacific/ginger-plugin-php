<?php

namespace GingerPluginSdk\Helpers;

use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Exceptions\OutOfPatternException;

trait FieldsValidatorTrait
{
    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfEnumException
     */
    public function validateEnum($value)
    {
        if (isset($this->enum) && !in_array($value, $this->enum)) {
            throw new OutOfEnumException($this->getPropertyName(), $value, json_encode($this->enum));
        }
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfPatternException
     */
    public function validatePattern($value, $pattern)
    {
        if (!preg_match($pattern, $value)) {
            throw new OutOfPatternException($this->getPropertyName());
        }
    }
}