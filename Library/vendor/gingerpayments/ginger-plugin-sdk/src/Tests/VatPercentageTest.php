<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Properties\Percentage;
use GingerPluginSdk\Properties\VatPercentage;
use PHPUnit\Framework\TestCase;

class VatPercentageTest extends TestCase
{
    public function test_valid_creation_using_percentage_property()
    {
        self::assertSame(
            expected: 9500,
            actual: (new VatPercentage(
                value: new Percentage(
                    95
                )
            ))->get()
        );
    }

    public function test_valid_creation_using_multiplied_value()
    {
        self::assertSame(
            expected: 9500,
            actual: (new VatPercentage(
                value: 9500)
            )->get()
        );
    }

    public function test_invalid_diapason_value()
    {
        self::expectException(OutOfDiapasonException::class);
        new VatPercentage(new Percentage(101));
    }
}