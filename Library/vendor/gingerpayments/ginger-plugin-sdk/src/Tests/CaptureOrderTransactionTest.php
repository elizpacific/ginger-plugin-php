<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Exceptions\InvalidOrderStatusException;
use GingerPluginSdk\Properties\ClientOptions;
use PHPUnit\Framework\TestCase;

class CaptureOrderTransactionTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client(
            options: new ClientOptions(
                endpoint: $_ENV["PUBLIC_API_URL"],
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY'))
        );
        $_SERVER["REMOTE_ADDR"] = "173.0.2.5";
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
    }

    public function test_capture_order_transaction_not_capturable()
    {
        $test_order = OrderStub::getValidOrder();
        self::assertFalse($test_order->getCurrentTransaction()->isCapturable());
    }

    /**
     * @throws \GingerPluginSdk\Exceptions\CaptureFailedException
     * @throws \Exception
     */
    public function test_only_completed_orders_could_be_captured()
    {
        self::expectException(InvalidOrderStatusException::class);
        $order = $this->client->sendOrder(
            order: OrderStub::getValidOrder()
        );
        $this->client->captureOrderTransaction($order->getId()->get());
    }
}