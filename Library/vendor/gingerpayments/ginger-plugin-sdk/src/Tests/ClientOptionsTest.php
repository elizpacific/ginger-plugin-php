<?php

namespace GingerPluginSdk\Tests;

use ArgumentCountError;
use GingerPluginSdk\Exceptions\EmptyApiKeyException;
use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\ClientOptions;
use PHPUnit\Framework\TestCase;

class ClientOptionsTest extends TestCase
{
    public function test_allow_valid_client_options()
    {
        $expected = new ClientOptions(
            endpoint: 'test@endpoint.com',
            useBundle: false,
            apiKey: '123456'
        );
        self::assertSame((bool)$expected, true);
    }

    public function test_disallow_empty_api_key_client_options()
    {
        self::expectException(EmptyApiKeyException::class);
        $test = new ClientOptions(
            endpoint: 'test',
            useBundle: false,
            apiKey: ""
        );
    }
}
