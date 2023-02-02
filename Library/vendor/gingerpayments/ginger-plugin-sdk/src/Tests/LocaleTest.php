<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\Locale;
use PHPUnit\Framework\TestCase;

class LocaleTest extends TestCase
{
    public function test_allow_valid_locale()
    {
        $expected = 'NL_en';
        $real = new Locale('NL_en');
        self::assertSame($expected, $real->get());
    }

    public function test_disallow_invalid_locale()
    {
        self::expectException(OutOfPatternException::class);
        $test = new Locale('Netherlands');
    }

    public function test_get_property()
    {
        self::assertSame(
            (new Locale('NL_nl'))->getPropertyName(),
            'locale'
        );
    }
}
