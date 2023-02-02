<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;

final class Status extends BaseField
{
    use FieldsValidatorTrait;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->set($value);
        parent::__construct('status');
    }
}