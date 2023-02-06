<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\Currency;
use PHPUnit\Framework\TestCase;

class CurrencyTest extends TestCase
{
    public function test_allow_valid_currency()
    {
        $test = new Currency('EUR');
        self::assertSame($test->get(), 'EUR');
    }

    public function test_disallow_invalid_currency()
    {
        self::expectException(OutOfPatternException::class);
        $test = new Currency('EU');
    }

    public function test_get_property()
    {
        self::assertSame(
            (new Currency('EUR'))->getPropertyName(),
            'currency'
        );
    }
}
