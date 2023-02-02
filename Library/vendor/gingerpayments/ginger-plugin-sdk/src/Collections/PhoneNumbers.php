<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Bases\BaseField;
use GingerPluginSdk\Helpers\SingleFieldTrait;

final class PhoneNumbers extends AbstractCollection
{
    use SingleFieldTrait;

    const ITEM_TYPE = 'String';

    /**
     * @param string ...$numbers
     */
    public function __construct(string ...$numbers)
    {
        $this->propertyName = 'phone_numbers';

        foreach ($numbers as $number) {
            $this->add($number);
        }

        parent::__construct('phone_numbers');
    }

    /**
     * @param string $number
     * @return $this
     */
    public function addPhoneNumber(string $number): PhoneNumbers
    {
        $this->add($number);
        return $this;
    }

    /**
     * @param int $index
     * @return $this
     */
    public function removePhoneNumber(int $index): PhoneNumbers
    {
        $this->remove($index);
        return $this;
    }

    /**
     * @param string $number
     * @param null $index
     * @return $this
     */
    public function updatePhoneNumber(string $number, $index = null)
    {
        $this->update($number, $index);
        return $this;
    }
}