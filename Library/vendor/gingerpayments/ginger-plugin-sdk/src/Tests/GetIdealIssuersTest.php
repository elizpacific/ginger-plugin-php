<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Properties\ClientOptions;
use PHPUnit\Framework\TestCase;

class GetIdealIssuersTest extends TestCase
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
    }

    public function test_get_ideal_issuers_valid()
    {
        self::expectNotToPerformAssertions();
        $this->client->getIdealIssuers();
    }
}