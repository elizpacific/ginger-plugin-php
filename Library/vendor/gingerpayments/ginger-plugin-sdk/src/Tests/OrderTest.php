<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\Currency;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private \GingerPluginSdk\Entities\Order $order;

    public function setUp(): void
    {
        $_SERVER["REMOTE_ADDR"] = 'test';
        $_SERVER["HTTP_USER_AGENT"] = 'test';
        $this->order = OrderStub::getValidOrder();
    }

    public function test_get_client()
    {
        self::assertSame(
            expected: 'client',
            actual: $this->order->getClient()->getPropertyName()
        );
    }

    public function test_get_amount()
    {
        self::assertSame(
            expected: 'amount',
            actual: $this->order->getAmount()->getPropertyName()
        );
    }

    public function test_get_merchant_order_id()
    {
        $old_order = $this->order->toArray();
        $old_order['merchant_order_id'] = 5;
        $updated_order = Client::fromArray(
            Order::class,
            $old_order
        );
        self::assertSame(
            expected: 'merchant_order_id',
            actual: $updated_order->getMerchantOrderId()->getPropertyName()
        );
    }

    public function test_get_payment_url()
    {
        $client = new Client(
            OrderStub::getMockedClientOptions()
        );
        $order = $client->sendOrder(order: OrderStub::getValidOrder());
        self::assertSame(
            expected: 'string',
            actual: gettype($order->getPaymentUrl())
        );
    }

    public function test_get_webhook_url()
    {
        $order = new Order(
            currency: new Currency('EUR'),
            amount: new Amount(500),
            transactions: OrderStub::getValidTransactions(),
            customer: OrderStub::getValidCustomer(),
            orderLines: OrderStub::getValidOrderLines(),
            extra: OrderStub::getValidExtra(),
            client: OrderStub::getValidClient(),
            webhook_url: 'http://test.com/web',
            description: 'GingerPluginSDKAutomaticTest'
        );
        self::assertSame(
            expected: 'http://test.com/web',
            actual: $order->getWebhookUrl()->get()
        );
    }

    public function test_get_return_url()
    {
        $order = new Order(
            currency: new Currency('EUR'),
            amount: new Amount(500),
            transactions: OrderStub::getValidTransactions(),
            customer: OrderStub::getValidCustomer(),
            orderLines: OrderStub::getValidOrderLines(),
            extra: OrderStub::getValidExtra(),
            client: OrderStub::getValidClient(),
            webhook_url: 'http://test.com/web',
            return_url: 'http://test.com/return',
            description: 'GingerPluginSDKAutomaticTest'
        );
        self::assertSame(
            expected: 'http://test.com/return',
            actual: $order->getReturnUrl()->get()
        );
    }
}