<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Collections\AbstractCollection;
use GingerPluginSdk\Entities\Line;
use GingerPluginSdk\Entities\Order;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Currency;
use GingerPluginSdk\Properties\Percentage;
use GingerPluginSdk\Properties\RawCost;
use GingerPluginSdk\Properties\VatPercentage;
use PHPUnit\Framework\TestCase;

class UpdateOrderTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
    }

    public function test_update_line()
    {
        $order = OrderStub::getValidOrder();
        $expected = array_merge(
            $order->toArray(),
            [
                'order_lines' => [
                    [
                        'type' => 'physical',
                        'merchant_order_line_id' => '5',
                        'name' => 'Felix',
                        'quantity' => 1,
                        'amount' => 100,
                        'vat_percentage' => 5000,
                        'currency' => 'EUR'
                    ]
                ]
            ]);
        $order->getOrderLines()->getLine()->update(name: 'Felix');
        self::assertEqualsCanonicalizing(
            expected: $expected,
            actual: $order->toArray()
        );
    }

    public function test_update_order_line()
    {
        $order = OrderStub::getValidOrder();
        $expected = array_merge(
            $order->toArray(),
            [
                'order_lines' => [
                    [
                        'type' => 'physical',
                        'merchant_order_line_id' => '5',
                        'name' => 'Felix',
                        'quantity' => 1,
                        'amount' => 100,
                        'vat_percentage' => 5000,
                        'currency' => 'EUR'
                    ]
                ]
            ]);
        $order->getOrderLines()->updateLine(new Line(
                type: 'physical',
                merchantOrderLineId: "5",
                name: 'Felix',
                quantity: 1,
                amount: new Amount(new RawCost(1.00)),
                vatPercentage: new VatPercentage(new Percentage(50)),
                currency: new Currency(
                    'EUR'
                )
            )
        );
        self::assertEqualsCanonicalizing(
            expected: $expected,
            actual: $order->toArray()
        );
    }

    public function test_valid_update_call()
    {
        $this->client = new Client(
            options: OrderStub::getMockedClientOptions()
        );
        $order = $this->client->sendOrder(
            order: OrderStub::getValidOrder()
        );

        $order->getCustomer()->getAdditionalAddress()->update(['country' => 'QQ'], 1);
        self::assertSame(
            expected: 'QQ',
            actual: $this->client->updateOrder(
                order: $order
            )->getCustomer()->getAdditionalAddress()->get(1)->getCountry()->get()
        );
    }


    public function test_update_using_default_flow()
    {
        // Need to convert to array, before change the value
        $updated_order = OrderStub::getValidOrder()->toArray();
        $updated_order['order_lines'][0]['amount'] = 200;
        // Need to convert from array, after changing, again, to object
        $order = Client::fromArray(
            Order::class,
            $updated_order
        );
        self::assertSame(
            200,
            $order->getOrderLines()->getLine(0)->getAmount(),
        );
    }

    public function test_update_using_updated_flow()
    {
        self::assertSame(
            200,
            OrderStub::getValidOrder()->getOrderLines()->getLine()->update(amount: 200)->getAmount()
        );
    }

    public function test_update_using_collections()
    {
        $line = OrderStub::getValidLine()->update(amount: 300);
        self::assertSame(
            300,
            OrderStub::getValidOrder()->getOrderLines()->update($line->toArray())->getLine()->getAmount()
        );
    }
}