<?php

namespace GingerPluginSdk\Bases;

use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

abstract class BaseField
{
    private mixed $value;
    protected string $propertyName;
    protected array $enum;

    public function __construct($propertyName)
    {
        $this->propertyName = $propertyName;
    }

    final public function set($value): BaseField
    {
        if ($this instanceof ValidateFieldsInterface) $this->validate($value);
        $this->value = $value;
        return $this;
    }

    final public function get()
    {
        return $this->value;
    }

    final public function getPropertyName(): string
    {
        return $this->propertyName;
    }
}