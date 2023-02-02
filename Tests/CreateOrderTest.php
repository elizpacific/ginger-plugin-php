<?php

namespace GingerPay\Payment\Tests;

require_once __DIR__.'/Loader/Conector.php';
require_once  __DIR__.'/ClassSeparators/ServiceOrderBuilderSeparator.php';
require_once  __DIR__.'/ClassSeparators/ConfigRepositoryBuilderSeparator.php';
require_once  __DIR__.'/Mocks/Order.php';
require_once  __DIR__.'/Mocks/UrlProvider.php';
require_once  __DIR__.'/Mocks/OrderLines.php';
require_once  __DIR__.'/Mocks/Customer.php';

use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Entities\Client;

use GingerPay\Payment\Tests\ClassSeparators\ConfigRepositoryBuilderSeparator;
use GingerPay\Payment\Tests\Mocks\Order;
use GingerPay\Payment\Tests\Mocks\OrderLines;
use GingerPay\Payment\Tests\Mocks\UrlProvider;
use GingerPay\Payment\Tests\Mocks\Customer;
use GingerPluginSdk\Tests\OrderStub;
use PHPUnit\Framework\TestCase;
use GingerPay\Payment\Tests\ClassSeparators\ServiceOrderBuilderSeparator;

class CreateOrderTest extends TestCase
{
    private $orderBuilder;
    private $order;
    private $urlProvider;
    private $orderLines;
    private $customerData;
    private $expectedArray;
    private $configRepository;

    private $client;

    public function setUp() : void
    {
        $this->client = new Client();

        $this->orderBuilder = new ServiceOrderBuilderSeparator();
        $this->order = new OrderStub();
        $this->urlProvider = new UrlProvider();
        $this->orderLines = new OrderLines();
        $this->customerData = Customer::getCustomerData();
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

    public function testGetTransactions()
    {
        $this->assertEquals($this->orderBuilder->getTransactions('ideal', null), [["payment_method" => 'ideal']], 'Function getTransactions  return not expected array');
    }

    public function testGetVersion()
    {
        $this->assertEquals($this->orderBuilder->productMetadata->getVersion(), '2.2.11', 'Function getVersion returned not expected string');
    }



    public function testGetUserAgent()
    {
        $this->assertEquals($this->orderBuilder->getUserAgent(), 'USER_AGENT', 'Function getUserAgent returned not expected string');
    }

    public function testGetExtraLines()
    {
        $expectedExtraLines = [
            "user_agent" => 'USER_AGENT',
            "platform_name" => "Magento2",
            "platform_version" => '2.2.11',
            "plugin_name" => (string)$this->client->getPluginName(),
            "plugin_version" => (string)$this->client->getPluginVersion()];
        $this->assertEquals($this->orderBuilder->getExtraLines(), $expectedExtraLines, 'Function getExtraLines returned not expected array');
    }

    public function testOrderCreation()
    {
        $orderArray = $this->orderBuilder->collectData($this->order, 'ideal', 'ginger_methods_ideal', $this->urlProvider, $this->orderLines, $this->customerData);
        $this->assertEquals($this->expectedArray, $orderArray, 'Order array does not match the expectation');
    }
}
