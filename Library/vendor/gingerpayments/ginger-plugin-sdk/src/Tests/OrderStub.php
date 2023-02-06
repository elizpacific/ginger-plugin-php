<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Collections\AdditionalAddresses;
use GingerPluginSdk\Collections\OrderLines;
use GingerPluginSdk\Collections\PhoneNumbers;
use GingerPluginSdk\Collections\Transactions;
use GingerPluginSdk\Entities\Address;
use GingerPluginSdk\Entities\Customer;
use GingerPluginSdk\Entities\Extra;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Entities\PaymentMethodDetails;
use GingerPluginSdk\Entities\Transaction;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Birthdate;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Country;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\EmailAddress;
use GingerPluginSdk\Properties\Locale;
use GingerPluginSdk\Properties\Percentage;
use GingerPluginSdk\Properties\RawCost;
use GingerPluginSdk\Properties\VatPercentage;

class OrderStub
{
    public static function __callStatic(string $name, array $arguments)
    {
        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
    }

    static function getMockedClientOptions(): ClientOptions
    {
        return new ClientOptions(
            endpoint: $_ENV['PUBLIC_API_URL'],
            useBundle: true,
            apiKey: getenv('GINGER_API_KEY')
        );
    }

    static function getValidAdditionalAddresses(): AdditionalAddresses
    {
        return new AdditionalAddresses(
            self::getValidCustomerAddress(),
            self::getValidBillingAddress()
        );
    }

    static function getValidCustomerAddress(): Address
    {
        return new Address(
            addressType: 'customer',
            postalCode: '12345',
            country: new Country(
                'UA'
            ),
            street: 'Soborna',
            city: 'Poltava'
        );
    }

    static function getValidBillingAddress(): Address
    {
        return new Address(
            addressType: 'billing',
            postalCode: '1234567',
            country: new Country(
                'NL'
            ),
            street: 'Donauweg',
            city: 'Amsterdam',
            housenumber: "10"
        );
    }

    static function getValidCustomer(): Customer
    {
        return new Customer(
            additionalAddresses: self::getValidAdditionalAddresses(),
            firstName: 'Alexander',
            lastName: 'Tiutiunnyk',
            emailAddress: new EmailAddress(
                'tutunikssa@gmail.com'
            ),
            gender: 'male',
            phoneNumbers: new PhoneNumbers(
                '666666666'
            ),
            birthdate: new Birthdate('1999-09-01'),
            locale: new Locale(
                'Ua_ua'
            ),
            merchantCustomerId: '15'
        );
    }

    static function getValidOrder(): Order
    {
        return new Order(
            currency: new Currency('EUR'),
            amount: new Amount(500),
            transactions: self::getValidTransactions(),
            customer: self::getValidCustomer(),
            orderLines: self::getValidOrderLines(),
            extra: self::getValidExtra(),
            client: self::getValidClient(),
            description: 'GingerPluginSDKAutomaticTest'
        );
    }

    static function getValidClient(): \GingerPluginSdk\Entities\Client
    {
        return new \GingerPluginSdk\Entities\Client(
            userAgent: $_SERVER['HTTP_USER_AGENT'],
            platformName: 'PHPSTORM',
            platformVersion: '1',
            pluginName: 'ginger-plugin-sdk',
            pluginVersion: '1.0.0'
        );
    }

    static function getValidTransactions(): Transactions
    {
        return new Transactions(
            self::getValidTransaction()
        );
    }

    static function getValidTransaction(): Transaction
    {
        return new Transaction(
            paymentMethod: 'ideal',
            paymentMethodDetails: self::getValidPaymentMethodDetails()
        );
    }

    static function getValidPaymentMethodDetails(): PaymentMethodDetails
    {
        return new PaymentMethodDetails(
            issuer_id: "15"
        );
    }

    static function getValidExtra(): Extra
    {
        return new Extra(
            ['sw_order_id' => "501"]
        );
    }

    static function getValidOrderLines(): OrderLines
    {
        return new OrderLines(
            self::getValidLine()
        );
    }

    static function getValidLine(): Line
    {
        return new Line(
            type: 'physical',
            merchantOrderLineId: "5",
            name: 'Milk',
            quantity: 1,
            amount: new Amount(new RawCost(1.00)),
            vatPercentage: new VatPercentage(new Percentage(50)),
            currency: new Currency(
                'EUR'
            )
        );
    }
}