<?php

namespace GingerPay\Payment\Tests;

require_once __DIR__.'/ClassSeparators/RecurringBuilderSeparator.php';
require_once  __DIR__.'/ClassSeparators/ConfigRepositoryBuilderSeparator.php';

use GingerPay\Payment\Tests\ClassSeparators\RecurringBuilderSeparator;
use GingerPay\Payment\Tests\Mocks\Order;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Currency;
use PHPUnit\Framework\TestCase;
use GingerPay\Payment\Tests\ClassSeparators\CreditcardSeparator as Creditcard;
use GingerPay\Payment\Tests\ClassSeparators\ConfigRepositoryBuilderSeparator;
use GingerPluginSdk\Tests\OrderStub;
use GingerPluginSdk\Tests\CreateOrderTest as CreateOrder;

class RecurringBuilderTest extends TestCase
{
    private $recurringBuilder;
    private $order;
    private $configRepository;
    private $expectedArray;

    public function setUp() : void
    {
        $this->order = new OrderStub();
        $this->recurringBuilder = new RecurringBuilderSeparator();
        $this->configRepository = new ConfigRepositoryBuilderSeparator();

        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";

        $this->expectedArray = array(
            "currency" => new Currency('EUR'),
            "amount" => new Amount(500),
            "merchant_order_id" => 638,
            "customer"  => $this->order->getValidCustomer(),
            "description" => "Your order 638 at Your order %id% at %name%",
            "return_url" => 'http://test.com/return',
            "transactions" => $this->order->getValidTransactions(),
            "extra" => $this->order->getValidExtra(),
            "order_lines" => $this->order->getValidOrderLines(),
            "webhook_url" => "https://magento2.test/ginger/checkout/webhook/"
        );
    }

    public function testIsOrderForRecurring()
    {
        $this->assertTrue($this->recurringBuilder->isOrderForRecurring($this->order), 'It should be true. False returned');
    }

    public function testCancelRecurringOrderSuccess()
    {
        $this->assertEquals('success', $this->recurringBuilder->cancelRecurringOrder($this->order->getGingerpayTransactionId()), 'Unexpected result');
    }

    public function testCancelRecurringOrderFalse()
    {
        $this->assertFalse($this->recurringBuilder->cancelRecurringOrder(null), 'Unexpected result');
    }

    public function testGetAddressArray()
    {
        $expectedResult = [
            'firstname' => "Jon",
            'lastname' => "Lastname",
            'prefix' => "Prefix",
            'suffix' => "Suffix",
            'street' => "Street",
            'city' => "City",
            'country_id' => "CountryId",
            'region' => "Region",
            'region_id' => "RegionId",
            'postcode' => "Postcode",
            'telephone' => "0505869999",
            'fax' => "Fax",
            'save_in_address_book' => 1
        ];

        $this->assertEquals($expectedResult, $this->recurringBuilder->helperDataBuilder->getAddressArray($this->order->getBillingAddress()), 'Unexpected array is given');
    }

    public function testCreateOrder()
    {
        $this->assertEquals($this->order, $this->recurringBuilder->createOrder($this->order), 'Wrong order object returned');
    }

    public function testPrepareGingerOrder()
    {
        $this->assertEquals($this->expectedArray, $this->recurringBuilder->prepareGingerOrder($this->order), '');

    }

}
