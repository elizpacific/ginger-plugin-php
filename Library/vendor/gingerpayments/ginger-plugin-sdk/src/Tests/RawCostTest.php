<?php
declare(strict_types=1);

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Properties\RawCost;
use PHPUnit\Framework\TestCase;

class RawCostTest extends TestCase
{
    public function test_valid_money_type()
    {
        self::assertSame(
            expected: 100,
            actual: (new RawCost(1.0))->get()
        );
    }

    public function test_invalid_money_type()
    {
        self::expectException(\TypeError::class);
        new RawCost('1');
    }
}