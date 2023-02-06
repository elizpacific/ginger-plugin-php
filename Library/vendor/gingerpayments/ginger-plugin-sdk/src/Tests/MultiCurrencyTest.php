<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Properties\Currency;
use PHPUnit\Framework\TestCase;

class MultiCurrencyTest extends TestCase
{
    /**
     * @var \GingerPluginSdk\Client
     */
    private Client $client;

    public function setUp(): void
    {
        $clientOptions = new \GingerPluginSdk\Properties\ClientOptions(
            endpoint: $_ENV["PUBLIC_API_URL"],
            useBundle: true,
            apiKey: getenv('GINGER_API_KEY')
        );
        $this->client = new Client(options: $clientOptions);
    }

    public function test_valid_response()
    {
        $response = $this->client->checkAvailabilityForPaymentMethodUsingCurrency(
            payment_method_name: 'ideal',
            currency: new Currency('EUR')
        );
        self::assertSame($response, true);
    }

    public function test_caching_currency()
    {
        $this->client->checkAvailabilityForPaymentMethodUsingCurrency(
            payment_method_name: 'ideal',
            currency: new Currency('EUR')
        );
        $content = strlen(file_get_contents($this->client::MULTI_CURRENCY_CACHE_FILE_PATH));
        self::assertGreaterThan(0, $content);
    }

    public function test_cache_path()
    {
        self::assertSame(
            realpath($this->client::MULTI_CURRENCY_CACHE_FILE_PATH),
            realpath(__DIR__ . "/../Assets/payment_method_currencies.json")
        );
    }

    public function test_removing_cache_file()
    {
        $this->client->checkAvailabilityForPaymentMethodUsingCurrency(
            payment_method_name: 'ideal',
            currency: new Currency('EUR')
        );

        $valid_file = file_exists($this->client::MULTI_CURRENCY_CACHE_FILE_PATH);

        $this->client->removeCachedMultiCurrency();

        $non_exist_file = file_exists($this->client::MULTI_CURRENCY_CACHE_FILE_PATH);

        self::assertNotSame(
            $valid_file,
            $non_exist_file
        );
    }
}
