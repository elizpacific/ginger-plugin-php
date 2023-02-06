<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfPatternException;
use GingerPluginSdk\Properties\Birthdate;
use PHPUnit\Framework\TestCase;

class BirthdateTest extends TestCase
{
    public function test_allows_valid_date()
    {
        $Birthdate = new Birthdate('2020-01-01');

        self::assertSame('2020-01-01', (string)$Birthdate);
    }

    public function test_disallows_invalid_date()
    {
        self::expectException(OutOfPatternException::class);
        $Birthdate = new Birthdate('not-a-date');
    }

    public function test_get_property()
    {
        self::assertSame(
            (new Birthdate("2021-08-09"))->getPropertyName(),
            'birthdate'
        );
    }
}