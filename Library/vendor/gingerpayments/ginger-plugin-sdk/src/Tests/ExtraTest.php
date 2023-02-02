<?php

namespace GingerPluginSdk\Tests;

use GingerPluginSdk\Entities\Extra;
use PHPUnit\Framework\TestCase;

class ExtraTest extends TestCase
{
    public function test_valid_add_new_attribute()
    {
        $expected = [
            'sw_order_id' => 5
        ];
        $real = new Extra(["sw_order_id" => 5]);
        self::assertSame(
            $expected,
            $real->toArray()
        );
    }

    public function test_invalid_add_new_attribute()
    {
        self::expectException(\TypeError::class);
        $sw_order_id = 5;
        $real = new Extra($sw_order_id);

    }

    public function test_get_property()
    {
        self::assertSame(
            (new Extra(['test' => 5]))->getPropertyName(),
            'extra'
        );
    }

    public function test_update_extra()
    {
        $extra = new Extra(
            ['test' => 5]
        );
        self::assertSame(
            expected: array_replace(
                $extra->toArray(),
                ['test' => 4]
            ),
            actual: $extra->update(test: 4)->toArray()
        );
    }
}
