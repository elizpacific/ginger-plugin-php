<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Exceptions\OrderNotFoundException;
use GingerPluginSdk\Properties\ClientOptions;
use PHPUnit\Framework\TestCase;

class GetOrderTest extends TestCase
{
    private Client $client;

    public function setUp(): void
    {
        $this->client = new Client(
            new ClientOptions(
                endpoint: $_ENV["PUBLIC_API_URL"],
                useBundle: true,
                apiKey: getenv('GINGER_API_KEY')
            )
        );
    }

    public function test_order_not_found()
    {
        self::expectException(OrderNotFoundException::class);
        $this->client->getOrder('123');
    }

    /**
     * original flow : client -> get -> server -> return array
     * ginger-php-sdk : library client -> get -> from array -> ( original flow )
     * for tests : to array ( ginger-php-sdk flow ) ?= original flow
     */
    public function test_get_order()
    {
        $id = $_ENV["ORDER_ID_FOR_TESTS"];
        $expected = $this->client->getApiClient()->getOrder(id: $id);
        $real = $this->client->getOrder(
            id: $id
        )->toArray();
        array_multisort($real);
        array_multisort($expected);
        self::assertEquals(
            expected: $expected,
            actual: $real
        );
    }
}