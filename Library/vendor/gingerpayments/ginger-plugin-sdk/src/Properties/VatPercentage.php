<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Helpers\FieldsValidatorTrait;
use GingerPluginSdk\Helpers\HelperTrait;
use GingerPluginSdk\Interfaces\ValidateFieldsInterface;

/**
 * Vat percentage describes percentage of the vat tax multiplied by 100.
 *
 * Validation for Percentage value is to be greater than 1 and less than 100
 */
final class VatPercentage extends BaseField implements ValidateFieldsInterface
{
    use HelperTrait;
    use FieldsValidatorTrait;

    protected string $propertyName = 'vat_percentage';

    /**
     * User could initialize vat percentage property by 2 ways :
     * 1. Using value multiplied by 100 (to avoid float values), in this case user should only provide integer value into constructor.
     * 2. Using Percentage property, in this case user should firstly initialize Percentage property and after provide it to a constructor.
     * Different between 1 and 2 case in the fact, that Percentage property will be firstly converted to integer using 100 multiply.
     *
     * @param RawCost|int $value
     */
    public function __construct(Percentage|int $value)
    {
        $value = (string)$value;
        $this->set((int)$value);
        parent::__construct($this->propertyName);
    }

    public function validate($value)
    {
        if ($value < 0 || $value > 10000) throw new OutOfDiapasonException(
            propertyName: $this->propertyName,
            value: $value,
            min: 0,
            max: 10000);
    }
}