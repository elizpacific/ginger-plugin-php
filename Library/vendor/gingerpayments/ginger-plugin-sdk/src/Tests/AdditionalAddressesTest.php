<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Collections\AdditionalAddresses;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Properties\Locale;
use PHPUnit\Framework\TestCase;

class AdditionalAddressesTest extends TestCase
{

    public function test_invalid_type_address()
    {
        self::expectException(\TypeError::class);
        $test = new AdditionalAddresses(
            new Locale(
                'NL_be'
            )
        );
    }

    public function test_to_array()
    {
        $expected_array = [

            [
                'address_type' => 'customer',
                'postal_code' => '12345',
                'country' => 'UA',
                'city' => 'Poltava',
                'street' => 'Soborna',
                'address' => 'Soborna 12345 Poltava'
            ],
            [
                'address_type' => 'billing',
                'postal_code' => '1234567',
                'country' => 'NL',
                'city' => 'Amsterdam',
                'street' => 'Donauweg',
                'address' => 'Donauweg 10 1234567 Amsterdam',
                'housenumber' => '10'
            ]
        ];
        $real = OrderStub::getValidAdditionalAddresses()->toArray();
        sort($expected_array);
        sort($real);
        self::assertSame(
            expected: $expected_array,
            actual: $real
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            expected: 'additional_addresses',
            actual: OrderStub::getValidAdditionalAddresses()->getPropertyName()
        );
    }

    public function test_update_additional_addresses()
    {
        self::assertSame(
            expected: array_replace(
                OrderStub::getValidAdditionalAddresses()->toArray(),
                [
                    OrderStub::getValidCustomerAddress()->update(city: 'Kharkiv')->toArray()
                ]
            ),
            actual: OrderStub::getValidAdditionalAddresses()->update(['city' => 'Kharkiv'], 0)->toArray()
        );
    }

    public function test_add_address()
    {
        $additional_addresses = new AdditionalAddresses();
        $address = new Address(
            addressType: 'customer',
            postalCode: '1',
            country: new Country('UA')
        );
        self::assertSame(
            expected: [
                'address_type' => 'customer',
                'postal_code' => '1',
                'country' => 'UA',
                'address' => '1'
            ],
            actual: $additional_addresses->addAddress($address)->get()->toArray()
        );
    }

    public function test_remove_address()
    {
        $additional_addresses = new AdditionalAddresses(OrderStub::getValidCustomerAddress());
        $additional_addresses->addAddress(
            new Address(
                addressType: 'customer',
                postalCode: '1',
                country: new Country('UA')
            )
        );
        self::assertSame(
            expected: [
                'address_type' => 'customer',
                'postal_code' => '1',
                'country' => 'UA',
                'address' => '1'
            ],
            actual: $additional_addresses->removeAddress(0)->get()->toArray()
        );
    }
}
