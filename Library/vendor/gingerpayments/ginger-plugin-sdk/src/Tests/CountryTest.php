<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    public function test_allow_valid_country()
    {
        $expected = 'NL';
        $real = new Country('NL');
        self::assertSame($expected, $real->get());
    }

    public function test_disallow_invalid_country()
    {
        self::expectException(OutOfPatternException::class);
        $test = new Country('Netherlands');
    }

    public function test_get_property()
    {
        self::assertSame(
            (new Country('LN'))->getPropertyName(),
            'country'
        );
    }
}
