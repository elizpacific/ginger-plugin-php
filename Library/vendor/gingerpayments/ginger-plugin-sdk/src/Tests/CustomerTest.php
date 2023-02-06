<?php

declare(strict_types=1);

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\Customer;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function setUp(): void
    {
        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
    }

    public function test_to_array()
    {
        self::assertEqualsCanonicalizing(
            expected: [
                'additional_addresses' => [
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
                ],
                'email' => 'tutunikssa@gmail.com',
                'birthdate' => '1999-09-01',
                'merchant_customer_id' => '15',
                'country' => 'NL',
                'locale' => 'Ua_ua',
                'ip_address' => '173.0.2.5',
                'phoneNumbers' => [
                    '666666666',
                ],
                'gender' => 'male',
                'first_name' => 'Alexander',
                'last_name' => 'Tiutiunnyk',
            ],
            actual: OrderStub::getValidCustomer()->toArray()
        );
    }

    public function test_get_property()
    {
        self::assertSame(
            OrderStub::getValidCustomer()->getPropertyName(),
            'customer'
        );
    }

    public function test_update_customer()
    {
        $customer = OrderStub::getValidCustomer();
        self::assertSame(
            expected: array_replace(
                $customer->toArray(),
                [
                    'name' => 'Olha'
                ]
            ),
            actual: $customer->update(name: 'Olha')->toArray()
        );
    }

    public function test_get_first_name()
    {
        self::assertSame(
            expected: 'Alexander',
            actual: OrderStub::getValidCustomer()->getFirstName()->get()
        );
    }

    public function test_get_last_name()
    {
        self::assertSame(
            expected: 'Tiutiunnyk',
            actual: OrderStub::getValidCustomer()->getLastName()->get()
        );
    }

    public function test_get_email_address()
    {
        self::assertSame(
            expected: 'tutunikssa@gmail.com',
            actual: OrderStub::getValidCustomer()->getEmailAddress()->get()
        );
    }

    public function test_get_birthdate()
    {
        self::assertSame(
            expected: '1999-09-01',
            actual: OrderStub::getValidCustomer()->getBirthdate()->get()
        );
    }

    public function test_get_gender()
    {
        self::assertSame(
            expected: 'male',
            actual: OrderStub::getValidCustomer()->getGender()->get()
        );
    }

    public function test_get_locale()
    {
        self::assertSame(
            expected: 'Ua_ua',
            actual: OrderStub::getValidCustomer()->getLocale()->get()
        );
    }

    public function test_get_ipaddress()
    {
        $_SERVER['REMOTE_ADDR'] = '123';
        self::assertSame(
            expected: '123',
            actual: OrderStub::getValidCustomer()->getIpAddress()->get()
        );
    }

    public function test_get_merchant_customer_id()
    {
        self::assertSame(
            expected: '15',
            actual: OrderStub::getValidCustomer()->getMerchantCustomerId()->get()
        );
    }

    public function test_get_phone_numbers()
    {
        self::assertSame(
            expected: [
                '666666666'
            ],
            actual: OrderStub::getValidCustomer()->getPhoneNumbers()->getAll()
        );
    }
}
