<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Exceptions\InvalidOrderStatusException;
use GingerPluginSdk\Properties\ClientOptions;
use GingerPluginSdk\Properties\Amount;
use PHPUnit\Framework\TestCase;

class RefundOrderTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client(
            new ClientOptions(
                endpoint: $_ENV["PUBLIC_API_URL"],
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY'))
        );
        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
    }

    public function test_invalid_refund_uncompleted()
    {
        self::expectException(InvalidOrderStatusException::class);
        $order_data = OrderStub::getValidOrder();
        $order_obj = $this->client->sendOrder(order: $order_data);
        $this->client->refundOrder(order_id: $order_obj->getId()?->get());
    }

    public function test_invalid_partial_refund_uncompleted()
    {
        self::expectException(InvalidOrderStatusException::class);
        $order_data = OrderStub::getValidOrder();
        $order_obj = $this->client->sendOrder(order: $order_data);
        $this->client->refundOrder(order_id: $order_obj->getId()?->get(),amount: new Amount(300));
    }
}