<?php

namespace GingerPluginSdk\Collections;

use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Address;

class AdditionalAddresses extends AbstractCollection
{
    const ITEM_TYPE = Address::class;
    public function __construct(Address ...$addresses)
    {
        $this->propertyName = 'additional_addresses';
        foreach ($addresses as $address) {
            $this->add($address);
        }
        parent::__construct($this->propertyName);
    }

    public function addAddress(Address $address): AdditionalAddresses
    {
        $this->add($address);
        return $this;
    }

    public function removeAddress($index): AdditionalAddresses
    {
        $this->remove($index);
        return $this;
    }
}