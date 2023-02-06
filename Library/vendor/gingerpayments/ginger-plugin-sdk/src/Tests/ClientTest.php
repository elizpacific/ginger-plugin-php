<?php

namespace GingerPluginSdk\Tests;

class ClientTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        $_SERVER["HTTP_USER_AGENT"] = "PHPUnit Tests";
        $this->client = OrderStub::getValidClient();
    }

    public function test_get_user_agent()
    {
        self::assertSame(
            expected: 'PHPUnit Tests',
            actual: $this->client->getUserAgent()->get()
        );
    }

    public function test_get_platform_name()
    {
        self::assertSame(
            expected: 'PHPSTORM',
            actual: $this->client->getPlatformName()->get()
        );
    }

    public function test_get_platform_version()
    {
        self::assertSame(
            expected: '1',
            actual: $this->client->getPlatformVersion()->get()
        );
    }

    public function test_get_plugin_name()
    {
        self::assertSame(
            expected: 'ginger-plugin-sdk',
            actual: $this->client->getPluginName()->get()
        );
    }

    public function test_get_plugin_version()
    {
        self::assertSame(
            expected: '1.0.0',
            actual: $this->client->getPluginVersion()->get()
        );
    }
}