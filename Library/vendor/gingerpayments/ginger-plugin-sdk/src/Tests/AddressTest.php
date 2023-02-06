<?php
declare(strict_types=1);

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Exceptions\OutOfEnumException;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Helpers\SingleFieldTrait;
use PHPUnit\Framework\TestCase;
use TypeError;

class AddressTest extends TestCase
{
    private Address $address;

    public function setUp(): void
    {
        $this->address = new Address(
            addressType: "customer",
            postalCode: "38714",
            country: new Country(
                "UA"
            ),
            street: "Soborna",
            city: "Poltava"
        );
    }

    public function test_address_type_invalid_enumeration_exception()
    {
        self::expectException(OutOfEnumException::class);
        $super_test_address = new Address(
            addressType: "rabotiaga",
            postalCode: "38714",
            country: new Country(
                "UA"
            ),
            street: "Soborna",
            city: "Poltava"
        );
    }

    public function test_country_pattern_exception()
    {
        self::expectException(OutOfPatternException::class);
        $super_test_address = new Address(
            addressType: "customer",
            postalCode: "38714",
            country: new Country('NIGERIA'),
            street: "Soborna",
            city: "Poltava"
        );
    }

    public function test_invalid_types_constructor_exception()
    {
        self::expectException(TypeError::class);
        new Address(
            addressType: "customer", postalCode: "38714", country: 4, street: "Red", city: "Amsterdam"
        );
    }


    public function test_set_housenumber()
    {
        $expected = $this->createSimpleField(
            propertyName: 'housenumber',
            value: "30"
        );

        $this->address->setHousenumber("30");
        self::assertSame($this->address->getHousenumber(), $expected->get());

    }

    public function test_set_housenumber_updates_address_line()
    {
        $base_housenumber = $this->address->getAddressLine();
        $this->address->setHousenumber("30");
        self::assertNotSame($base_housenumber, $this->address->getAddressLine());
    }

    use SingleFieldTrait;

    public function test_toArray()
    {
        $expected = ["address_type" => "customer",
            "postal_code" => "38714",
            "country" => "UA",
            "city" => "Poltava",
            "street" => "Soborna",
            "address" => "Soborna 30 38714 Poltava",
            "housenumber" => "30"
        ];
        $this->address->setHousenumber("30");
        $real = $this->address->toArray();
        self::assertSame($expected, $real);
    }

    public function test_get_property()
    {
        self::assertSame(
            $this->address->getPropertyName(),
            ''
        );
    }

    public function test_update_address()
    {
        $address = OrderStub::getValidCustomerAddress();
        self::assertSame(
            expected: array_merge(
                $address->toArray(),
                ['city' => 'Kharkiv']
            ),
            actual: $address->update(city: 'Kharkiv')->toArray()
    );
    }

    public function test_get_address_type()
    {
        $address = OrderStub::getValidBillingAddress();
        self::assertSame(
            expected: 'billing',
            actual: $address->getAddressType()->get()
        );
    }
}