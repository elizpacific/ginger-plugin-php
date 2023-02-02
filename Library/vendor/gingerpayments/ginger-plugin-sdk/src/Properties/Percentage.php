<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\HelperTrait;


/**
 * This property is for sdk-use only.
 * Property contains float values which represent raw percentage value.
 * For example item vat percentage is 20% the API is waiting for 2000 value, but users want to give responsibilities for any converting to the sdk,
 * The Percentage is perfect fit. User could put raw value into constructor and get converted vat_percentage value.
 *
 */
final class Percentage extends BaseField
{
    use HelperTrait;

    public function __construct(float $value)
    {
        $this->set($this->calculateValueInCents($value));
        parent::__construct('');
    }

    public function __toString(): string
    {
        return $this->get();
    }
}