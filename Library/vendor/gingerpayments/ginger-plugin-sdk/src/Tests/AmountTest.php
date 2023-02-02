<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Client;
use GingerPluginSdk\Exceptions\OutOfDiapasonException;
use GingerPluginSdk\Properties\Amount;
use GingerPluginSdk\Properties\RawCost;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    public function test_valid_amount_creation_using_money_property()
    {
        self::assertSame(
            expected: 100,
            actual: (new Amount(
                new RawCost(
                    1.0
                )
            ))->get()
        );
    }

    public function test_valid_amount_creation_using_cents()
    {
        self::assertSame(
            expected: 100,
            actual: (new Amount(
                100)
            )->get()
        );
    }

    public function test_amount_creation_from_array()
    {
        self::assertSame(
            expected: 100,
            actual: Client::fromArray(Amount::class, [100])->get()
        );
    }

    public function test_out_of_diapason_amount()
    {
        self::expectException(OutOfDiapasonException::class);
        new Amount(
            new RawCost(0)
        );
    }
}