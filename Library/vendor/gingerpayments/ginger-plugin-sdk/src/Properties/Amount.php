<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

/**
 * Amount describes cost of item or order and multiplied by 100.
 *
 * Validation for Amount value is to be greater than 1.
 */
final class Amount extends BaseField implements ValidateFieldsInterface
{
    use FieldsValidatorTrait;

    private string $property_name = 'amount';

    /**
     * User could initialize amount property by 2 ways :
     * 1. Using value in cents, in this case user should only provide integer value into constructor.
     * 2. Using RawCost property, in this case user should firstly initialize RawCost property and after provide it to a constructor.
     * Different between 1 and 2 case in the fact, that RawCost property will be firstly converted to a value in cents.
     *
     * @param RawCost|int $value
     */
    public function __construct(RawCost|int $value)
    {
        $value = (string)$value;
        $this->set((int)$value);
        parent::__construct($this->property_name);
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\OutOfDiapasonException
     */
    public function validate($value)
    {
        if ($value < 1) throw new OutOfDiapasonException(
            propertyName: $this->property_name,
            value: $value,
            min: 1);
    }
}