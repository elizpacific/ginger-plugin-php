<?php

namespace GingerPluginSdk\Properties;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\HelperTrait;

/**
 * This property is for sdk-use only.
 * Property contains float values which represent raw amount value.
 * For example item cost 2.49, the API is waiting for 249 value, but users want to give responsibilities for any converting to the sdk,
 * The RawCost is perfect fit. Users could put raw value into constructor and get value in cents.
 *
 */
final class RawCost extends BaseField
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